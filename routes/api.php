<?php

//use Illuminate\Http\Request;
use App\Http\Controllers\Request;
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





Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->middleware('auth:api');


Route::group(['middleware' => ['auth:api']], function () {
	
	Route::get('/store/index', ['as' => 'store.index', 'uses' => 'App\Http\Controllers\StoreController@index']);
	Route::post('/store/store', ['as' => 'store.store', 'uses' => 'App\Http\Controllers\StoreController@store']);
	Route::put('/store/update/{id}', ['as' => 'store.update', 'uses' => 'App\Http\Controllers\StoreController@update']);
	Route::get('/store/show/{id}', ['as' => 'store.show', 'uses' => 'App\Http\Controllers\StoreController@show']);
	Route::delete('/store/destroy/{id}', ['as' => 'store.destroy', 'uses' => 'App\Http\Controllers\StoreController@destroy']);


	Route::post('/store/{store_id}/book/{book_id}', ['as' => 'store.add_boock', 'uses' => 'App\Http\Controllers\StoreController@add_boock']);


	Route::get('/book/index', ['as' => 'book.index', 'uses' => 'App\Http\Controllers\BookController@index']);
	Route::post('/book/store', ['as' => 'book.store', 'uses' => 'App\Http\Controllers\BookController@store']);
	Route::put('/book/update/{id}', ['as' => 'book.update', 'uses' => 'App\Http\Controllers\BookController@update']);
	Route::get('/book/show/{id}', ['as' => 'book.show', 'uses' => 'App\Http\Controllers\BookController@show']);
	Route::delete('/book/destroy/{id}', ['as' => 'book.destroy', 'uses' => 'App\Http\Controllers\BookController@destroy']);

	/*Route::get('/usuario/index/{id_assistente?}', ['as' => 'usuario.index', 'uses' => 'UsuarioController@index']);
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
	Route::post('/usuario/destroy/{id}/{id_assistente?}', ['as' => 'usuario.destroy', 'uses' => 'UsuarioController@destroy']);*/

});