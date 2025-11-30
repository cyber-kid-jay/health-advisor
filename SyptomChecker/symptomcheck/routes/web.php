<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SymptomCheckerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // Serve the project's custom home page instead of the default Breeze welcome page
    return view('home');
})->name('home');

Route::get('/home', function () {
    return redirect('/');
})->name('home.redirect');

// Symptom checker routes (named to match existing views) - authenticated only
Route::middleware('auth')->group(function () {
    Route::get('/symptom-checker', [SymptomCheckerController::class, 'index'])->name('symptom-checker');
    Route::post('/symptom-checker/analyze', [SymptomCheckerController::class, 'analyze'])->name('symptom-checker.analyze');

    // Backwards-compatible route names used across views
    Route::get('/symptom', [SymptomCheckerController::class, 'index'])->name('symptom.index');
    Route::post('/symptom/check', [SymptomCheckerController::class, 'analyze'])->name('symptom.check');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Start entry: redirect to symptom checker for authenticated users,
// otherwise send guest to login so Laravel will redirect back to /start (then to symptom-checker).
Route::get('/start', function () {
    if (Auth::check()) {
        return redirect()->route('symptom-checker');
    }

    // redirect guest to login and set intended to /start
    return redirect()->guest(route('login'));
})->name('start');

// Blog placeholder route (will be replaced by full blog later)
Route::view('/blog', 'blog.index')->name('blog');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
