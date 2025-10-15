<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\HeroSlidersController;
use App\Http\Controllers\ProfileController;
use App\Models\HeroSliders;
use App\Models\HomePage;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'sections' => HomePage::orderBy('order', 'ASC')->get(),
        'slides' => HeroSliders::orderBy('order', 'ASC')->get(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
    Route::get('/category/{category}', [ArticlesController::class, 'index'])->name('reflections');
    Route::get('/category/{category}/{slug}', [ArticlesController::class, 'show'])->name('reflections');
        Route::post('/save/subscriber', [UserController::class, 'storeSubscriber'])->name('subscribers.store');



Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/admin/posts', [ArticlesController::class, 'adminPostsIndex'])->name('admin.post.view');
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.get');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('categories.get');
        Route::post('/category/update/{category}', [CategoryController::class, 'update'])->name('categories.get');
        Route::delete('/category/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.get');


        Route::get('/admin/staff', [UserController::class, 'allStaff'])->name('staff.get');
        Route::post('/admin/add/staff', [UserController::class, 'storeStaff'])->name('staff.get');
        Route::delete('/admin/staff/{staff}', [UserController::class, 'destroyStaff'])->name('staff.destroy');
        Route::post('/admin/staff/{staff}', [UserController::class, 'updateStaff'])->name('staff.destroy');
        Route::get('/admin/subscribers', [UserController::class, 'allSubscribers'])->name('subscribers.get');


        Route::get('/admin/emails', [EmailController::class, 'index'])->name('emails.get');
        Route::get('/admin/homepage', [HomePageController::class, 'index'])->name('home.get');
    Route::get('/admin/landing_sections', [HomePageController::class, 'getSections'])->name('home.sections.get');

    Route::get('/admin/hero_sliders', [HeroSlidersController::class, 'index'])->name('hero_sliders.get');
    Route::post('/admin/hero_slider', [HeroSlidersController::class, 'store'])->name('hero_slider.get');
    Route::delete('/admin/hero_slider/{slide}', [HeroSlidersController::class, 'destroy'])->name('delete.hero_slider.get');


        Route::put('/admin/landing_sections/{section}', [HomePageController::class, 'update'])->name('home.get');
        Route::delete('/admin/landing_sections/{section}', [HomePageController::class, 'destroy'])->name('home.get');
        Route::post('/admin/landing_sections', [HomePageController::class, 'store'])->name('home.get');

        Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
        Route::get('/homepage', [HomePageController::class, 'index'])->name('homepage.index');
});

require __DIR__.'/auth.php';
