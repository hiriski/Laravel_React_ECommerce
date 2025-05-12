<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response([
        'message' => 'Hi there 👋'
    ], JsonResponse::HTTP_OK);
});
