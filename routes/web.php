<?php

use App\Http\Controllers\Backend\GoogleAnalyticsController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ProjectController as BackendProjectController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\ProjectController as FrontendProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth forms
Auth::routes();

// Backend
Route::group([
    'prefix' => 'admin',
    'as' => 'backend.',
    'middleware' => 'auth'
], function () {
    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'show')->name('profile.show');
        Route::match(['put', 'patch'], 'profile', 'update')->name('profile.update');
        Route::delete('profile', 'destroy')->name('profile.destroy');
    });

    // Google Analytics
    Route::controller(GoogleAnalyticsController::class)->group(function () {
        Route::get('google-analytics/overview', 'overview')->name('google-analytics.overview');
        Route::get('google-analytics/urls', 'urls')->name('google-analytics.urls');
        Route::get('google-analytics/locations', 'locations')->name('google-analytics.locations');
        Route::get('google-analytics/languages', 'languages')->name('google-analytics.languages');
        Route::get('google-analytics/browsers', 'browsers')->name('google-analytics.browsers');
        Route::get('google-analytics/operating-systems', 'operatingSystems')->name('google-analytics.operating-systems');
        Route::get('google-analytics/device-categories', 'deviceCategories')->name('google-analytics.device-categories');

        // User is admin and analytics viewID is set
        Route::middleware('can:sync')->group(function () {
            Route::get('google-analytics/sync/overview', 'syncOverview')->name('google-analytics.sync.overview');
            Route::get('google-analytics/sync/urls', 'syncUrls')->name('google-analytics.sync.urls');
            Route::get('google-analytics/sync/locations', 'syncLocations')->name('google-analytics.sync.locations');
            Route::get('google-analytics/sync/languages', 'syncLanguages')->name('google-analytics.sync.languages');
            Route::get('google-analytics/sync/browsers', 'syncBrowsers')->name('google-analytics.sync.browsers');
            Route::get('google-analytics/sync/operating-systems', 'syncOperatingSystems')->name('google-analytics.sync.operating-systems');
            Route::get('google-analytics/sync/device-categories', 'syncDeviceCategories')->name('google-analytics.sync.device-categories');
        });
    });

    // Projects
    Route::controller(BackendProjectController::class)->group(function () {
        Route::get('projects', 'index')->name('projects.index');

        // User is admin
        Route::middleware('can:manage_system')->group(function () {
            Route::get('projects/create', 'create')->name('projects.create');
            Route::post('projects', 'store')->name('projects.store');
            Route::get('projects/{project}/edit', 'edit')->name('projects.edit');
            Route::match(['put', 'patch'], 'projects/{project}', 'update')->name('projects.update');
            Route::delete('projects/{project}', 'destroy')->name('projects.destroy');
            Route::patch('projects/{project}/restore', 'restore')->name('projects.restore')->withTrashed();
            Route::delete('projects/{project}/force-delete', 'forceDelete')->name('projects.force-delete')->withTrashed();
            Route::post('projects/reorder', 'reorder')->name('projects.reorder');
        });
    });

    // Users
    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('users.index');

        // User is admin
        Route::middleware('can:manage_system')->group(function () {
            Route::get('users/create', 'create')->name('users.create');
            Route::post('users', 'store')->name('users.store');
            Route::get('users/{user}/edit', 'edit')->name('users.edit');
            Route::match(['put', 'patch'], 'users/{user}', 'update')->name('users.update');
            Route::delete('users/{user}', 'destroy')->name('users.destroy');
            Route::patch('users/{user}/restore', 'restore')->name('users.restore')->withTrashed();
            Route::delete('users/{user}/force-delete', 'forceDelete')->name('users.force-delete')->withTrashed();
        });
    });
});

// Frontend
Route::name('frontend.')->group(function () {
    // Projects
    Route::controller(FrontendProjectController::class)->group(function () {
        Route::get('/', 'index')->name('projects.index');
        Route::get('/projects/{project}', 'show')->name('projects.show');
    });
});
