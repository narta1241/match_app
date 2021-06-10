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
Route::get('search', 'SearchController@index')->name('search.index')->middleware('auth');
Route::resource('profiles', 'ProfileController')->middleware('auth');
// Route::resource('blocks', 'BlockController')->middleware('auth');
Route::get('favorites/{pattern}', 'FavoriteController@index')->name('favorites.index')->middleware('auth');
Route::get('matchings', 'MatchingController@index')->name('matchings.index')->middleware('auth');
Route::get('footprints', 'FootPrintController@index')->name('footprints.index')->middleware('auth');
Route::get('messages/{room}', 'MessageController@index')->name('messages.index')->middleware('auth');
Route::post("messages", 'MessageController@store')->name('messages.store');
// Route::resource('messages', 'MessageController')->middleware('auth');
Route::post("favorites", 'FavoriteController@store')->name('favorites.store');
Route::get('/Mailing','MailingController@sendMail')->name('Mailing');
Route::get("reset/{token}", "ChangeEmailController@reset");
Route::get("withdrawal/{id}", "ProfileController@withdrawal")->name('profiles.withdrawal');
Route::get('messages', 'MessageController@script')->name('messages.script')->middleware('auth');

Route::get('/', function () {
    return view('top');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::post('/email', 'ChangeEmailController@sendChangeEmailLink');
Route::get('emails', 'ChangeEmailController@index')->name('emails.index')->middleware('auth');
Route::post('/pay', 'PaymentController@pay');
Route::get('/payout', 'PaymentController@payout')->name('payout');
Route::get('/setting', 'SettingController@setting')->name('setting');
Route::get('/blocks', 'BlockController@index')->name('blocks.index');
Route::post("blocks", 'BlockController@store')->name('blocks.store');
Route::delete('/blocks/{id}', 'BlockController@destroy')->name('blocks.destroy');

Route::group(['prefix' => '/pusher'], function () {
    Route::get('/index', function () {
        return view('pusher/index');
    });
    Route::get('/hello-world', function () {
        event(new App\Events\MyEvent('hello world'));
        return ['message' => 'send to message : hello world'];
    });
});
Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/user/password/edit', 'UserController@editPassword')->name('user.password.edit');
    Route::post('/user/password/', 'UserController@updatePassword')->name('user.password.update');
});
