<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('repositorio/indexTree/{idEmpresa}', 
        'Api\RepositorioController@indexTree'
);

Route::get('repositorio/gruposTree/{idUser}/{idEmpresa}', 
        'Api\RepositorioController@gruposTree'
);
Route::get('repositorio/caminho/{id}','Api\RepositorioController@caminhoID');

Route::post("arquivo", "Api\ArquivoController@upload");
Route::post("arquivo/{id}", "Api\ArquivoController@update");
Route::delete("arquivo/{id}", "Api\ArquivoController@destroy");
Route::get('arquivo/file/{id}', 'Api\ArquivoController@fileArquivo');
Route::get("arquivo/dowload/{id}", "Api\ArquivoController@dowloadArquivo");

