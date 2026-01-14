<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegaldataMediaController;
use App\Http\Controllers\LegaldataBookController;

Route::get('/', function () {
    return view('book.index');
});

Route::get('/book', function () {
    return view('book.index');
});

Route::get('/book/cat/{id}', function (int $id) {
    return view('book.category', ['catId' => $id]);
})->whereNumber('id');

Route::get('/book/{id}', function (int $id) {
    return view('book.show', ['id' => $id]);
})->whereNumber('id');

Route::get('/book/cart', function () {
    return view('book.cart');
});

Route::get('/book/checkout', function () {
    return view('book.checkout2');
});

Route::get('/api/legaldata/book/{id}', [LegaldataBookController::class, 'show'])->whereNumber('id');

Route::get('/media/legaldata-image', [LegaldataMediaController::class, 'image'])->name('legaldata.image');
