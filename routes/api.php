<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Author
Route::apiResource('author',AuthorController::class);
// Book
Route::apiResource('book',BookController::class);
// Member
Route::apiResource('member',MemberController::class);
// Borrowing
Route::apiResource('borrow',BorrowingController::class)->only('index','store','show');

Route::post('borrow/{borrowing}/return', [BorrowingController::class, 'returnBook']);

Route::get('borrow/overdue/list',[BorrowingController::class, 'overdue']);
