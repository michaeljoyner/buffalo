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

Route::get('/faqs', 'PagesController@faqs');
Route::get('thanks', 'PagesController@thanks');

Route::get('news', 'NewsController@index');
Route::get('news/{slug}', 'NewsController@show');

Route::get('contact', 'PagesController@contact');
Route::post('contact', 'ContactController@sendSiteMessage');

Route::get('search', 'ProductSearchResultsController@index');


Route::get('legal/privacy', 'PagesController@privacy');
Route::get('legal/terms', 'PagesController@terms');
// Authentication Routes...
Route::get('admin/login', 'Auth\LoginController@showLoginForm');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout');

// Registration Routes...
Route::post('admin/users/register', 'Auth\RegisterController@register')->middleware('superauth');

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

        Route::get('users', 'UsersController@index')->middleware('superauth');
        Route::get('users/{user}/edit', 'UsersController@edit')->middleware('superauth');
        Route::post('users/{user}', 'UsersController@update')->middleware('superauth');
        Route::delete('users/{user}', 'UsersController@delete')->middleware('superauth');

        Route::get('blog/posts', 'BlogPostsController@index');
        Route::get('blog/posts/create', 'BlogPostsController@create');
        Route::post('blog/posts', 'BlogPostsController@store');
        Route::get('blog/posts/{post}/edit', 'BlogPostsController@edit');
        Route::post('blog/posts/{post}', 'BlogPostsController@update');
        Route::delete('blog/posts/{post}', 'BlogPostsController@delete');

        Route::get('blog/posts/{post}/images', 'PostsFeaturedImageController@index')->middleware('superauth');
        Route::get('blog/posts/{post}/images/featured/edit',
            'PostsFeaturedImageController@edit')->middleware('superauth');
        Route::post('blog/posts/{post}/images/featured', 'PostsFeaturedImageController@store')->middleware('superauth');
        Route::post('blog/posts/{post}/images/featured/upload',
            'PostFeaturedImageDirectUploadController@store')->middleware('superauth');

        Route::post('blog/posts/{post}/images', 'BlogPostImagesController@store')->middleware('superauth');
        Route::post('blog/posts/{post}/publish', 'BlogPostsController@publish')->middleware('superauth');

        Route::post('categories/{category}/products', 'CategoryProductsController@store');
        Route::post('subcategories/{subcategory}/products', 'SubcategoryProductsController@store');
        Route::post('productgroups/{productGroup}/products', 'ProductGroupProductsController@store');

        Route::get('categories/order', 'CategoryOrderController@show');
        Route::post('categories/order', 'CategoryOrderController@update');
        Route::get('categories', 'CategoriesController@index');
        Route::get('categories/{category}/edit', 'CategoriesController@edit');
        Route::get('categories/{category}', 'CategoriesController@show');
        Route::post('categories', 'CategoriesController@store');
        Route::post('categories/{category}', 'CategoriesController@update');
        Route::delete('categories/{category}', 'CategoriesController@delete');

        Route::post('categories/{category}/image', 'CategoryImageController@store');

        Route::get('categories/{category}/banner/image/edit', 'CategoryBannerImageController@edit');
        Route::post('categories/{category}/banner/image', 'CategoryBannerImageController@store');

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

        Route::get('api/products/{product}', 'ProductsApiController@show');

        Route::get('products/{product}', 'ProductsController@show');
        Route::get('products/{product}/edit', 'ProductsController@edit');
        Route::post('products/{product}/availability', 'ProductAvailabilityController@update');
        Route::post('products/{product}', 'ProductsController@update');
        Route::delete('products/{product}', 'ProductsController@delete');

        Route::post('products/{product}/promote', 'ProductPromotionsController@update');

        Route::post('products/{product}/image', 'ProductImagesController@store');

        Route::get('products/{product}/gallery', 'ProductGalleriesController@show');

        Route::get('products/{product}/gallery/images', 'ProductGalleryImagesController@index');
        Route::post('products/{product}/gallery/images', 'ProductGalleryImagesController@store');
        Route::delete('products/{product}/gallery/images/{media}', 'ProductGalleryImagesController@delete');

        Route::get('productcategories/categories', 'ProductCategoriesController@listCategories');
        Route::post('products/{product}/category/{category}', 'ProductCategoriesController@moveToCategory');
        Route::post('products/{product}/subcategory/{subcategory}', 'ProductCategoriesController@moveToSubcategory');
        Route::post('products/{product}/productgroup/{productGroup}', 'ProductCategoriesController@moveToProductGroup');

        Route::post('products/{product}/markednew', 'ProductMarkedNewController@update');

        Route::get('orders', 'OrdersController@index');
        Route::get('orders/archived', 'OrdersController@archived');
        Route::get('orders/{order}', 'OrdersController@show');
        Route::post('orders/{order}/archiving', 'OrdersController@setArchiveStatus');

        Route::get('orders/{order}/start-quote', 'OrderQuoteCustomerController@show');

        Route::get('suppliers', 'SuppliersController@index');
        Route::get('suppliers/{supplier}', 'SuppliersController@show');
        Route::get('suppliers/{supplier}/edit', 'SuppliersController@edit');
        Route::post('suppliers', 'SuppliersController@store');
        Route::post('suppliers/{supplier}', 'SuppliersController@update');
        Route::delete('suppliers/{supplier}', 'SuppliersController@delete')->middleware('superauth');


        Route::get('products/{product}/supplies', 'SuppliesController@index');
        Route::post('products/{product}/supplies', 'SuppliesController@store');
        Route::delete('supplies/{supply}', 'SuppliesController@delete')->middleware('superauth');

        Route::post('products/{product}/packaging', 'ProductPackagingController@store');
        Route::post('packaging/{packaging}', 'ProductPackagingController@update');
        Route::delete('packaging/{packaging}', 'ProductPackagingController@delete');
        Route::get('api/products/{product}/supplies', 'ProductSuppliesApiController@index');


        Route::get('slides', 'SlidesController@index')->middleware('superauth');
        Route::get('slides/sort', 'SlidesOrderController@edit')->middleware('superauth');
        Route::get('slides/create', 'SlidesController@create')->middleware('superauth');
        Route::get('slides/{slide}/edit', 'SlidesController@edit')->middleware('superauth');
        Route::post('api/slides/order', 'SlidesOrderController@update')->middleware('superauth');
        Route::post('api/slides/{slide}', 'SlidesController@update')->middleware('superauth');
        Route::delete('slides/{slide}', 'SlidesController@delete')->middleware('superauth');

        Route::post('slides/{slide}/media', 'SlidesMediaController@store')->middleware('superauth');

        Route::post('slides/{slide}/publishing', 'SlidesPublishingController@update')->middleware('superauth');

        Route::get('/sitelinks', 'SiteLinkController@index');

        Route::get('social', 'SocialController@index')->middleware('superauth');


        Route::get('customers', 'CustomersController@index');
        Route::get('customers/{customer}', 'CustomersController@show');
        Route::get('customers/{customer}/edit', 'CustomersController@edit');
        Route::post('customers', 'CustomersController@store');
        Route::post('customers/{customer}', 'CustomersController@update');
        Route::delete('customers/{customer}', 'CustomersController@delete')->middleware('superauth');

        Route::post('customers/from-order/{order}', 'OrderToCustomerController@store');

        Route::post('customers/{customer}/clone-quote/{quote}', 'ClonedCustomerQuotesController@store');

        Route::get('api/customers', 'CustomersApiController@index');

        Route::get('quotes-search/customers/{customer}', 'QuotesSearchController@byCustomer');
        Route::get('quotes-search/products/{product}', 'QuotesSearchController@byProduct');
        Route::get('quotes-search/customers/{customer}/products/{product}',
            'QuotesSearchController@byCustomerWithProduct');

        Route::post('customers/{customer}/quotes', 'CustomerQuotesController@store');


        Route::get('quotes', 'QuotesController@index');
        Route::get('quotes/{quote}', 'QuotesController@show');
        Route::get('quotes/{quote}/edit', 'QuotesController@edit');
        Route::post('quotes/{quote}', 'QuotesController@update');
        Route::post('quotes', 'QuotesController@store');
        Route::delete('quotes/{quote}', 'QuotesController@delete');

        Route::get('quotes/{quote}/items/edit', 'QuoteQuoteItemsController@edit');

        Route::get('quotes/{quote}/completeness', 'QuoteCompletenessController@show');

        Route::post('quotes/{quote}/finalise', 'QuoteFinalisingController@update')->middleware('superauth');

        Route::get('quotes/{quote}/excel', 'QuoteToExcelController@store');

        Route::get('quotes/{quote}/items', 'QuoteItemsController@index');
        Route::post('quotes/{quote}/items', 'QuoteItemsController@store');
        Route::patch('quoteitems/{item}', 'QuoteItemsController@update');
        Route::delete('quoteitems/{item}', 'QuoteItemsController@delete');


    });

});


Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function () {

    Route::get('admin/social-sharing', 'SocialSharingSettingsController@show');

    Route::get('admin/facebook/login', 'FacebookAuthController@login')->middleware('superauth');
    Route::get('oauth/facebook/callback', 'FacebookAuthController@callback')->middleware('superauth');
    Route::post('admin/social-sharing/facebook', 'FacebookSharingSettingsController@store')->middleware('superauth');
    Route::delete('admin/social-sharing/facebook', 'FacebookSharingSettingsController@destroy')->middleware('superauth');

    Route::get('admin/twitter/login', 'TwitterAuthController@login')->middleware('superauth');
    Route::get('oauth/twitter/callback', 'TwitterAuthController@callback')->middleware('superauth');
    Route::post('admin/social-sharing/twitter',
        'TwitterSharingSettingsController@store')->middleware('superauth');
    Route::delete('admin/social-sharing/twitter',
        'TwitterSharingSettingsController@destroy')->middleware('superauth');

});
