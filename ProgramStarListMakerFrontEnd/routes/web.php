<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemOrderController;
use App\Http\Controllers\Auth\SelectUserController;
use App\Http\Controllers\EstablishmentTypeController;
use App\Http\Controllers\PersonProfileUserController;
use App\Http\Controllers\PersonProfileAdminController;
use App\Http\Controllers\Auth\RegisterPersonController;
use App\Http\Controllers\EstablishmentProfileController;
use App\Http\Controllers\Auth\AuthenticationSessionController;
use App\Http\Controllers\Auth\RegisterEstablishmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//=================   HOME   ===================
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/category/{id}', [HomeController::class, 'getProductsByCategory'])->name('productsByCategoryHome');
Route::get('/brand/{id}', [HomeController::class, 'getProductsByBrand'])->name('productsByBrandHome');
Route::post('/', [HomeController::class, 'getProductsByName'])->name('searchArticlesHome');

//=================   LOGIN   ==================
Route::get('/login', [AuthenticationSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticationSessionController::class, 'store'])->name('start');
Route::post('/logout', [AuthenticationSessionController::class, 'destroy'])->name('logout');

//===============   REGISTER   =================
Route::get('/register', [SelectUserController::class, 'create'])->name('selectUser');
Route::get('/register/person', [RegisterPersonController::class, 'create'])->name('registerPerson');
Route::post('/register/person', [RegisterPersonController::class, 'store'])->name('savePerson');

Route::get('/register/establishment', [RegisterEstablishmentController::class, 'create'])->name('registerEstablishment');
Route::post('/register/establishment', [RegisterEstablishmentController::class, 'store'])->name('saveEstablishment');

//=================   ADMIN  ===================
Route::get('/admin', [AdminController::class, 'welcomeAdmin'])->name('welcome_admin');

Route::resource('/admin/management/establishment_types', EstablishmentTypeController::class);
Route::resource('/admin/management/categories', CategoryController::class);
Route::resource('/admin/management/brands', BrandController::class);
Route::resource('/admin/management/user_accounts', UserController::class);
Route::get('/admin/management/user_accounts/account_status/{id}', [UserController::class, 'setAccountStatus'])->name('set_account_status');

Route::get('/admin/profile', [PersonProfileAdminController::class, 'index'])->name('admin_profile');
Route::get('/admin/profile/edit', [PersonProfileAdminController::class, 'edit'])->name('admin_edit_profile');
Route::put('/admin/profile/edit', [PersonProfileAdminController::class, 'update'])->name('updatePersonAdmin');
Route::get('/admin/profile/delete/{id}', [PersonProfileAdminController::class, 'destroy'])->name('destroyPersonAdmin');

Route::get('/establishment', [AdminController::class, 'welcomeEstablishment'])->name('welcome_establishment');

Route::resource('/establishment/management/products', ProductController::class);

Route::get('/establishment/profile', [EstablishmentProfileController::class, 'index'])->name('establishment_profile');
Route::get('/establishment/profile/edit', [EstablishmentProfileController::class, 'edit'])->name('establishment_edit_profile');
Route::put('/establishment/profile/edit', [EstablishmentProfileController::class, 'update'])->name('updateEstablishment');
Route::get('/establishment/profile/delete/{id}', [EstablishmentProfileController::class, 'destroy'])->name('destroyEstablishment');

Route::get('/user', [AdminController::class, 'welcomeUser'])->name('welcome_user');
Route::get('/user/category/{id}', [AdminController::class, 'getProductsByCategory'])->name('productsByCategoryAdmin');
Route::get('/user/brand/{id}', [AdminController::class, 'getProductsByBrand'])->name('productsByBrandAdmin');
Route::post('/user', [AdminController::class, 'getProductsByName'])->name('searchArticlesAdmin');
Route::get('/user/product/{id}/{quantity}', [ItemOrderController::class, 'addProduct'])->name('addProduct');
Route::get('/user/orders', [ItemOrderController::class, 'getOrders'])->name('getOrders');
Route::get('/user/orders/delete/{id}', [ItemOrderController::class, 'deleteOrder'])->name('deleteOrder');

Route::get('/user/profile', [PersonProfileUserController::class, 'index'])->name('user_profile');
Route::get('/user/profile/edit', [PersonProfileUserController::class, 'edit'])->name('user_edit_profile');
Route::put('/user/profile/edit', [PersonProfileUserController::class, 'update'])->name('updatePersonUser');
Route::get('/user/profile/delete/{id}', [PersonProfileUserController::class, 'destroy'])->name('destroyPersonAdmin');
