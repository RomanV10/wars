<?php

use Illuminate\Support\Facades\Route;

Route::group([], function()
{

  Route::post('api/save', ['uses' => 'TestRoman\Wars\Controllers\WarController@create']);
  Route::post('api/show-random-apis-items', ['uses' => 'TestRoman\Wars\Controllers\WarController@showRandomApisItems']);
  Route::post('api/item/add-score', ['uses' => 'TestRoman\Wars\Controllers\WarController@addApiItemScore']);

  Route::get('api/get-enabled', ['uses' => 'TestRoman\Wars\Controllers\WarController@getEnabledApis']);
  Route::put('api/save-enabled', ['uses' => 'TestRoman\Wars\Controllers\WarController@saveEnabledApis']);

  Route::get('api/wars', function (){
    return view('main');
  });

});