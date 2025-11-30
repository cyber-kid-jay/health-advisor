# QUICK IMPLEMENTATION GUIDE
## Medical Advisory System - Laravel Setup

This guide will help you implement the medical advisory system in your Laravel project.

---

## 📋 PREREQUISITES

✅ PHP 8.1 or higher  
✅ Composer installed  
✅ MySQL/PostgreSQL database  
✅ Laravel 10.x installed  
✅ Node.js and NPM (for asset compilation)

---

## 🚀 STEP-BY-STEP IMPLEMENTATION

### STEP 1: Initial Laravel Setup

```bash
# If you haven't created the project yet:
composer create-project laravel/laravel medical-advisory-system
cd medical-advisory-system

# If you already have Laravel installed, just navigate to your project:
cd your-laravel-project
```

### STEP 2: Configure Database

1. Open `.env` file in your project root
2. Update database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_advisory_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

3. Create the database:
```bash
mysql -u your_username -p
CREATE DATABASE medical_advisory_db;
EXIT;
```

### STEP 3: Copy Static Assets

Copy the CSS and JavaScript files you received:

```bash
# Copy CSS file
cp styles.css public/css/styles.css

# Copy any JavaScript files
cp *.js public/js/
```

### STEP 4: Create Controllers

Run these Artisan commands to create all necessary controllers:

```bash
# Main Controllers
php artisan make:controller HomeController
php artisan make:controller DashboardController
php artisan make:controller AssessmentController --resource
php artisan make:controller DiagnosisController
php artisan make:controller TreatmentController
php artisan make:controller ProfileController

# You can copy the sample AssessmentController.php I provided
```

**Where to place the sample controller:**
- Copy `AssessmentController.php` to `app/Http/Controllers/AssessmentController.php`

### STEP 5: Create Models with Migrations

```bash
# Create models with migrations
php artisan make:model Symptom -m
php artisan make:model Condition -m
php artisan make:model Assessment -m
php artisan make:model AssessmentSymptom -m
php artisan make:model DiagnosisResult -m
php artisan make:model Treatment -m
php artisan make:model MedicalHistory -m
php artisan make:model TreatmentProgress -m
php artisan make:model MedicalContent -m
php artisan make:model AuditLog -m
```

**Where to place sample files:**
- Copy `Assessment.php` to `app/Models/Assessment.php`
- Copy `2024_01_01_000004_create_assessments_table.php` to `database/migrations/` (rename with current date)

### STEP 6: Update Other Migrations

Edit the migration files in `database/migrations/` to define table structures.

**Example for symptoms table** (`XXXX_XX_XX_XXXXXX_create_symptoms_table.php`):

```php
public function up()
{
    Schema::create('symptoms', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category');
        $table->text('description')->nullable();
        $table->json('severity_levels')->nullable();
        $table->timestamps();
        
        $table->index('category');
    });
}
```

### STEP 7: Define Model Relationships

Update your models to include relationships. Example from `Assessment.php`:

```php
public function user()
{
    return $this->belongsTo(User::class);
}

public function symptoms()
{
    return $this->belongsToMany(Symptom::class, 'assessment_symptoms')
        ->withPivot('severity', 'duration_days')
        ->withTimestamps();
}
```

### STEP 8: Set Up Routes

Replace content in `routes/web.php` with the sample `web.php` file provided, or add routes gradually:

```php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssessmentController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('assessment', AssessmentController::class);
});
```

### STEP 9: Create Blade Views

Create the folder structure:

```bash
# Create directories
mkdir -p resources/views/layouts/partials
mkdir -p resources/views/auth
mkdir -p resources/views/home
mkdir -p resources/views/dashboard
mkdir -p resources/views/assessment/steps
mkdir -p resources/views/diagnosis
mkdir -p resources/views/treatment
```

**Place the sample files:**
- Copy `app.blade.php` to `resources/views/layouts/app.blade.php`
- Copy `navbar.blade.php` to `resources/views/layouts/partials/navbar.blade.php`
- Copy `dashboard-index.blade.php` to `resources/views/dashboard/index.blade.php`

### STEP 10: Create Services

```bash
mkdir -p app/Services
```

Create these service files:

**`app/Services/DiagnosisEngine.php`:**
```php
<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\Condition;

class DiagnosisEngine
{
    public function analyze(Assessment $assessment)
    {
        // Your diagnosis logic here
        // Match symptoms to conditions
        // Calculate confidence scores
        // Determine risk levels
        
        return [
            // Array of diagnosis results
        ];
    }
}
```

### STEP 11: Run Migrations

```bash
php artisan migrate
```

### STEP 12: Create Seeders (Optional but Recommended)

```bash
php artisan make:seeder SymptomSeeder
php artisan make:seeder ConditionSeeder
```

Edit seeders to populate initial data, then run:

```bash
php artisan db:seed
```

### STEP 13: Set Up Authentication (Laravel Breeze - Recommended)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
```

### STEP 14: Configure User Model

Update `app/Models/User.php`:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'first_name',
    'last_name',
    'date_of_birth',
    'gender',
];
```

Update users migration to add these fields.

### STEP 15: Test the Application

```bash
# Start the development server
php artisan serve

# In another terminal, compile assets
npm run dev
```

Visit: `http://localhost:8000`

---

## 📁 FILE PLACEMENT SUMMARY

Here's where each sample file should go:

| Sample File | Destination |
|-------------|-------------|
| `styles.css` | `public/css/styles.css` |
| `AssessmentController.php` | `app/Http/Controllers/AssessmentController.php` |
| `Assessment.php` | `app/Models/Assessment.php` |
| `2024_01_01_000004_create_assessments_table.php` | `database/migrations/YYYY_MM_DD_XXXXXX_create_assessments_table.php` |
| `app.blade.php` | `resources/views/layouts/app.blade.php` |
| `navbar.blade.php` | `resources/views/layouts/partials/navbar.blade.php` |
| `dashboard-index.blade.php` | `resources/views/dashboard/index.blade.php` |
| `web.php` | `routes/web.php` |

---

## 🎯 IMPLEMENTATION PRIORITY

**Week 1: Foundation**
1. ✅ Database setup
2. ✅ Authentication (Breeze)
3. ✅ Basic models and migrations
4. ✅ Landing page and layout

**Week 2: Core Features**
1. ✅ Dashboard
2. ✅ Assessment wizard (symptom selection)
3. ✅ Vital signs input
4. ✅ Basic data storage

**Week 3: Business Logic**
1. ✅ Diagnosis engine (simple algorithm)
2. ✅ Treatment recommendations
3. ✅ Results display

**Week 4: Polish & Testing**
1. ✅ Validation
2. ✅ Error handling
3. ✅ UI/UX improvements
4. ✅ Testing

---

## 🔧 COMMON COMMANDS REFERENCE

```bash
# Create a controller
php artisan make:controller ControllerName

# Create a model with migration
php artisan make:model ModelName -m

# Create a model with migration, factory, and seeder
php artisan make:model ModelName -mfs

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (drop all tables and re-run)
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Create a seeder
php artisan make:seeder SeederName

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# List all routes
php artisan route:list

# Start development server
php artisan serve
```

---

## 🐛 TROUBLESHOOTING

**Issue: Class not found**
```bash
composer dump-autoload
```

**Issue: Database connection failed**
- Check `.env` file
- Verify database exists
- Check credentials

**Issue: Route not found**
```bash
php artisan route:clear
php artisan route:cache
```

**Issue: View not found**
- Check file path and naming
- Clear view cache: `php artisan view:clear`

**Issue: CSRF token mismatch**
- Clear browser cookies
- Check that `@csrf` is in forms

---

## 📚 NEXT STEPS

After basic setup:

1. **Implement Controllers**: Add logic to each controller method
2. **Create All Views**: Convert HTML sections to Blade templates
3. **Build Diagnosis Engine**: Implement the matching algorithm
4. **Add Validation**: Use Form Requests for validation
5. **Implement Services**: Extract business logic to service classes
6. **Add Tests**: Write feature and unit tests
7. **Security Review**: Implement proper authorization
8. **Deploy**: Prepare for production

---

## 💡 TIPS

- Use `php artisan tinker` to test code interactively
- Always use `@csrf` in forms
- Use route names instead of hardcoded URLs
- Leverage Laravel's validation features
- Use database transactions for complex operations
- Keep controllers thin, move logic to services
- Follow PSR-12 coding standards

---

## 📞 NEED HELP?

If you need specific code for any component:
- Controller methods
- Model relationships
- Migration schemas
- View templates
- Service classes

Just ask! Specify which component you need help with.

---

## ✅ CHECKLIST

- [ ] Laravel installed
- [ ] Database configured
- [ ] Migrations created
- [ ] Models created
- [ ] Controllers created
- [ ] Routes defined
- [ ] Views created
- [ ] CSS/JS copied
- [ ] Authentication set up
- [ ] Migrations run
- [ ] Database seeded
- [ ] Application tested

Good luck with your project! 🚀
