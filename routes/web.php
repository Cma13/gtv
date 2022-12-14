<?php

use App\Http\Livewire\Admin\Verify\DeletedVerify;
use App\Http\Livewire\Admin\Point\ShowPoint;
use App\Http\Livewire\Admin\Photography\Photographies;
use App\Http\Livewire\Admin\Places\ListPlaces;
use App\Http\Livewire\Admin\ThematicArea\ThematicAreas;
use App\Http\Livewire\Admin\User\ListUsers;
use App\Http\Livewire\Admin\Verify\ListVerify;
use App\Http\Livewire\Admin\VerifyUser\VerifyUser;
use App\Http\Livewire\Admin\Video\ListVideos;
use App\Http\Livewire\Map;
use App\Http\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:Administrador']], function () {
    Route::get('users', ListUsers::class)->name('users.index');
});

Route::group(['middleware' => ['role:Profesor|Administrador']], function () {
    Route::get('thematic-areas', ThematicAreas::class)->name('thematic-areas.index');
    Route::get('places', ListPlaces::class)->name('places.index');
    Route::get('verify', ListVerify::class)->name('verify.index');
	Route::get('verify', ListVerify::class)->name('verify.index');
    Route::get('verify/trashed', DeletedVerify::class)->name('deleted-verify.index');
	Route::get('verify-users', VerifyUser::class)->name('verify-users.index');
});

Route::group(['middleware' => ['role:Alumno|Profesor|Administrador']], function () {
	Route::get('points-of-interest', ShowPoint::class)->name('points.index');
	Route::get('videos', ListVideos::class)->name('videos.index');
	Route::get('photographies', Photographies::class)->name('photographies.index');
});

Route::get('/', Welcome::class)->name('welcome');
Route::get('/mapa', Map::class)->name('map');

Route::get('fresh', function () {
	Artisan::call('migrate:fresh --seed');
});


