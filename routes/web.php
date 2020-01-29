<?php
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

// Game Api
Route::get('/api/games', 'GameController@index');
Route::get('/api/game/{id}', 'GameController@id');

// Game Week Api
Route::get('/api/game-weeks', 'GameWeekController@index');
Route::get('/api/game-week/{id}', 'GameWeekController@id');

// Map Api
Route::get('/api/maps', 'MapScoreController@index');
Route::get('/api/map/{id}', 'MapScoreController@id');

// Match Data Api
Route::get('/api/game/{game_id}/player/{player_id}', 'MatchDataController@index');

// Player Api
Route::get('/api/players', 'PlayerController@index');
Route::get('/api/player/{id}', 'PlayerController@id');

// Settings Api
Route::get('/api/settings', 'SettingsController@index');
Route::get('/api/setting/{id}', 'SettingsController@id');

// Team Api
Route::get('/api/teams', 'TeamController@index');
Route::get('/api/team/{id}', 'TeamController@id');
// Frontend Router
Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
