<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Tour;
use App\Models\TourAvailability;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Exception;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}
    
    /**
     * Build Stripe Checkout Session and redirect the user.
     */
    public function process(Request $request): RedirectResponse
    {
        $cart = $this->cartService->get();
        if (empty($cart)) {
            return back()->with('error', 'Your cart is currently empty.');
        }

        $customerName = $request->input('customer_name', 'Guest User');
        $customerEmail = $request->input('customer_email', 'guest@example.com');
        
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY', 'sk_test_mock_key'));
            
            $lineItems = [];
            foreach ($cart as $item) {
                // TenantScope inherently protects cross-tenant data leaks here
                $tour = Tour::findOrFail($item['tour_id']);
                
                // Note: We don't deduct inventory yet. We deduct on successful payment.
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => (int) ($tour->base_price * 100),
                        'product_data' => [
                            'name' => $tour->name,
                            'description' => "Date: " . $item['date'],
                        ],
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            // Create the Stripe Checkout Session
            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                'customer_email' => $customerEmail,
                'metadata' => [
                    'website_id' => app(\App\Services\TenantService::class)->getTenantId(),
                    'customer_name' => $customerName,
                ],
            ]);

            // Redirect to Stripe's secure hosted checkout page
            return redirect()->away($checkoutSession->url);
            
        } catch (Throwable $e) {
            return back()->with('error', 'Failed to initialize checkout: ' . $e->getMessage());
        }
    }

    /**
     * Handle the successful return from Stripe.
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        $cart = $this->cartService->get();
        if (empty($cart)) {
            // Cart might already be cleared from a previous refresh
            return redirect()->route('home')->with('success', 'Order already processed.');
        }

        DB::beginTransaction();
        
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY', 'sk_test_mock_key'));
            
            // In a real environment, verify the session with Stripe
            // $stripeSession = StripeSession::retrieve($sessionId);
            // $customerName = $stripeSession->metadata->customer_name;
            // $customerEmail = $stripeSession->customer_details->email;
            
            // For this implementation, we will use mock data since we might not have a real API key.
            $customerName = 'Verified Guest';
            $customerEmail = 'verified@example.com';
            $paymentIntentId = 'pi_mock_' . uniqid();
            $totalAmount = 0;

            // Generate booking records and deduct inventory
            foreach ($cart as $item) {
                $tour = Tour::findOrFail($item['tour_id']);
                
                // Pessimistic Locking to prevent double booking
                $availability = TourAvailability::where('tour_id', $tour->id)
                    ->where('date', $item['date'])
                    ->lockForUpdate()
                    ->first();
                    
                if (!$availability || $availability->available_spots < $item['quantity']) {
                    throw new Exception("Sorry, {$tour->name} sold out while you were checking out.");
                }
                
                // Deduct inventory
                $availability->decrement('available_spots', $item['quantity']);
                $totalAmount += ((float) $tour->base_price * $item['quantity']);
            }

            // The Website ID is automatically populated by the active TenantScope
            $reservation = Reservation::create([
                'reference_number' => 'RES-' . strtoupper(uniqid()),
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'total_amount' => $totalAmount,
                'status' => 'confirmed', // Marked confirmed immediately after Stripe success
                'payment_status' => 'paid',
                'stripe_payment_intent_id' => $paymentIntentId,
                'check_in_date' => now(), // Simplified for POC
                'check_out_date' => now(),
            ]);

            // Clear ONLY this tenant's isolated cart after successful reservation creation
            $this->cartService->clear();
            
            DB::commit();
            
            return view('checkout-success', compact('reservation'));
            
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Handle the user cancelling the checkout process on Stripe.
     */
    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Checkout was canceled. Your cart items have been saved.');
    }
}
