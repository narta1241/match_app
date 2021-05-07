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
Route::resource('profiles', 'ProfileController')->middleware('auth');
Route::resource('blocks', 'BlockController')->middleware('auth');
Route::get('favorites/{pattern}', 'FavoriteController@index')->name('favorites.index')->middleware('auth');
Route::get('matchings', 'MatchingController@index')->name('matchings.index')->middleware('auth');
Route::get('footprints', 'FootPrintController@index')->name('footprints.index')->middleware('auth');
Route::get('messages/{room}', 'MessageController@index')->name('messages.index')->middleware('auth');
Route::post("messages", 'MessageController@store')->name('messages.store');
// Route::resource('messages', 'MessageController')->middleware('auth');
Route::post("favorites", 'FavoriteController@store')->name('favorites.store');
Route::get('/Mailing','MailingController@sendMail')->name('Mailing');

Route::get('/', function () {
        if(Auth::id()){
            $gender = App\Profile::where('user_id', Auth::id())->value('sex');
            if($gender == 0)
            {
                $gender = 1;
            }else{
                $gender = 0;
            }
            // dd($gender);
            $matchList = App\Profile::where ('sex', $gender)->get();
        }else{
            $matchList = App\Profile::all();
        }
            // dd($matchList);
    return view('profiles.index', compact('matchList'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::post('/email', 'ChangeEmailController@sendChangeEmailLink');
Route::get('emails', 'ChangeEmailController@index')->name('emails.index')->middleware('auth');
