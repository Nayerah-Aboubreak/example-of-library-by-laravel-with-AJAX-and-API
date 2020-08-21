<?php

use Illuminate\Support\Facades\Route;

Route::get('/authors', 'ApiAuthorController@index');
Route::get('/books', 'ApiBookController@index');

Route::middleware('apiUserAuth')->group(function () {

    Route::get('/authors/show/{id}', 'ApiAuthorController@show');
    Route::post('/authors/store', 'ApiAuthorController@store');
    Route::post('/authors/update/{id}', 'ApiAuthorController@update');
    Route::get('/authors/delete/{id}', 'ApiAuthorController@delete');


    Route::get('/books/show/{id}', 'ApiBookController@show');
    Route::post('/books/store', 'ApiBookController@store');
    Route::post('/books/update/{id}', 'ApiBookController@update');
    Route::get('/books/delete/{id}', 'ApiBookController@delete');
});
