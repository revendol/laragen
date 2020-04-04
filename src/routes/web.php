<?php

Route::group(['prefix'=>'laragen','as'=>'laragen.','namespace'=>'Radoan\Laragen\Http\Controllers'],function (){
    Route::get('/','LaragenController@index');
    Route::get('/generate-model','LaragenController@generateModel')->name('model.get');
    Route::post('/model','LaragenController@model')->name('model');
    Route::post('/view','LaragenController@view')->name('view');
    Route::post('/controller','LaragenController@controllerView')->name('controller');
});
