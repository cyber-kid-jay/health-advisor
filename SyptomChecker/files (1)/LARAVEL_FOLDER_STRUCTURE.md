# LARAVEL MEDICAL ADVISORY SYSTEM - FOLDER STRUCTURE

## Complete Project Structure

```
medical-advisory-system/
│
├── app/
│   ├── Console/
│   │   └── Kernel.php
│   │
│   ├── Exceptions/
│   │   └── Handler.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php              # User login
│   │   │   │   ├── RegisterController.php           # User registration
│   │   │   │   ├── ForgotPasswordController.php     # Password reset
│   │   │   │   └── ResetPasswordController.php      # Password reset confirmation
│   │   │   │
│   │   │   ├── AssessmentController.php             # Main assessment wizard
│   │   │   ├── DashboardController.php              # User dashboard
│   │   │   ├── DiagnosisController.php              # Diagnosis results
│   │   │   ├── TreatmentController.php              # Treatment recommendations
│   │   │   ├── SymptomController.php                # Symptom management (API)
│   │   │   ├── VitalSignController.php              # Vital signs handling
│   │   │   ├── MedicalHistoryController.php         # Medical history management
│   │   │   ├── ProgressController.php               # Treatment progress tracking
│   │   │   └── HomeController.php                   # Landing page
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php                     # Laravel default
│   │   │   ├── CheckAge.php                         # Custom: Check user age 18+
│   │   │   ├── DisclaimerAccepted.php               # Custom: Verify disclaimer acceptance
│   │   │   └── VerifyCsrfToken.php
│   │   │
│   │   ├── Requests/
│   │   │   ├── AssessmentRequest.php                # Validate assessment data
│   │   │   ├── RegisterRequest.php                  # Validate registration
│   │   │   ├── VitalSignsRequest.php                # Validate vital signs
│   │   │   └── MedicalHistoryRequest.php            # Validate medical history
│   │   │
│   │   └── Kernel.php
│   │
│   ├── Models/
│   │   ├── User.php                                 # User model (comes with Laravel)
│   │   ├── Symptom.php                              # Symptom catalog
│   │   ├── Condition.php                            # Medical conditions/illnesses
│   │   ├── Treatment.php                            # Treatment recommendations
│   │   ├── Assessment.php                           # User health assessments
│   │   ├── AssessmentSymptom.php                    # Pivot: Assessment-Symptom relationship
│   │   ├── DiagnosisResult.php                      # Diagnosis outcomes
│   │   ├── MedicalHistory.php                       # User medical history
│   │   ├── TreatmentProgress.php                    # Treatment tracking
│   │   ├── MedicalContent.php                       # Educational content
│   │   └── AuditLog.php                             # Compliance audit trail
│   │
│   ├── Services/
│   │   ├── DiagnosisEngine.php                      # Main diagnosis logic
│   │   ├── RiskAssessmentService.php                # Risk calculation
│   │   ├── TreatmentMatcherService.php              # Match treatments to conditions
│   │   ├── VitalSignsAnalyzer.php                   # Analyze vital signs
│   │   ├── SymptomMatcherService.php                # Match symptoms to conditions
│   │   └── NotificationService.php                  # Email/SMS notifications
│   │
│   ├── Repositories/
│   │   ├── AssessmentRepository.php                 # Assessment data access
│   │   ├── SymptomRepository.php                    # Symptom data access
│   │   ├── ConditionRepository.php                  # Condition data access
│   │   └── TreatmentRepository.php                  # Treatment data access
│   │
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── EventServiceProvider.php
│       └── RouteServiceProvider.php
│
├── bootstrap/
│   ├── app.php
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   ├── mail.php
│   └── services.php
│
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── SymptomFactory.php
│   │   └── ConditionFactory.php
│   │
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2014_10_12_100000_create_password_resets_table.php
│   │   ├── 2024_01_01_000001_create_symptoms_table.php
│   │   ├── 2024_01_01_000002_create_conditions_table.php
│   │   ├── 2024_01_01_000003_create_symptom_condition_map_table.php
│   │   ├── 2024_01_01_000004_create_assessments_table.php
│   │   ├── 2024_01_01_000005_create_assessment_symptoms_table.php
│   │   ├── 2024_01_01_000006_create_diagnosis_results_table.php
│   │   ├── 2024_01_01_000007_create_treatments_table.php
│   │   ├── 2024_01_01_000008_create_medical_history_table.php
│   │   ├── 2024_01_01_000009_create_treatment_progress_table.php
│   │   ├── 2024_01_01_000010_create_medical_content_table.php
│   │   └── 2024_01_01_000011_create_audit_logs_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── SymptomSeeder.php                        # Seed symptom catalog
│       ├── ConditionSeeder.php                      # Seed medical conditions
│       ├── TreatmentSeeder.php                      # Seed treatments
│       └── SymptomConditionMapSeeder.php            # Seed symptom-condition relationships
│
├── public/
│   ├── index.php                                    # Entry point
│   ├── css/
│   │   └── styles.css                               # Your main CSS file
│   ├── js/
│   │   ├── app.js                                   # Main JavaScript
│   │   ├── assessment-wizard.js                     # Assessment wizard logic
│   │   ├── symptom-selector.js                      # Symptom selection
│   │   └── vital-signs.js                           # Vital signs validation
│   ├── images/
│   │   ├── logo.png
│   │   └── medical-icons/
│   └── videos/
│       └── educational/
│
├── resources/
│   ├── css/
│   │   └── app.css                                  # If using Laravel Mix/Vite
│   │
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   ├── lang/
│   │   └── en/
│   │       ├── auth.php
│   │       ├── validation.php
│   │       └── messages.php
│   │
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                        # Main layout template
│       │   ├── guest.blade.php                      # Layout for non-authenticated users
│       │   └── partials/
│       │       ├── navbar.blade.php                 # Navigation bar
│       │       ├── footer.blade.php                 # Footer
│       │       ├── alerts.blade.php                 # Alert messages
│       │       └── disclaimer.blade.php             # Medical disclaimer
│       │
│       ├── auth/
│       │   ├── login.blade.php                      # Login page
│       │   ├── register.blade.php                   # Registration page
│       │   ├── forgot-password.blade.php            # Forgot password
│       │   └── reset-password.blade.php             # Reset password
│       │
│       ├── home/
│       │   ├── index.blade.php                      # Landing page
│       │   └── about.blade.php                      # About page
│       │
│       ├── dashboard/
│       │   └── index.blade.php                      # User dashboard
│       │
│       ├── assessment/
│       │   ├── index.blade.php                      # Assessment wizard main
│       │   ├── steps/
│       │   │   ├── symptoms.blade.php               # Step 1: Symptom selection
│       │   │   ├── severity.blade.php               # Step 2: Severity rating
│       │   │   ├── vitals.blade.php                 # Step 3: Vital signs
│       │   │   └── history.blade.php                # Step 4: Medical history
│       │   └── processing.blade.php                 # Processing/loading screen
│       │
│       ├── diagnosis/
│       │   ├── results.blade.php                    # Diagnosis results
│       │   └── partials/
│       │       ├── condition-card.blade.php         # Single condition display
│       │       └── urgency-banner.blade.php         # Urgency indicator
│       │
│       ├── treatment/
│       │   ├── index.blade.php                      # Main treatment page
│       │   └── partials/
│       │       ├── lifestyle.blade.php              # Lifestyle recommendations
│       │       ├── medications.blade.php            # OTC medications
│       │       ├── diet.blade.php                   # Dietary advice
│       │       ├── visual-guides.blade.php          # Video/visual resources
│       │       └── progress-tracker.blade.php       # Progress tracking
│       │
│       ├── profile/
│       │   ├── edit.blade.php                       # Edit profile
│       │   └── medical-history.blade.php            # Manage medical history
│       │
│       ├── errors/
│       │   ├── 404.blade.php                        # Not found
│       │   ├── 500.blade.php                        # Server error
│       │   └── 503.blade.php                        # Maintenance mode
│       │
│       └── components/
│           ├── button.blade.php                     # Reusable button component
│           ├── card.blade.php                       # Card component
│           ├── alert.blade.php                      # Alert component
│           └── loading-spinner.blade.php            # Loading spinner
│
├── routes/
│   ├── web.php                                      # Web routes (main routes file)
│   ├── api.php                                      # API routes
│   └── console.php                                  # Artisan commands
│
├── storage/
│   ├── app/
│   │   ├── public/
│   │   └── private/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
│       └── laravel.log
│
├── tests/
│   ├── Feature/
│   │   ├── AssessmentTest.php
│   │   ├── DiagnosisTest.php
│   │   ├── AuthTest.php
│   │   └── DashboardTest.php
│   │
│   └── Unit/
│       ├── DiagnosisEngineTest.php
│       ├── RiskAssessmentTest.php
│       └── VitalSignsAnalyzerTest.php
│
├── vendor/                                          # Composer dependencies
│
├── .env                                             # Environment variables
├── .env.example                                     # Environment variables template
├── .gitignore
├── artisan                                          # Artisan CLI
├── composer.json                                    # PHP dependencies
├── composer.lock
├── package.json                                     # Node dependencies
├── phpunit.xml                                      # PHPUnit configuration
└── README.md                                        # Project documentation
```

## DETAILED FILE BREAKDOWN

### 1. CONTROLLERS TO CREATE

Create these controllers using Artisan:

```bash
# Authentication (Laravel provides these, but customize)
php artisan make:controller Auth/LoginController
php artisan make:controller Auth/RegisterController

# Main Application Controllers
php artisan make:controller HomeController
php artisan make:controller DashboardController
php artisan make:controller AssessmentController
php artisan make:controller DiagnosisController
php artisan make:controller TreatmentController
php artisan make:controller SymptomController
php artisan make:controller VitalSignController
php artisan make:controller MedicalHistoryController
php artisan make:controller ProgressController
```

#### Key Controller Methods:

**HomeController.php**
- `index()` - Landing page
- `about()` - About page

**DashboardController.php**
- `index()` - Show dashboard
- `history()` - Assessment history

**AssessmentController.php**
- `create()` - Start new assessment
- `store()` - Save assessment data
- `show($id)` - View specific assessment

**DiagnosisController.php**
- `analyze(Request $request)` - Process assessment and generate diagnosis
- `show($assessmentId)` - Show diagnosis results

**TreatmentController.php**
- `show($diagnosisId)` - Show treatment recommendations
- `progress($treatmentId)` - Track progress

---

### 2. MODELS TO CREATE

```bash
# Create Models with migrations
php artisan make:model Symptom -m
php artisan make:model Condition -m
php artisan make:model Treatment -m
php artisan make:model Assessment -m
php artisan make:model AssessmentSymptom -m
php artisan make:model DiagnosisResult -m
php artisan make:model MedicalHistory -m
php artisan make:model TreatmentProgress -m
php artisan make:model MedicalContent -m
php artisan make:model AuditLog -m
```

---

### 3. VIEWS TO CREATE (BLADE TEMPLATES)

#### Core Layout Files:
1. `resources/views/layouts/app.blade.php` - Main authenticated layout
2. `resources/views/layouts/guest.blade.php` - Layout for guests
3. `resources/views/layouts/partials/navbar.blade.php` - Navigation
4. `resources/views/layouts/partials/footer.blade.php` - Footer

#### Authentication Views:
5. `resources/views/auth/login.blade.php`
6. `resources/views/auth/register.blade.php`
7. `resources/views/auth/forgot-password.blade.php`

#### Main Application Views:
8. `resources/views/home/index.blade.php` - Landing page
9. `resources/views/dashboard/index.blade.php` - User dashboard
10. `resources/views/assessment/index.blade.php` - Assessment wizard
11. `resources/views/assessment/steps/symptoms.blade.php` - Step 1
12. `resources/views/assessment/steps/severity.blade.php` - Step 2
13. `resources/views/assessment/steps/vitals.blade.php` - Step 3
14. `resources/views/assessment/steps/history.blade.php` - Step 4
15. `resources/views/assessment/processing.blade.php` - Processing screen
16. `resources/views/diagnosis/results.blade.php` - Results page
17. `resources/views/treatment/index.blade.php` - Treatment recommendations

---

### 4. ROUTES (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Assessment
    Route::prefix('assessment')->name('assessment.')->group(function () {
        Route::get('/create', [AssessmentController::class, 'create'])->name('create');
        Route::post('/store', [AssessmentController::class, 'store'])->name('store');
        Route::get('/{assessment}', [AssessmentController::class, 'show'])->name('show');
    });
    
    // Diagnosis
    Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
        Route::post('/analyze', [DiagnosisController::class, 'analyze'])->name('analyze');
        Route::get('/{assessment}', [DiagnosisController::class, 'show'])->name('show');
    });
    
    // Treatment
    Route::prefix('treatment')->name('treatment.')->group(function () {
        Route::get('/{diagnosis}', [TreatmentController::class, 'show'])->name('show');
        Route::post('/progress', [TreatmentController::class, 'trackProgress'])->name('progress');
    });
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

---

### 5. SERVICES TO CREATE

Create these service classes manually:

```bash
mkdir app/Services
```

Then create:
- `app/Services/DiagnosisEngine.php`
- `app/Services/RiskAssessmentService.php`
- `app/Services/TreatmentMatcherService.php`
- `app/Services/VitalSignsAnalyzer.php`

---

### 6. DATABASE MIGRATIONS

Run these commands to create migrations:

```bash
php artisan make:migration create_symptoms_table
php artisan make:migration create_conditions_table
php artisan make:migration create_symptom_condition_map_table
php artisan make:migration create_assessments_table
php artisan make:migration create_assessment_symptoms_table
php artisan make:migration create_diagnosis_results_table
php artisan make:migration create_treatments_table
php artisan make:migration create_medical_history_table
php artisan make:migration create_treatment_progress_table
php artisan make:migration create_medical_content_table
php artisan make:migration create_audit_logs_table
```

---

### 7. SEEDERS

```bash
php artisan make:seeder SymptomSeeder
php artisan make:seeder ConditionSeeder
php artisan make:seeder TreatmentSeeder
php artisan make:seeder SymptomConditionMapSeeder
```

---

## IMPLEMENTATION ORDER

Follow this order when building:

### Phase 1: Setup & Authentication
1. Install Laravel
2. Configure `.env` file (database, mail, etc.)
3. Create authentication views (login, register)
4. Test authentication flow

### Phase 2: Database
1. Create all migrations
2. Run migrations: `php artisan migrate`
3. Create seeders
4. Seed database: `php artisan db:seed`

### Phase 3: Models & Relationships
1. Create all models
2. Define relationships between models
3. Create model factories for testing

### Phase 4: Core Features
1. Create HomeController and landing page
2. Create DashboardController and dashboard view
3. Build assessment wizard (controller + views)
4. Implement diagnosis engine
5. Create treatment recommendations

### Phase 5: Services & Business Logic
1. Create DiagnosisEngine service
2. Create RiskAssessmentService
3. Create TreatmentMatcherService
4. Implement vital signs analysis

### Phase 6: Testing & Refinement
1. Write tests
2. Test all user flows
3. Add validation
4. Implement error handling

---

## QUICK START COMMANDS

```bash
# 1. Create Laravel project (if not done)
composer create-project laravel/laravel medical-advisory-system

# 2. Navigate to project
cd medical-advisory-system

# 3. Configure database in .env file

# 4. Create all models with migrations
php artisan make:model Symptom -mcr
php artisan make:model Condition -mcr
php artisan make:model Assessment -mcr
php artisan make:model Treatment -mcr
php artisan make:model DiagnosisResult -mcr
php artisan make:model MedicalHistory -mcr

# 5. Create controllers
php artisan make:controller HomeController
php artisan make:controller DashboardController
php artisan make:controller AssessmentController --resource
php artisan make:controller DiagnosisController
php artisan make:controller TreatmentController

# 6. Run migrations
php artisan migrate

# 7. Start development server
php artisan serve
```

---

## NEXT STEPS

1. **Copy your CSS file** to `public/css/styles.css`
2. **Copy your JavaScript** to `public/js/` folder
3. **Convert HTML sections** to Blade views
4. **Set up routes** in `routes/web.php`
5. **Implement controllers** with actual logic
6. **Create migrations** and seed data
7. **Test thoroughly**

Would you like me to create any specific file (controller, model, migration, or view) to help you get started?
