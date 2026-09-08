<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IdentifyTenant;
use App\Http\Middleware\SetLocale;
use App\Models\Website;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware([IdentifyTenant::class, SetLocale::class])->group(function () {
    
    // SEO Sitemap
    Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

    // Define routes function to avoid duplication
    $tenantRoutes = function() {
        Route::get('/tours', function () {
            $website = app(\App\Models\Website::class);
            $website->load('tours');
            return view('home', compact('website'));
        })->name('tours.index');

        Route::get('/about', function () {
            $website = app(\App\Models\Website::class);
            return view('about', compact('website'));
        })->name('about');

        Route::get('/contact', function () {
            $website = app(\App\Models\Website::class);
            return view('contact', compact('website'));
        })->name('contact');
        
        // Dynamic localized slug routing (e.g. /fr/paris-tour-eiffel)
        Route::get('/{slug}', function (string $slugOrLocale, string $slug = null) {
            $website = app(\App\Models\Website::class);
            
            // If slug is provided, $slugOrLocale was the locale. 
            // If $slug is null, $slugOrLocale is the actual slug.
            $actualSlug = $slug ?: $slugOrLocale;
            
            // Extract ID from slug like 'tour-1'
            $id = str_replace('tour-', '', $actualSlug);
            $tour = $website->tours()->find($id);
            
            if (!$tour) {
                // Fallback to first for demo
                $tour = $website->tours()->first();
                if (!$tour) abort(404);
            }

            return view('tour-detail', compact('website', 'tour'));
        })->name('page.show');
        // API Endpoints
        Route::get('/api/availability/{tour}', [\App\Http\Controllers\TourController::class, 'availability'])->name('api.availability');
        
        // Cart & Checkout
        Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
        Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/checkout/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');
    };

    // 1. With locale prefix (e.g. /fr/about)
    Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], $tenantRoutes);

    // 2. Without locale prefix (e.g. /about) - DEFINED LAST SO IT WINS THE ROUTE NAME
    Route::group([], $tenantRoutes);

    /**
     * Strict Root Fallback
     */
    Route::get('/', function () {
        $website = app(\App\Models\Website::class);
        $website->load('tours');
        return view('home', compact('website'));
    })->name('home');

    // Customer Account Routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';

});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/tours', [\App\Http\Controllers\AdminController::class, 'tours'])->name('tours.index');
    Route::post('/tours/save', [\App\Http\Controllers\AdminController::class, 'saveTour'])->name('tours.save');
    Route::get('/bookings', [\App\Http\Controllers\AdminController::class, 'bookings'])->name('bookings.index');
});
