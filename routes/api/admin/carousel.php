<?php
Route::group(['prefix' => 'carousel'], function () {

	Route::get('/all', 'CarouselController@getAll');
	Route::post('/add', 'CarouselController@createOne');
	Route::post('/delete', 'CarouselController@destroyOne');
	Route::get('/delete/all', 'CarouselController@destroyAll');
	Route::post('/update/{id}', 'CarouselController@updateOne');
	
});
