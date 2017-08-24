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


Route::group(['namespace' => 'Web', 'prefix' => 'test'], function () {
    //Address
    Route::group(['prefix' => 'address', 'as' => 'address.'], function () {
        Route::get('/create', 'AddressController@create')->name('create');
        Route::get('/balance/{address}', 'AddressController@balance')->name('balance');
        Route::get('/qr/{address}', 'AddressController@qr')->name('qr');

    });

    //Wallets
    Route::group(['prefix' => 'wallets', 'as' => 'wallets.'], function () {
        Route::get('/create/{address}', 'WalletsController@create')->name('create');
    });

    //Transaction
    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
        Route::get('/create', 'TransactionsController@create')->name('create');
        Route::get('/create2', 'TransactionsController@create2')->name('create2');
    });
});
