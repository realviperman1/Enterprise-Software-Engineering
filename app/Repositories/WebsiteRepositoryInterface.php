<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Website;

interface WebsiteRepositoryInterface
{
    /**
     * Get all websites.
     *
     * @return Collection<int, Website>
     */
    public function all(): Collection;

    /**
     * Get all websites associated with a specific shared content ID.
     *
     * @param int $contentId
     * @return Collection<int, Website>
     */
    public function getWebsitesBySharedContent(int $contentId): Collection;
}

