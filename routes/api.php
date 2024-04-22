<?php

use App\Http\Controllers\Api\commentaireApiConntroller;
use App\Http\Controllers\Api\Hashtag_posteApiConntroller;
use App\Http\Controllers\Api\hashtagApiConntroller;
use App\Http\Controllers\Api\MediaApiConntroller;
use App\Http\Controllers\Api\posteApiConntroller;
use App\Http\Controllers\Api\RetweetApiConntroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource("/postes", posteApiConntroller::class);
Route::apiResource("/hashtags", hashtagApiConntroller::class);
Route::apiResource("/medias", MediaApiConntroller::class);
Route::apiResource("/retweets", RetweetApiConntroller::class);
Route::apiResource("/hashtags_postes", Hashtag_posteApiConntroller::class);
Route::apiResource("/comments", commentaireApiConntroller::class);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
