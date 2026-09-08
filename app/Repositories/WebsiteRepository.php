<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Collection;

class WebsiteRepository implements WebsiteRepositoryInterface
{
    public function __construct(
        private readonly Website $model
    ) {}

    /**
     * Get all managed websites.
     *
     * @return Collection<int, Website>
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get all websites associated with a specific shared content ID.
     *
     * @param int $contentId
     * @return Collection<int, Website>
     */
    public function getWebsitesBySharedContent(int $contentId): Collection
    {
        return $this->model->newQuery()
            ->whereHas('sharedContents', function ($query) use ($contentId) {
                $query->where('shared_contents.id', $contentId);
            })
            ->get();
    }
}

