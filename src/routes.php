<?php

//Library
Route::group(['prefix' => config('clara.library.route.web.prefix'), 'middleware' => config('clara.library.route.web.middleware')], function()
{
    Route::get('library', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@index')->name('admin.library.index');
});

Route::group(['prefix' => config('clara.library.route.api.prefix'), 'middleware' => config('clara.library.route.api.middleware')], function()
{
    Route::get('library', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@indexAjax')->name('api.admin.library.index');
    Route::get('library/{library}', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@edit')->name('api.admin.library.edit');
    Route::post('library', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@store')->name('api.admin.library.store');
    Route::put('library/{library}', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@update')->name('api.admin.library.update');
    Route::delete('library/{library}', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@destroy')->name('api.admin.library.destroy');
});

//Category
Route::group(['prefix' => config('clara.library-category.route.web.prefix'), 'middleware' => config('clara.library-category.route.web.middleware')], function()
{
    Route::resource('library-category', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryCategoryController', ['names' => 'admin.library-category']);
});

Route::group(['prefix' => config('clara.library-category.route.api.prefix'), 'middleware' => config('clara.library-category.route.api.middleware')], function()
{
    Route::get('library-category', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryCategoryController@indexAjax')->name('api.admin.library-category.index');
    Route::get('library-category/select', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryCategoryController@selectAjax')->name('api.admin.library-category.select');
});