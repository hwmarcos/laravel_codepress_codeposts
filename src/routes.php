<?php

Route::group(['prefix' => 'admin/posts', 'as' => 'admin.posts.', 'namespace' => 'CodePress\CodePosts\Controllers'], function () {
    Route::get('/', ['uses' => 'AdminPostsController@index', 'as' => 'index']);
    Route::get('create', ['uses' => 'AdminPostsController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'AdminPostsController@store', 'as' => 'store']);
    Route::get('edit/{id}', ['uses' => 'AdminPostsController@edit', 'as' => 'edit']);
    Route::post('update', ['uses' => 'AdminPostsController@update', 'as' => 'update']);
    Route::get('deleted', ['uses' => 'AdminPostsController@deleted', 'as' => 'deleted']);
    Route::get('destroy/{id}', ['uses' => 'AdminPostsController@destroy', 'as' => 'destroy']);
});