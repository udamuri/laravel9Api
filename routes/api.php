<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\{
    Auth\LoginController,
    Product\CategoryController
};

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/v1')->group(function () {

	Route::group(['prefix' => 'auth'], function () {
		Route::post('login/{role}', LoginController::class);
	});
	
	
	Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

		// 127.0.0.1:8000/api/v1/products/categories/index Method GET
		Route::group(['prefix' => 'products'], function () {
			Route::resource('categories', CategoryController::class, [
				'as' => 'apiv1',
				'only' => ['index', 'store', 'update', 'destroy']
			]);
		});

    });
	
});


