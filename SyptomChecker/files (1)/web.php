<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// ============================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================

// Home & Landing Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

// ============================================
// AUTHENTICATION ROUTES (For Guests Only)
// ============================================

Route::middleware('guest')->group(function () {
    
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// Logout (Authenticated users only)
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ============================================
// PROTECTED ROUTES (Authentication Required)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Assessment Routes
    Route::prefix('assessment')->name('assessment.')->group(function () {
        
        // Create new assessment
        Route::get('/create', [AssessmentController::class, 'create'])
            ->name('create');
        
        // Store assessment
        Route::post('/store', [AssessmentController::class, 'store'])
            ->name('store');
        
        // View specific assessment
        Route::get('/{assessment}', [AssessmentController::class, 'show'])
            ->name('show');
        
        // Delete assessment
        Route::delete('/{assessment}', [AssessmentController::class, 'destroy'])
            ->name('destroy');
        
        // AJAX endpoints for symptom selection
        Route::get('/symptoms/category', [AssessmentController::class, 'getSymptomsByCategory'])
            ->name('symptoms.category');
        Route::get('/symptoms/search', [AssessmentController::class, 'searchSymptoms'])
            ->name('symptoms.search');
    });
    
    // Diagnosis Routes
    Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
        
        // Analyze assessment and generate diagnosis
        Route::post('/analyze', [DiagnosisController::class, 'analyze'])
            ->name('analyze');
        
        // View diagnosis results for an assessment
        Route::get('/{assessment}', [DiagnosisController::class, 'show'])
            ->name('show');
        
        // Export diagnosis as PDF
        Route::get('/{assessment}/export', [DiagnosisController::class, 'exportPdf'])
            ->name('export');
    });
    
    // Treatment Routes
    Route::prefix('treatment')->name('treatment.')->group(function () {
        
        // View treatment recommendations
        Route::get('/{diagnosis}', [TreatmentController::class, 'show'])
            ->name('show');
        
        // Track treatment progress
        Route::post('/progress', [TreatmentController::class, 'trackProgress'])
            ->name('progress.store');
        
        // Update progress
        Route::put('/progress/{progress}', [TreatmentController::class, 'updateProgress'])
            ->name('progress.update');
        
        // View all treatment progress
        Route::get('/progress/history', [TreatmentController::class, 'progressHistory'])
            ->name('progress.history');
    });
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        
        // View/Edit profile
        Route::get('/', [ProfileController::class, 'edit'])
            ->name('edit');
        
        // Update profile
        Route::put('/', [ProfileController::class, 'update'])
            ->name('update');
        
        // Medical History
        Route::get('/medical-history', [ProfileController::class, 'medicalHistory'])
            ->name('medical-history');
        Route::post('/medical-history', [ProfileController::class, 'storeMedicalHistory'])
            ->name('medical-history.store');
        Route::delete('/medical-history/{history}', [ProfileController::class, 'deleteMedicalHistory'])
            ->name('medical-history.destroy');
        
        // Change Password
        Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])
            ->name('change-password');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])
            ->name('change-password.store');
    });
    
    // Medical Content (Educational Resources)
    Route::prefix('resources')->name('resources.')->group(function () {
        Route::get('/', [ResourceController::class, 'index'])
            ->name('index');
        Route::get('/{content}', [ResourceController::class, 'show'])
            ->name('show');
    });
});

// ============================================
// ADMIN ROUTES (For Admin Users Only)
// ============================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Manage Symptoms
    Route::resource('symptoms', Admin\SymptomController::class);
    
    // Manage Conditions
    Route::resource('conditions', Admin\ConditionController::class);
    
    // Manage Treatments
    Route::resource('treatments', Admin\TreatmentController::class);
    
    // Manage Medical Content
    Route::resource('content', Admin\ContentController::class);
    
    // User Management
    Route::resource('users', Admin\UserController::class);
    
    // Audit Logs
    Route::get('/audit-logs', [Admin\AuditLogController::class, 'index'])
        ->name('audit-logs');
});

// ============================================
// API ROUTES (for AJAX calls)
// ============================================

// These can also go in routes/api.php if preferred
Route::prefix('api')->name('api.')->middleware(['auth'])->group(function () {
    
    // Get symptoms by category
    Route::get('/symptoms', [Api\SymptomController::class, 'index']);
    Route::get('/symptoms/{symptom}', [Api\SymptomController::class, 'show']);
    
    // Get conditions
    Route::get('/conditions', [Api\ConditionController::class, 'index']);
    Route::get('/conditions/{condition}', [Api\ConditionController::class, 'show']);
    
    // Validate vital signs
    Route::post('/validate-vitals', [Api\VitalSignController::class, 'validate']);
});

// ============================================
// FALLBACK ROUTE (404 Handler)
// ============================================

Route::fallback(function () {
    return view('errors.404');
});
