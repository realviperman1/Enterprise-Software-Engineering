<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * Display the tenant's shopping cart.
     */
    public function index()
    {
        $cartItems = $this->cartService->get();
        $tourIds = collect($cartItems)->pluck('tour_id')->unique();
        
        // TenantScope automatically scopes this query to the current website
        $tours = Tour::whereIn('id', $tourIds)->get()->keyBy('id');
        
        $total = 0;
        $enrichedCart = [];
        
        foreach ($cartItems as $cartId => $item) {
            if (!isset($tours[$item['tour_id']])) continue;
            
            $tour = $tours[$item['tour_id']];
            $subtotal = $tour->base_price * $item['quantity'];
            $total += $subtotal;
            
            $enrichedCart[$cartId] = [
                'tour' => $tour,
                'quantity' => $item['quantity'],
                'date' => $item['date'],
                'subtotal' => $subtotal,
            ];
        }
        
        // Pass $website explicitly to ensure layouts/app.blade.php doesn't throw Undefined variable $website
        $website = app(\App\Models\Website::class);
        return view('cart', compact('enrichedCart', 'total', 'website'));
    }

    /**
     * Add an item to the tenant-isolated cart.
     */
    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tour_id' => 'required|integer|exists:tours,id',
            'selected_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->add(
            (int) $validated['tour_id'], 
            (int) $validated['quantity'], 
            $validated['selected_date']
        );

        return redirect()->route('cart.index')->with('success', __('Successfully added to your cart.'));
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request): RedirectResponse
    {
        $request->validate(['cart_id' => 'required|string']);
        $this->cartService->remove($request->input('cart_id'));
        return back()->with('success', __('Item removed from cart.'));
    }
}
