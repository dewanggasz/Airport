<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // <-- Import HomeController
use App\Http\Controllers\FlightController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File; // <-- INI PERBAIKANNYA
use App\Http\Controllers\AirlineController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk mengganti bahasa (dengan log baru)
Route::get('lang/{locale}', function ($locale) {
    Log::info('Language switch route hit for locale: ' . $locale); // <-- LOG PENTING
    if (in_array($locale, ['id', 'en', 'pt'])) {
        Session::put('locale', $locale);
        Log::info('Session "locale" has been set to: ' . $locale);
    } else {
        Log::warning('Attempted to switch to an invalid locale: ' . $locale);
    }
    return redirect()->back();
})->name('lang.switch');


Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/airlines', [AirlineController::class, 'index'])->name('airlines.index');
Route::get('/airport-guide', function () {
    return view('pages.airport-guide');
})->name('airport-guide');

Route::get('/download/flight-template', function () {
    // Path baru yang menunjuk ke file di dalam folder storage
    $path = storage_path('app/public/templates/jadwal_penerbangan_template.csv');
    // Periksa apakah file ada sebelum mengunduh
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->download($path);
})->name('download.flight_template');

Route::get('/download/airline-template', function () {
    $path = storage_path('app/public/templates/maskapai_template.csv');

    if (!File::exists($path)) {
        abort(404, 'File template maskapai tidak ditemukan.');
    }

    return response()->download($path);
})->name('download.airline_template'); // <-- Ini rute yang hilang