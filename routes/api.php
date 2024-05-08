<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/



Route::middleware('auth:api')->get('/user', function (Request $request) {
	$user = $request->user();
	if($user){
		$user->pessoa;
	}
	return $user;
});


Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->middleware('auth:api');


Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/usuario/index/{id_assistente?}', ['as' => 'usuario.index', 'uses' => 'UsuarioController@index']);
	Route::post('/usuario/index/{id_assistente?}', ['as' => 'usuario.index', 'uses' => 'UsuarioController@index']);
	Route::get('/usuario/json/{id_assistente?}', ['as' => 'usuario.json', 'uses' => 'UsuarioController@json']);
	Route::post('/usuario/json/{id_assistente?}', ['as' => 'usuario.json', 'uses' => 'UsuarioController@json']);
	Route::get('/usuario/create/{id_assistente?}', ['as' => 'usuario.create', 'uses' => 'UsuarioController@create']);
	Route::post('/usuario/create/{id_assistente?}', ['as' => 'usuario.create', 'uses' => 'UsuarioController@create']);
	Route::post('/usuario/store/{id_assistente?}', ['as' => 'usuario.store', 'uses' => 'UsuarioController@store']);
	Route::get('/usuario/edit/{id}/{id_assistente?}', ['as' => 'usuario.edit', 'uses' => 'UsuarioController@edit']);
	Route::post('/usuario/edit/{id}/{id_assistente?}', ['as' => 'usuario.edit', 'uses' => 'UsuarioController@edit']);
	Route::put('/usuario/update/{id}/{id_assistente?}', ['as' => 'usuario.update', 'uses' => 'UsuarioController@update']);
	Route::get('/usuario/show/{id}/{id_assistente?}', ['as' => 'usuario.show', 'uses' => 'UsuarioController@show']);
	Route::post('/usuario/show/{id}/{id_assistente?}', ['as' => 'usuario.show', 'uses' => 'UsuarioController@show']);
	Route::get('/usuario/info/{id}/{id_assistente?}', ['as' => 'usuario.info', 'uses' => 'UsuarioController@info']);
	Route::post('/usuario/info/{id}/{id_assistente?}', ['as' => 'usuario.info', 'uses' => 'UsuarioController@info']);
	Route::get('/usuario/head/{id_assistente?}', ['as' => 'usuario.head', 'uses' => 'UsuarioController@head']);
	Route::post('/usuario/head/{id_assistente?}', ['as' => 'usuario.head', 'uses' => 'UsuarioController@head']);
	Route::get('/usuario/destroy/{id}/{id_assistente?}', ['as' => 'usuario.destroy', 'uses' => 'UsuarioController@destroy']);
	Route::post('/usuario/destroy/{id}/{id_assistente?}', ['as' => 'usuario.destroy', 'uses' => 'UsuarioController@destroy']);

});