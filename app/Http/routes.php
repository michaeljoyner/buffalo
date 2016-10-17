<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'PagesController@home');

Route::get('categories', 'ProductsController@categories');
Route::get('categories/{slug}', 'ProductsController@category');
Route::get('subcategories/{slug}', 'ProductsController@subcategory');
Route::get('productgroups/{slug}', 'ProductsController@productGroups');
Route::get('products/{slug}', 'ProductsController@product');

Route::get('services', 'PagesController@services');

Route::get('about', 'PagesController@about');

Route::get('inquiry', 'PagesController@cart');
Route::get('enquire', 'CheckoutController@show');

Route::get('news', 'NewsController@index');
Route::get('news/{slug}', 'NewsController@show');

Route::get('contact', 'PagesController@contact');
Route::post('contact', 'ContactController@sendSiteMessage');

Route::get('search', 'ProductSearchResultsController@index');

// Authentication Routes...
Route::get('admin/login', 'Auth\LoginController@showLoginForm');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout');

// Registration Routes...
Route::post('admin/users/register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('admin/password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('admin/password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('admin/password/reset', 'Auth\PasswordController@reset');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('admin/users/password/reset', 'Auth\ResetPasswordController@showLoggedInUserPasswordReset');
Route::post('admin/users/password/reset', 'Auth\ResetPasswordController@loggedInUserReset');

//misc api
Route::get('api/slides', 'BannerSlidesController@index');

//shopping cart routes
Route::get('api/cart/items', 'ShoppingCartController@index');
Route::get('api/cart/summary', 'ShoppingCartController@summary');
Route::post('api/cart/items', 'ShoppingCartController@store');
Route::post('api/cart/items/{product}', 'ShoppingCartController@update');
Route::delete('api/cart/items/{product}', 'ShoppingCartController@remove');

//checkout routes
Route::post('checkout', 'CheckoutController@doCheckout');

//contact form


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::group(['middleware' => 'auth', 'bindings'], function () {
        Route::get('/', 'PagesController@dashboard');

        Route::get('users', 'UsersController@index');
        Route::get('users/{user}/edit', 'UsersController@edit');
        Route::post('users/{user}', 'UsersController@update');
        Route::delete('users/{user}', 'UsersController@delete');

        Route::get('blog/posts', 'BlogPostsController@index');
        Route::get('blog/posts/create', 'BlogPostsController@create');
        Route::post('blog/posts', 'BlogPostsController@store');
        Route::get('blog/posts/{post}/edit', 'BlogPostsController@edit');
        Route::post('blog/posts/{post}', 'BlogPostsController@update');
        Route::delete('blog/posts/{post}', 'BlogPostsController@delete');

        Route::get('blog/posts/{post}/images', 'PostsFeaturedImageController@index');
        Route::get('blog/posts/{post}/images/featured/edit', 'PostsFeaturedImageController@edit');
        Route::post('blog/posts/{post}/images/featured', 'PostsFeaturedImageController@store');
        Route::post('blog/posts/{post}/images/featured/upload', 'PostFeaturedImageDirectUploadController@store');

        Route::post('blog/posts/{post}/images', 'BlogPostImagesController@store');
        Route::post('blog/posts/{post}/publish', 'BlogPostsController@publish');

        Route::post('categories/{category}/products', 'CategoryProductsController@store');
        Route::post('subcategories/{subcategory}/products', 'SubcategoryProductsController@store');
        Route::post('productgroups/{productGroup}/products', 'ProductGroupProductsController@store');

        Route::get('categories', 'CategoriesController@index');
        Route::get('categories/{category}/edit', 'CategoriesController@edit');
        Route::get('categories/{category}', 'CategoriesController@show');
        Route::post('categories', 'CategoriesController@store');
        Route::post('categories/{category}', 'CategoriesController@update');
        Route::delete('categories/{category}', 'CategoriesController@delete');

        Route::post('categories/{category}/image', 'CategoryImageController@store');

        Route::post('categories/{category}/subcategories', 'SubcategoriesController@store');

        Route::get('subcategories/{subcategory}', 'SubcategoriesController@show');
        Route::get('subcategories/{subcategory}/edit', 'SubcategoriesController@edit');
        Route::post('subcategories/{subcategory}', 'SubcategoriesController@update');
        Route::delete('subcategories/{subcategory}', 'SubcategoriesController@delete');

        Route::post('subcategories/{subcategory}/productgroups', 'ProductGroupsController@store');

        Route::get('productgroups/{productGroup}', 'ProductGroupsController@show');
        Route::get('productgroups/{productGroup}/edit', 'ProductGroupsController@edit');
        Route::post('productgroups/{productGroup}', 'ProductGroupsController@update');
        Route::delete('productgroups/{productGroup}', 'ProductGroupsController@delete');

        Route::get('products/search', 'ProductsSearchController@show');
        Route::post('api/products/search', 'ProductsSearchController@search');

        Route::get('products/{product}', 'ProductsController@show');
        Route::get('products/{product}/edit', 'ProductsController@edit');
        Route::post('products/{product}/availability', 'ProductAvailabilityController@update');
        Route::post('products/{product}', 'ProductsController@update');
        Route::delete('products/{product}', 'ProductsController@delete');

        Route::post('products/{product}/image', 'ProductImagesController@store');

        Route::get('orders', 'OrdersController@index');
        Route::get('orders/archived', 'OrdersController@archived');
        Route::get('orders/{order}', 'OrdersController@show');
        Route::post('orders/{order}/archiving', 'OrdersController@setArchiveStatus');

        Route::get('slides', 'SlidesController@index');
        Route::get('slides/sort', 'SlidesOrderController@edit');
        Route::get('slides/create', 'SlidesController@create');
        Route::get('slides/{slide}/edit', 'SlidesController@edit');
        Route::post('api/slides/order', 'SlidesOrderController@update');
        Route::post('api/slides/{slide}', 'SlidesController@update');
        Route::delete('slides/{slide}', 'SlidesController@delete');

        Route::post('slides/{slide}/media', 'SlidesMediaController@store');

        Route::post('slides/{slide}/publishing', 'SlidesPublishingController@update');

        Route::get('/sitelinks', 'SiteLinkController@index');

        //facebook login
        Route::get('facebook/login', 'FacebookAuthController@login');
        Route::get('facebook/callback', 'FacebookAuthController@callback');

        Route::get('social', function() {
            return view('admin.social.index');
        });
        Route::get('social/facebook/user', 'FacebookUserController@fetchCurrent');
        Route::post('social/facebook/user/{facebookUser}/share', 'FacebookUserController@setSharingStatus');

        Route::get('twitter/login', 'TwitterAuthController@login');
        Route::get('twitter/callback', 'TwitterAuthController@callback');

        Route::get('social/twitter/user', 'TwitterUserController@fetchUser');
        Route::post('social/twitter/user/{twitterUser}/share', 'TwitterUserController@setSharingStatus');

        Route::get('googleplus/login', 'GooglePlusAuthController@login');
        Route::get('googleplus/callback', 'GooglePlusAuthController@callback');

        Route::get('social/googleplus/user', 'GooglePlusUserController@fetchUser');
        Route::post('social/googleplus/user/{googlePlusUser}/share', 'GooglePlusUserController@setSharingStatus');

    });

});

