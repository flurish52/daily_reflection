<?php

namespace App\Providers;

use App\Models\Archive;
use App\Models\Articles;
use App\Models\Category;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Inertia::share([
            'categories' => function () {
                return Category::select('id', 'name', 'slug')->orderBy('name', 'ASC')->get();
            },
            'archives' => function () {
                return Archive::select('id', 'name', 'slug')->orderBy('name', 'ASC')->get();
            },
            'posts' => function () {
                return Articles::select('id', 'title', 'slug')->orderBy('created_at', 'DESC')->get();
            },
        ]);
    }
}
