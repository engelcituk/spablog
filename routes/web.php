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

Route::get('/', 'PagesController@spa')->name('pages.spa');

/* Route::get('/', 'PagesController@home')->name('pages.home'); */
Route::get('/archive', 'PagesController@archive')->name('pages.archive'); 

Route::get('blog/{post}', 'PostsController@show')->name('posts.show'); 
Route::get('categorias/{category}', 'CategoriesController@show')->name('categories.show'); 
Route::get('tags/{tag}', 'TagsController@show')->name('tags.show'); 


Route::group([
    'prefix'=>'admin', //prefijo para no poner admin/posts
    'namespace'=>'Admin',//namespace para no poner Admin\PostsController@index
    'middleware'=>'auth'],//midleware para controlar el acceso
function(){
    Route::get('/', 'AdminController@index')->name('dashboard');//el slash / es para indicar que esta en la raiz

    Route::resource('posts', 'PostsController',['except'=>'show', 'as'=>'admin']); //as es para agregar el prefijo admin al nombre de las rutas
    Route::resource('users', 'UsersController',['as'=>'admin']);
    Route::resource('roles', 'RolesController',['except'=>'show', 'as'=>'admin']);
    Route::resource('permissions', 'PermissionsController',['only'=>['index','edit','update'], 'as'=>'admin']);

    //middlewares para los roles y  permisos
    Route::middleware('role:Admin')
        ->put('users/{user}/roles', 'UsersRolesController@update')
        ->name('admin.users.roles.update'); 

    Route::middleware('role:Admin')
        ->put('users/{user}/permissions', 'UsersPermissionsController@update')
        ->name('admin.users.permissions.update');


    Route::post('posts/{post}/photos', 'PhotosController@store')->name('admin.posts.photos.update');
    Route::delete('photos/{photo}', 'PhotosController@destroy')->name('admin.photos.destroy');

});

//Route::get('admin/posts', 'Admin\PostsController@index')->middleware('auth');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
/*Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');*/

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');