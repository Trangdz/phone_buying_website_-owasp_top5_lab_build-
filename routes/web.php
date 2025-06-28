<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TelephoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController as ProfileUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\ShoppingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as ManagementUserController;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/ssti-demo', [DemoSSTIController::class, 'showForm']);
// Route::post('/ssti-demo', [DemoSSTIController::class, 'renderTemplate']);
Auth::routes();
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {

    // Dashboard: /admin/
    Route::get('/', [DashboardController::class, 'index'])->name('index'); 
    // Tên route: admin.index

    // Auth group: /admin/auth/*
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');    
        Route::post('/update-profile',[AdminController::class,'updateProfile'])->name('update-profile');
        // Tên route: admin.auth.profile

        Route::get('/change-password', [AdminController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [AdminController::class, 'postChangePassword'])->name('post-ChangePassword');
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
        Route::get('/',[ManagementUserController::class,'index'])->name('index');
        Route::get('/add',[ManagementUserController::class,'add'])->name('add');
        Route::post('/add',[ManagementUserController::class,'postAdd'])->name('postAdd');
        Route::get('/edit/{id}',[ManagementUserController::class,'edit'])->name('edit');
        Route::post('/edit/{id}',[ManagementUserController::class,'postEdit'])->name('postEdit');
        Route::get('/delete/{id}',[ManagementUserController::class,'delete'])->name('delete');
    });

});

Route::prefix('user')->name('user.')->middleware(['auth','user'])->group(function(){
    //Authentication
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/profile', [ProfileUserController::class, 'profile'])->name('profile');    
        Route::post('/update-profile',[ProfileUserController::class,'updateProfile'])->name('update-profile');
        // Tên route: admin.auth.profile
        Route::post('/change-password', [ProfileUserController::class, 'postChangePassword'])->name('post-ChangePassword');
        Route::get('/change-password', [ProfileUserController::class, 'changePassword'])->name('change-password');
        // Tên route: admin.auth.change-password
    });

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
    Route::get('/search-comments/{id}',[ShoppingController::class,'searchComments'])->name('search-comments');
    Route::get('/user-comments/{id}',[ShoppingController::class,'getCommentsByUser'])->name('user-comments');
});