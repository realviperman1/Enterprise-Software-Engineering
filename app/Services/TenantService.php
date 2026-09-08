<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Website;
use RuntimeException;

class TenantService
{
    private ?Website $currentWebsite = null;

    /**
     * Set the active tenant for the current request cycle.
     */
    public function setTenant(Website $website): void
    {
        $this->currentWebsite = $website;
    }

    /**
     * Get the active tenant.
     *
     * @throws RuntimeException if no tenant is set.
     */
    public function getTenant(): Website
    {
        if (!$this->currentWebsite) {
            throw new RuntimeException('Tenant has not been identified for this request context.');
        }

        return $this->currentWebsite;
    }

    /**
     * Get the active tenant ID.
     */
    public function getTenantId(): int
    {
        return $this->getTenant()->id;
    }

    /**
     * Check if a tenant has been identified.
     */
    public function isIdentified(): bool
    {
        return $this->currentWebsite !== null;
    }
}
