<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListingController::class, 'index']);


//Show create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings', [ListingController::class, 'store']) ->middleware('auth');


//Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Edit Submit to Update
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete Listings
Route::delete('listings/{listing}', [ListingController::class,'destroy'])->middleware('auth');


//Manage Listings
Route::get('/listings/manage', [ListingController::class,'manage'])->middleware('auth');


//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class,'store']);

Route::post('logout',[UserController::class, 'logout'])->middleware('auth');

Route::get('login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class,'authenticate']);




// Route::get('/ioana', function () {
//     return view("Ioana");
// });
// Route::get('/kicky', function () {
//     return response("<h1>Ioana</h1>", 200)
//         ->header('kicky', 'Iubeste pe Ioana');
//     // ->header('Content-type','text/plain');

// });

// Route::get('/tata/{id}', function ($id) {
//     return response('<h1>Tatal meu are sa-mi dea mie: ' . $id . ' RON</h1>');
// })->where('id', '[0-9]+');

// Route::get('/search', function (Request $request) {
//     return response('Cine e la nunta acum?' . $request->mama);
// });


//Naming Conventions

// index - Show all listings
// show - Show single listing
//create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - update listing
// destory - Delete listing