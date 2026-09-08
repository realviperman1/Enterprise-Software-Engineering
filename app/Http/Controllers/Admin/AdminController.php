<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\WebsiteRepositoryInterface;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminController extends Controller
{
    /**
     * Inject dependencies via PHP 8 property promotion.
     */
    public function __construct(
        private readonly WebsiteRepositoryInterface $websiteRepository,
        private readonly ContentService $contentService
    ) {}

    /**
     * Display the centralized dashboard with all managed websites.
     *
     * @return View
     */
    public function index(): View
    {
        // Fetch websites using the repository pattern.
        $websites = $this->websiteRepository->all();

        return view('admin.dashboard', compact('websites'));
    }

    /**
     * Sync shared content to the selected target websites.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function syncContent(Request $request): RedirectResponse
    {
        // Validate incoming request data
        $validated = $request->validate([
            'type'          => ['required', 'string', 'max:100'],
            'body'          => ['required', 'string'],
            'website_ids'   => ['required', 'array', 'min:1'],
            'website_ids.*' => ['integer', 'exists:websites,id'],
        ]);

        try {
            // Execute business logic through the service layer
            $this->contentService->syncSharedContent(
                $validated['website_ids'],
                [
                    'type' => $validated['type'],
                    'body' => $validated['body'],
                ]
            );

            return back()->with('success', 'Content successfully synchronized across the selected websites.');
        } catch (Throwable $e) {
            Log::error('AdminController@syncContent Failed', [
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'An error occurred while syncing content. Please try again.');
        }
    }
}

