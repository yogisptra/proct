<?php

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
Route::group(['prefix' => 'dns-api', 'namespace' => 'API'],
    function () {
        Route::get('/', function () {
            echo "Welcome To DNS";
        })->name('base-api');

        Route::post('/callback-moota', 'MootaCallbackController@moota');
        // Route::post('/callback-midtrans', 'MidtransCallbackController@notificationMidtrans');
    }
);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Frontoffice\API')->group(function(){
    Route::post('tambah-campaign', 'CampaignController@store');
    Route::put('ubah-campaign/{id}', 'CampaignController@update');
});

