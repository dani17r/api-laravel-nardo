<?php

Route::group(['prefix' => 'types'], function () {

	Route::get('/all', 'TypeController@getAll');
	Route::post('/add', 'TypeController@createOne');
	Route::post('/delete/{id}', 'TypeController@destroyOne');
	Route::post('/update/{id}', 'TypeController@updateOne');

});
