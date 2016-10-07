<?php

namespace App\Providers;

use App\Products\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('front.partials.navbar', function ($view) {
            $menuCategories = Category::orderBy('name')->get();

            return $view->with(compact('menuCategories'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
