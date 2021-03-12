<?php

Route::group(['prefix' => 'categories'], function () {

	Route::get('/all', 'CategoryController@getAll');
	Route::post('/add', 'CategoryController@createOne');
	Route::post('/type/add', 'CategoryController@assignOneType');
	Route::post('/type/delete', 'CategoryController@removeAssignedOneType');
	Route::post('/delete/{id}', 'CategoryController@destroyOne');
	Route::post('/update/{id}', 'CategoryController@updateOne');

});
