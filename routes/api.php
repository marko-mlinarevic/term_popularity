<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/token', 'ApiAuth@apiAuth'); // Route for taking Auth Token.
Route::post('/term', 'GitHubSearch@searchTerm')->middleware('client'); // Route for searching of term.
Route::post('/v2/term', 'GitHubSearch@searchTermV2')->middleware('client'); // Next version of Api route for searching of term.
