<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TelephoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DemoSSTIController;
use App\Http\Controllers\User\ShoppingController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/ssti-demo', [DemoSSTIController::class, 'showForm']);
// Route::post('/ssti-demo', [DemoSSTIController::class, 'renderTemplate']);
Auth::routes();
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard: /admin/
    Route::get('/', [DashboardController::class, 'index'])->name('index'); 
    // Tên route: admin.index

    // Auth group: /admin/auth/*
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');    
        Route::post('/update-profile',[ProfileController::class,'updateProfile'])->name('update-profile');
        // Tên route: admin.auth.profile

        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        // Tên route: admin.auth.change-password
    });

    // Posts group: /admin/posts/*
    Route::prefix('telephones')->name('telephones.')->group(function () {
        Route::get('/', [TelephoneController::class, 'index'])->name('index');
        // Tên route: admin.posts.index

        Route::post('/add', [TelephoneController::class, 'postAdd'])->name('postAdd');
        // Tên route: admin.posts.add
        Route::get('/add', [TelephoneController::class, 'add'])->name('add');
        Route::post('/edit/{id}', [TelephoneController::class, 'postEdit'])->name('postEdit');
        Route::get('/edit/{id}', [TelephoneController::class, 'edit'])->name('edit');
        Route::delete('delete/{id}',[TelephoneController::class,'delete'])->name('delete');
        // Tên route: admin.posts.edit
    });

    Route::prefix('users')->name('users.')->group(function(){
        Route::get('/',[UserController::class,'index'])->name('index');
        Route::get('/add',[UserController::class,'add'])->name('add');
        Route::post('/add',[UserController::class,'postAdd'])->name('postAdd');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::post('/edit/{id}',[UserController::class,'postEdit'])->name('postEdit');
        Route::get('/delete/{id}',[UserController::class,'delete'])->name('delete');
    });

});

Route::prefix('user')->name('user.')->middleware('auth')->group(function(){
    Route::get('/',[ShoppingController::class,'index'])->name('index');
    Route::get('/detail/{id}',[ShoppingController::class,'detail'])->name('detail');
    Route::get('/order/{id}',[ShoppingController::class,'order'])->name('order');
    Route::get('/cart',[ShoppingController::class,'cart'])->name('cart');
    Route::get('/add-to-cart/{id}',[ShoppingController::class,'addToCart'])->name('add-to-cart');
    Route::post('/checkout',[ShoppingController::class,'pay'])->name('checkout');
    Route::get('/history',[ShoppingController::class,'history'])->name('history');
    
    // Comment routes
    Route::post('/detail/{id}/comment',[ShoppingController::class,'storeComment'])->name('store-comment');
    Route::delete('/comment/{id}',[ShoppingController::class,'deleteComment'])->name('delete-comment');
    Route::get('/search-comments',[ShoppingController::class,'searchComments'])->name('search-comments');
    Route::get('/user-comments',[ShoppingController::class,'getCommentsByUser'])->name('user-comments');
});