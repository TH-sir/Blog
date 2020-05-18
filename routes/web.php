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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Home\Blog\ArticleController@index')->name('index');

Auth::routes();

Route::group(['prefix' => 'admin', ], function () {

    Route::get('/login', 'Auth\Admin\LoginController@showAdminLoginForm');
//    Route::get('/register', 'Auth\Admin\RegisterController@showAdminRegisterForm');

    Route::post('/login', 'Auth\Admin\LoginController@login');
//    Route::post('/register', 'Auth\Admin\RegisterController@create');
    Route::post('/logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin', ], function () {
        Route::get('/', function () {
            return redirect('admin/blog/articles');
        });
        Route::get('/blog/articles', 'Admin\Blog\ArticleController@index')->name('admin.blog.article.list');
        Route::get('/blog/articles/new', 'Admin\Blog\ArticleController@new')->name('admin.blog.article.new');
        Route::post('/blog/articles/store', 'Admin\Blog\ArticleController@store')->name('admin.blog.article.store');
        Route::get('/blog/articles/edit/{id}', 'Admin\Blog\ArticleController@edit')->name('admin.blog.article.edit');
        Route::post('/blog/articles/update', 'Admin\Blog\ArticleController@update')->name('admin.blog.article.update');
        Route::post('/blog/articles/delete', 'Admin\Blog\ArticleController@delete')->name('admin.blog.article.delete');
        Route::post('/blog/articles/top', 'Admin\Blog\ArticleController@top')->name('admin.blog.article.top');
        Route::post('/upload/image/article', 'Admin\UploadController@image')->name('admin.upload.article.image');

        Route::get('/links/friends', 'Admin\Index\LinkController@index')->name('admin.links.friend.list');
        Route::get('/links/friends/new', 'Admin\Index\LinkController@new')->name('admin.links.friend.new');
        Route::post('/links/friends/store', 'Admin\Index\LinkController@store')->name('admin.links.friend.store');
        Route::get('/links/friends/edit/{id}', 'Admin\Index\LinkController@edit')->name('admin.links.friend.edit');
        Route::post('/links/friends/update', 'Admin\Index\LinkController@update')->name('admin.links.friend.update');
        Route::post('/links/friends/delete', 'Admin\Index\LinkController@delete')->name('admin.links.friend.delete');


        Route::get('/users/{id}', 'Admin\User\UserController@edit')->name('admin.user.edit');
        Route::post('/users', 'Admin\User\UserController@update')->name('admin.user.update');
    });
});

//Route::get('/login', function () {
//    return view('auth.login');
//});
Route::group(['middleware' => 'auth:web', ], function () {
    Route::get('/blog/new', 'Home\Blog\ArticleNewController@new')->name('home.blog.article.new');
    Route::post('/blog/new', 'Home\Blog\ArticleNewController@store')->name('home.blog.article.store');
    //个人中心
    Route::get('/main/console','Home\Blog\MainController@index')->name('home.main.console');
    //个人信息
    Route::get('/main/{main}','Home\Blog\MainController@main')->name('home.main.main');
    //关注的用户
    Route::get('/main/user/focus','Home\Blog\MainController@focus')->name('home.main.focus');
    //个人发布的博客
    Route::get('/article/console','Home\Blog\MainController@Articleconsole')->name('home.main.article');
    //展示收藏的博客
    Route::get('/article/favorites','Home\Blog\MainController@favourites')->name('home.main.favourites');
    Route::post('/avatar/modify','Home\Blog\MainController@modify')->name('avatar.modify');
    Route::post('/password/reset','Home\Blog\MainController@resetPassword')->name('password.reset');

});

Route::get('/friend-links', 'Home\Index\LinkController@index')->name('home.blog.link.friend');
Route::get('/{slug}', 'Home\Blog\ArticleController@show')->name('home.blog.article');
Route::get('/category/{category}', 'Home\Blog\CategoryController@show')->name('home.blog.category.show');
Route::get('/tag/{tag}', 'Home\Blog\TagController@show')->name('home.blog.tag.show');
Route::get('/article/favourite/{id}','Home\Blog\MainController@favourite')->name('home.main.favourite');//添加收藏
