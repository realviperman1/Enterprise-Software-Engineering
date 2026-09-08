<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    public function __construct(
        private readonly TenantService $tenantService
    ) {}

    /**
     * Compute a strictly scoped session key based on the active Tenant ID.
     * Prevents cart crossover if a user browses multiple domains sharing the same backend.
     */
    private function getSessionKey(): string
    {
        return 'cart_tenant_' . $this->tenantService->getTenantId();
    }

    /**
     * Add an item to the tenant's isolated cart.
     */
    public function add(int $tourId, int $quantity, string $date): void
    {
        $key = $this->getSessionKey();
        $cart = Session::get($key, []);
        
        $cartId = $tourId . '_' . $date;
        
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $quantity;
        } else {
            $cart[$cartId] = [
                'tour_id' => $tourId,
                'quantity' => $quantity,
                'date' => $date
            ];
        }
        
        Session::put($key, $cart);
    }

    /**
     * Retrieve the tenant's isolated cart.
     */
    public function get(): array
    {
        return Session::get($this->getSessionKey(), []);
    }

    /**
     * Remove an item from the tenant's isolated cart.
     */
    public function remove(string $cartId): void
    {
        $key = $this->getSessionKey();
        $cart = Session::get($key, []);
        
        if (isset($cart[$cartId])) {
            unset($cart[$cartId]);
            Session::put($key, $cart);
        }
    }

    /**
     * Clear only this specific tenant's cart.
     */
    public function clear(): void
    {
        Session::forget($this->getSessionKey());
    }
}

