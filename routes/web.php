<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('active');

Route::get('/obras', 'ObrasController@index')->name('obras')->middleware('auth', 'active');

Route::post('/obras', 'ObrasController@select')->middleware('auth', 'active');

Route::get('/obras/create', 'ObrasController@create')->middleware('auth', 'active');

Route::post('/obras/create/new', 'ObrasController@save')->middleware('auth', 'active');

Route::get('/obras/{id}/products', 'ObrasController@create')->middleware('auth', 'active');

Route::get('/obras/products', 'ObrasController@create')->middleware('auth', 'active');

Route::get('/obras/admin', 'ObrasController@admin')->middleware('auth', 'active');

Route::get('/obras/admin/finish/{id}', 'ObrasController@finish')->middleware('auth', 'active');

Route::get('/products', 'ProductController@index')->middleware('auth', 'active');

Route::post('/products', 'ProductController@index')->middleware('auth', 'active');

Route::get('/products/delete-filters', 'ProductController@delete_filters')->middleware('auth', 'active');

Route::get('/products/search', 'SearchController@search')->middleware('auth', 'active');

Route::get('/products/show/{id}', 'ProductController@show')->middleware('auth', 'active');

Route::get('/products/show/notify/{id}', 'ProductController@notify')->middleware('auth', 'active');

Route::post('/products/show/add/{id}', 'CartController@add')->middleware('auth', 'active');

Route::get('/cart', 'CartController@index')->middleware('auth', 'active');

Route::get('/cart/clear', 'CartController@clear')->middleware('auth', 'active');

Route::post('/cart/sendOrder', 'OrderController@send')->middleware('auth', 'active');

Route::post('/cart/update/{id}', 'CartController@update')->middleware('auth', 'active');

Route::get('/cart/remove/{id}', 'CartController@remove')->middleware('auth', 'active');

Route::get('/orders', 'OrderController@index')->middleware('auth', 'active');

Route::get('/orders/{id}', 'OrderController@show')->middleware('auth', 'active');

Route::post('/orders/filter', 'OrderController@filter')->middleware('auth', 'active');

Route::post('/orders/repeat/{pedido_id}', 'OrderController@repeat')->middleware('auth', 'active');

//Filter routes
Route::get('subcategories/get/{category_id}', 'SubcategoryController@getSubcategories')->middleware('auth', 'active');

////////Back End////////

Route::get('/admin', 'HomeController@admin')->middleware('auth', 'admin', 'active');

//Obras Route Back

Route::get('admin/obras', 'ObrasController@back')->middleware('auth', 'admin', 'master', 'active');

Route::get('admin/obras/active/', 'ObrasController@actives')->middleware('auth', 'admin', 'master', 'active');

Route::get('admin/obras/finished', 'ObrasController@finished')->middleware('auth', 'admin', 'master', 'active');

Route::get('admin/obras/approve/{id}', 'ObrasController@approve')->middleware('auth', 'admin', 'master', 'active');

Route::get('admin/obras/reject/{id}', 'ObrasController@reject')->middleware('auth', 'admin', 'master', 'active');

Route::get('admin/obras/active/search', 'SearchController@obras_active')->middleware('auth', 'admin', 'master', 'active');;

Route::get('admin/obras/finished/search', 'SearchController@obras_finished')->middleware('auth', 'admin', 'master', 'active');;

//Master User Routes

Route::post('admin/users/makeadmin/{id}', 'UserController@makeadmin')->middleware('auth', 'admin', 'master', 'active');

Route::get('admin/users/access/{id}', 'UserController@access')->middleware('auth', 'admin', 'master', 'active');

Route::post('admin/users/addcc/{id}', 'UserController@ccemails')->middleware('auth', 'admin', 'master', 'active');

Route::post('admin/users/update/{id}', 'UserController@update')->middleware('auth', 'admin', 'master', 'active');

Route::group(['prefix' => 'admin',  'middleware' => ['auth', 'admin', 'active']], function() {

    //Categories Routes

    Route::get('categories', 'CategoryController@index');

    Route::post('categories/create', 'CategoryController@create');

    Route::get('categories/{id}', 'CategoryController@show');

    Route::post('categories/{id}/edit', 'CategoryController@edit');

    Route::get('categories/{id}/delete', 'CategoryController@delete');

    //Subcategories Routes

    Route::get('subcategories', 'SubcategoryController@index');

    Route::post('subcategories/create', 'SubcategoryController@create');

    Route::get('subcategories/{id}', 'SubcategoryController@show');

    Route::post('subcategories/{id}/edit', 'SubcategoryController@edit');

    Route::get('subcategories/{id}/delete', 'SubcategoryController@delete');

    //Users routes

    Route::get('users', 'UserController@index');

    Route::get('users/search', 'SearchController@users');

    Route::get('users/{id}', 'UserController@show');

    Route::post('users/discount/{id}', 'UserController@discount');

    //Order routes

    Route::get('orders', 'OrderController@orders_back');

    Route::post('orders', 'OrderController@orders_back');

    Route::get('order/{id}', 'OrderController@orders_back_show');

    Route::post('order/update/{id}', 'OrderController@status');

    //Brand routes

    Route::get('brands', 'BrandController@index');

    Route::post('brands/create', 'BrandController@create');

    Route::get('brands/delete/{id}', 'BrandController@delete');

    Route::get('brands/edit/{id}', 'BrandController@edit');

    Route::post('brands/edit/{id}', 'BrandController@update');

    //Product Routes

    Route::get('products', 'ProductController@products_back');

    Route::get('products', 'ProductController@products_back');

    Route::get('products/show/{id}', 'ProductController@show_back');

    Route::post('products/update/{id}', 'ProductController@update');

    Route::post('products/link/{id}', 'ProductController@link');

    Route::post('products/uploadImage/{id}', 'ProductController@uploadImage');

    Route::get('products/deleteImage/{id}', 'ProductController@deleteImage');

    Route::post('products/boost', 'ProductController@boost');

    Route::get('products/search', 'SearchController@product_back_search');

    Route::post('products/import', 'ProductController@import');

    Route::get('products/export', 'ProductController@export');

    Route::get('products/alternatives', 'ProductController@alternatives');

    Route::get('products/alternatives/{product}/{alternative}', 'ProductController@delete_alternatives');

    Route::post('products/alternatives/import', 'ProductController@alternatives_import');

    Route::get('products/alternatives/export', 'ProductController@alternatives_export');

    //Discount Groups Routes

    Route::get('discount-group', 'DiscountGroupController@index');

    Route::post('discount-group', 'DiscountGroupController@create');

    Route::get('discount-group/edit/{id}', 'DiscountGroupController@edit');

    Route::post('discount-group/update/{id}', 'DiscountGroupController@update');

    Route::post('discount-group/category/update/{id}', 'DiscountGroupController@category'); 

    Route::post('discount-group/subcategory/update/{id}', 'DiscountGroupController@subcategory');

    Route::post('discount-group/brand/update/{id}', 'DiscountGroupController@brand');

    Route::post('discount-group/users/{id}', 'UserController@discount_group');

    Route::get('discount-group/category/reset/{id}', 'DiscountGroupController@reset_category');

    Route::get('discount-group/brand/reset/{id}', 'DiscountGroupController@reset_brand');

    /*Push Notification Routes*/

    Route::get('/push', 'PushNotificationController@index');

    Route::post('/push/create', 'PushNotificationController@create');
    
    Route::get('/push/view', 'PushNotificationController@view');

    /*User-Subcategory Routes*/

    Route::post('/user-subcategory/save/{id}', 'UserSubcategoryController@link');

    /*Massive image upload*/

    Route::get('/images', 'ImageController@index');
    
    Route::post('/images/upload', 'ImageController@upload');

    /*Obras*/
    Route::get('/obras/edit/{id}', 'ObrasController@edit');
    
    Route::post('/obras/edit/update/{id}', 'ObrasController@update');

    /*Shiping*/
    Route::get('/shipping-cost', 'ShippingCostController@index');
    
    Route::post('/shipping-cost', 'ShippingCostController@update');

});