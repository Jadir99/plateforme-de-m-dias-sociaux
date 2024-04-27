<?php

use App\Http\Controllers\Api\commentaireApiConntroller;
use App\Http\Controllers\Api\FollowApiConntroller;
use App\Http\Controllers\Api\Hashtag_posteApiConntroller;
use App\Http\Controllers\Api\hashtagApiConntroller;
use App\Http\Controllers\Api\LikeApiConntroller;
use App\Http\Controllers\Api\MediaApiConntroller;
use App\Http\Controllers\Api\posteApiConntroller;
use App\Http\Controllers\Api\RetweetApiConntroller;
use App\Http\Controllers\Api\login;
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

Route::apiResource("/postes", posteApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/hashtags", hashtagApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/medias", MediaApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/retweets", RetweetApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/likes", LikeApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/follows", FollowApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/hashtags_postes", Hashtag_posteApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/comments", commentaireApiConntroller::class)->middleware(('auth:sanctum'));
Route::apiResource("/login", login::class);
Route::post("/login",[ login::class,'login']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
