<?php

//Library
Route::group(['prefix' => config('clara.library.route.web.prefix'), 'middleware' => config('clara.library.route.web.middleware')], function()
{
    Route::resource('library', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController', ['names' => 'admin.library']);
});

Route::group(['prefix' => config('clara.library.route.api.prefix'), 'middleware' => config('clara.library.route.api.middleware')], function()
{
    Route::get('library/index/ajax', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@indexAjax')->name('admin.library.index.ajax');
	Route::get('library/select/ajax', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryController@selectAjax')->name('admin.library.select.ajax');
});

//Category
Route::group(['prefix' => config('clara.library-category.route.web.prefix'), 'middleware' => config('clara.library-category.route.web.middleware')], function()
{
    Route::resource('library-category', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryCategoryController', ['names' => 'admin.library-category']);
});

Route::group(['prefix' => config('clara.library-category.route.api.prefix'), 'middleware' => config('clara.library-category.route.api.middleware')], function()
{
    Route::get('library-category/index/ajax', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryCategoryController@indexAjax')->name('admin.library-category.index.ajax');
	Route::get('library-category/select/ajax', 'CeddyG\ClaraLibrary\Http\Controllers\Admin\LibraryCategoryController@selectAjax')->name('admin.library-category.select.ajax');
});