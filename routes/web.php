<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');

/*Route::get('/', function () {
    $files = Storage::disk("google")->files();
    $firstFileName = Storage::disk('google')->allFiles()[1];
    $details = Storage::disk('google')->getMetadata($firstFileName);
    $url = Storage::disk('google')->url($firstFileName);
    //dd($files, $details, $url);
});*/

/*Route::post('/upload', function (Request $request) {
    $request->file("thing")->store("","google");
})->name("upload");*/
