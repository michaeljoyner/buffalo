<?php

namespace App\Providers;

use App\Products\Category;
use App\Sourcing\Supplier;
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

        View::composer('admin.forms.modals.productsupply', function ($view) {
            $suppliers = Supplier::orderBy('name')->get();

            return $view->with(compact('suppliers'));
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
