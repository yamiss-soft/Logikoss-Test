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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::resource('posts', 'PostController');

    //Imagenes
    Route::get('/app-images/{path}/{dir}/{attachment}', function ($path, $dir, $attachment) {
        $file = $path .'/'. $dir . '/' . $attachment;
        if (\Storage::exists($file)) {
            return \Intervention\Image\Facades\Image::make(\Storage::path($file))->response();
        } else {
            return \Intervention\Image\Facades\Image::make('img/logged-user.png')->response();
        }
    });

});
