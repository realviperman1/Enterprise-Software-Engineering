<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SharedContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContentService
{
    public function __construct(
        private readonly SharedContent $sharedContentModel
    ) {}

    /**
     * Securely attach or update centralized content across multiple websites.
     * Prevents data duplication by utilizing updateOrCreate and sync().
     *
     * @param array<int> $websiteIds
     * @param array{type: string, body: string} $contentData
     * @return SharedContent
     * @throws Throwable
     */
    public function syncSharedContent(array $websiteIds, array $contentData): SharedContent
    {
        try {
            return DB::transaction(function () use ($websiteIds, $contentData) {
                /** @var SharedContent $content */
                $content = $this->sharedContentModel->updateOrCreate(
                    ['type' => $contentData['type']],
                    ['body' => $contentData['body']]
                );

                // sync() automatically handles detaching missing and attaching new IDs
                // without creating duplicates in the pivot table.
                $content->websites()->sync($websiteIds);

                return $content->load('websites');
            });
        } catch (Throwable $e) {
            Log::error('Failed to sync shared content.', [
                'error' => $e->getMessage(),
                'website_ids' => $websiteIds,
                'content_data' => $contentData
            ]);
            
            throw $e;
        }
    }
}

