<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'users/{user}', 'as' => 'users.', 'namespace' => 'Users'], function() {
    Route::group(['prefix' => 'shapes', 'as' => 'shapes.', 'namespace' => 'Shapes'], function() {
        Route::get('/', 'Index')->name('index');
        Route::get('{shape}', 'Show')->name('show');
        Route::post('/', 'Store')->name('store');
    });
    Route::group(['prefix' => 'worksheets', 'as' => 'worksheets.', 'namespace' => 'Worksheets'], function() {
        Route::get('/', 'Index')->name('index');
        Route::post('/', 'Store')->name('store');

        Route::group(['prefix' => '{worksheet}/shapes', 'as' => 'shapes.', 'namespace' => 'Shapes'], function() {
            Route::post('/', 'Store')->name('store');
        });
    });
});
