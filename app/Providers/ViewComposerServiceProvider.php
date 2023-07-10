<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // if (Schema::hasTable('articles')) {
        //     view()->composer('navbar', function ($view) {
        //         $view->with('latest', Article::latest()->first());
        //     });
        // }
    }
}
