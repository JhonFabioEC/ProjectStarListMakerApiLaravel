<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\PersonController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\RoleTypeController;
use App\Http\Controllers\Api\V1\ItemOrderController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\DocumentTypeController;
use App\Http\Controllers\Api\V1\MunicipalityController;
use App\Http\Controllers\Api\V1\EstablishmentController;
use App\Http\Controllers\Api\V1\EstablishmentTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('/v1/departments', DepartmentController::class)->only(['show', 'index']);
Route::apiResource('/v1/municipalities', MunicipalityController::class)->only(['show', 'index']);
Route::apiResource('/v1/role_types', RoleTypeController::class)->only(['show', 'index']);
Route::apiResource('/v1/document_types', DocumentTypeController::class)->only(['show', 'index']);
Route::apiResource('/v1/users', UserController::class)->only(['show', 'index']);

Route::apiResource('/v1/categories', CategoryController::class);
Route::apiResource('/v1/brands', BrandController::class);
Route::apiResource('/v1/products', ProductController::class);
Route::apiResource('/v1/item_orders', ItemOrderController::class);
Route::apiResource('/v1/establishment_types', EstablishmentTypeController::class);
Route::apiResource('/v1/person', PersonController::class)->only(['show', 'update', 'destroy']);
Route::apiResource('/v1/establishment',EstablishmentController::class)->only(['show', 'update', 'destroy']);

Route::get('/v1/enable/categories/', [CategoryController::class, 'getEnableCategories']);
Route::get('/v1/enable/brands/', [BrandController::class, 'getEnableBrands']);
Route::get('/v1/enable/products/', [ProductController::class, 'getEnableProducts']);
Route::get('/v1/enable/establishment_types/', [EstablishmentTypeController::class, 'getEnableEstablishmentTypes']);
Route::get('/v1/users/account_status/{id}', [UserController::class, 'setAccountStatus']);
Route::get('/v1/find/establishment/{id}', [EstablishmentController::class, 'findEstablishment']);
Route::get('/v1/find/users/{id}', [UserController::class, 'findUser']);

Route::post('/v1/search/products/', [ProductController::class, 'getProductsByName']);

Route::post('/login', [SessionController::class, 'login']);
Route::post('/logout', [SessionController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register/person', [SessionController::class, 'registerPerson']);
Route::post('/register/establishment', [SessionController::class, 'registerEstablishment']);
