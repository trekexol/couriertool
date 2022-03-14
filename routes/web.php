<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Traking\TrakingController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Agency\AgencyController;
use App\Http\Controllers\Airline\AirlineController;
use App\Http\Controllers\Whatsapp\WhatsappController;
use App\Http\Controllers\Country\CountryController;
use App\Http\Controllers\Country\CityController;
use App\Http\Controllers\Wharehouse\WharehouseController;
use App\Http\Controllers\Rate\NationalRateController;
use App\Http\Controllers\Rate\InternationalRateController;

Route::get('/', function () {
    
    return view('welcome');
})->name('welcome');

Route::post('asignacnioasd','UserController@assigndatabase')->name('assigndatabase');

Auth::routes();

Route::get('/home',  [BackendController::class, 'index'])->name('home');

Route::group(["prefix"=>'clients'],function(){
    Route::get('/register', [ClientController::class, 'register'])->name('clients.create');
    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
});

Route::group(["prefix"=>'countries'],function(){
    Route::get('/list/codephone/{id_country}',[CountryController::class, 'listCodePhone'])->name('countries.listCodePhone');
    Route::get('/list/makingcode/{id_country}',[CountryController::class, 'listMakingCodes'])->name('countries.listMakingCodes');
    Route::get('/listcity/{id_country}', [CityController::class, 'list'])->name('cities.list');

});

Route::group(["prefix"=>'trakings'],function(){
    Route::get('/', [TrakingController::class, 'index'])->name('trakings.index');

});

Route::group(["prefix"=>'packages'],function(){
    Route::get('/', [PackageController::class, 'index'])->name('packages.index');

});

Route::group(["prefix"=>'agencies'],function(){
    Route::get('/', [AgencyController::class, 'index'])->name('agencies.index');
    Route::get('create', [AgencyController::class, 'create'])->name('agencies.create');
    Route::post('store', [AgencyController::class, 'store'])->name('agencies.store');
    Route::get('edit/{id}', [AgencyController::class, 'edit'])->name('agencies.edit');
    Route::delete('delete', [AgencyController::class, 'delete'])->name('agencies.delete');
});

Route::group(["prefix"=>'airlines'],function(){
    Route::get('/', [AirlineController::class, 'index'])->name('airlines.index');
    Route::get('create', [AirlineController::class, 'create'])->name('airlines.create');
    Route::post('store', [AirlineController::class, 'store'])->name('airlines.store');
    Route::get('edit/{id}', [AirlineController::class, 'edit'])->name('airlines.edit');
    Route::put('update', [AirlineController::class, 'update'])->name('airlines.update');
    Route::delete('delete', [AirlineController::class, 'delete'])->name('airlines.delete');
});


Route::group(["prefix"=>'whatsapps'],function(){
    Route::get('/', [WhatsappController::class, 'index'])->name('whatsapps.index');

});

Route::group(["prefix"=>'countries'],function(){
    Route::get('/', [CountryController::class, 'index'])->name('countries.index');
    Route::get('create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('store', [CountryController::class, 'store'])->name('countries.store');
    Route::get('edit/{id}', [CountryController::class, 'edit'])->name('countries.edit');
    Route::put('update', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('delete', [CountryController::class, 'delete'])->name('countries.delete');
});

Route::group(["prefix"=>'cities'],function(){
    Route::get('/', [CityController::class, 'index'])->name('cities.index');
    Route::get('create', [CityController::class, 'create'])->name('cities.create');
    Route::post('store', [CityController::class, 'store'])->name('cities.store');
    Route::get('edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('update', [CityController::class, 'update'])->name('cities.update');
    Route::delete('delete', [CityController::class, 'delete'])->name('cities.delete');
});

Route::group(["prefix"=>'wharehouses'],function(){
    Route::get('/', [WharehouseController::class, 'index'])->name('wharehouses.index');
    Route::get('create', [WharehouseController::class, 'create'])->name('wharehouses.create');
    Route::post('store', [WharehouseController::class, 'store'])->name('wharehouses.store');
    Route::get('edit/{id}', [WharehouseController::class, 'edit'])->name('wharehouses.edit');
    Route::put('update', [WharehouseController::class, 'update'])->name('wharehouses.update');
    Route::delete('delete', [WharehouseController::class, 'delete'])->name('wharehouses.delete');
});

Route::group(["prefix"=>'national_rates'],function(){
    Route::get('/', [NationalRateController::class, 'index'])->name('national_rates.index');
    Route::get('create',[NationalRateController::class, 'create'])->name('national_rates.create');
    Route::post('store', [NationalRateController::class, 'store'])->name('national_rates.store');
    Route::get('edit/{id}', [NationalRateController::class, 'edit'])->name('national_rates.edit');
    Route::put('update', [NationalRateController::class, 'update'])->name('national_rates.update');
    Route::delete('delete', [NationalRateController::class, 'delete'])->name('national_rates.delete');
});

Route::group(["prefix"=>'international_rates'],function(){
    Route::get('/', [InternationalRateController::class, 'index'])->name('international_rates.index');
    Route::get('create',[InternationalRateController::class, 'create'])->name('international_rates.create');
    Route::post('store', [InternationalRateController::class, 'store'])->name('international_rates.store');
    Route::get('edit/{id}', [InternationalRateController::class, 'edit'])->name('international_rates.edit');
    Route::put('update', [InternationalRateController::class, 'update'])->name('international_rates.update');
    Route::delete('delete', [InternationalRateController::class, 'delete'])->name('international_rates.delete');
});