<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegaldataBookController;

Route::get('/', function () {
    return redirect('/book');
});

Route::get('/book', function () {
    return view('pustok.book');
});

Route::get('/book/cat/{id}', function (int $id) {
    return view('pustok.blog-list', ['catId' => $id]);
})->whereNumber('id');

Route::get('/book/{id}', function (int $id) {
    return view('pustok.product-details-affiliate', ['id' => $id]);
})->whereNumber('id');

Route::get('/api/legaldata/book/{id}', [LegaldataBookController::class, 'show'])->whereNumber('id');
