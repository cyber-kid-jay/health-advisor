# SymptomChecker - System Architecture & Project Overview

## 1. Project Overview

**SymptomChecker** is a medical advisory system web application built with Laravel that helps users identify potential health conditions based on their reported symptoms. The system uses a weighted scoring algorithm to analyze symptom patterns, medical histories, and vital signs to provide health recommendations.

---

## 2. Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER                            │
├─────────────────────────────────────────────────────────────────┤
│  • Web Browser (Chrome, Firefox, Safari, Edge)                  │
│  • Responsive UI (Tailwind CSS + Vite)                          │
│  • Blade Templates + Alpine.js for interactivity                │
└──────────────────────────┬──────────────────────────────────────┘
                           │ HTTP/HTTPS
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                           │
├─────────────────────────────────────────────────────────────────┤
│  Laravel Blade Templates:                                       │
│  • layouts/app.blade.php (Main layout)                          │
│  • layouts/navigation.blade.php (Navigation bar)                │
│  • symptom_checker/ (Wizard UI)                                 │
│  • blog/ (Health articles)                                      │
│  • dashboard/ (User dashboard)                                  │
│  • auth/ (Login/Register)                                       │
└──────────────────────────┬──────────────────────────────────────┘
                           │ Route Dispatch
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                    ROUTING LAYER                                │
├─────────────────────────────────────────────────────────────────┤
│  routes/web.php:                                                │
│  • GET / → Home page                                            │
│  • /symptom-checker → Symptom wizard flow                       │
│  • /dashboard → User dashboard (auth)                           │
│  • /blog → Blog listing & articles                              │
│  • /profile → User profile management                           │
└──────────────────────────┬──────────────────────────────────────┘
                           │ Controller Dispatch
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                    BUSINESS LOGIC LAYER                         │
├─────────────────────────────────────────────────────────────────┤
│  Controllers (app/Http/Controllers/):                           │
│  ├─ SymptomCheckerController                                    │
│  │  ├─ index() → Show symptom input form                        │
│  │  ├─ store() → Process symptoms & vitals                      │
│  │  ├─ showResults() → Display matched conditions               │
│  │  └─ showTreatment() → Show treatment plan                    │
│  │                                                              │
│  ├─ DashboardController                                         │
│  │  ├─ index() → Display user dashboard                         │
│  │  ├─ fetchConsultations() → Get user history                  │
│  │  └─ fetchChart() → Get vital trends                          │
│  │                                                              │
│  └─ ProfileController (Auth, settings)                          │
│                                                                 │
│  Core Algorithm (SymptomCheckerController.store()):             │
│  ├─ Parse user symptoms & vital signs                           │
│  ├─ Calculate weighted scores per condition:                    │
│  │  • Coverage Score = (matched symptoms / total symptoms) × 40 │
│  │  • Severity Score = avg symptom severity × 30                │
│  │  • Vitals Score = vital sign abnormalities × 30              │
│  │  • Confidence = (Coverage + Severity + Vitals) / 100         │
│  ├─ Rank conditions by confidence                               │
│  └─ Return top 3 conditions with recommendations                │
└──────────────────────────┬──────────────────────────────────────┘
                           │ Data Access
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                     MODEL LAYER (ORM)                           │
├─────────────────────────────────────────────────────────────────┤
│  Eloquent Models (app/Models/):                                 │
│                                                                 │
│  ┌─ User                                                        │
│  │  └─ hasMany() Consultations                                  │
│  │                                                              │
│  ├─ Symptom                                                     │
│  │  ├─ belongsToMany() Conditions                               │
│  │  └─ hasMany() SymptomOccurrences                             │
│  │                                                              │
│  ├─ Condition                                                   │
│  │  ├─ belongsToMany() Symptoms                                 │
│  │  ├─ hasMany() Treatments                                     │
│  │  └─ hasMany() Medications                                    │
│  │                                                              │
│  ├─ Consultation                                                │
│  │  ├─ belongsTo() User                                         │
│  │  ├─ belongsToMany() Symptoms                                 │
│  │  ├─ belongsToMany() Conditions                               │
│  │  └─ hasMany() HealthVitals                                   │
│  │                                                              │
│  ├─ HealthVital                                                 │
│  │  └─ belongsTo() Consultation                                 │
│  │                                                              │
│  ├─ Treatment                                                   │
│  │  └─ belongsTo() Condition                                    │
│  │                                                              │
│  └─ Medication                                                  │
│     └─ belongsTo() Condition                                    │
│                                                                 │
└──────────────────────────┬──────────────────────────────────────┘
                           │ SQL Queries
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      DATABASE LAYER                             │
├─────────────────────────────────────────────────────────────────┤
│  MySQL Database:                                           │
│                                                                 │
│  CORE TABLES:                                                   │
│  ├─ users                                                       │
│  │  ├─ id (PK), name, email, password_hash, timestamps          │
│  │                                                              │
│  ├─ symptoms                                                    │
│  │  ├─ id (PK), name, category, severity (1-10), description    │
│  │  └─ Seeded: ~50 medical symptoms                             │
│  │                                                              │
│  ├─ conditions                                                  │
│  │  ├─ id (PK), name, description, severity, prevalence         │
│  │  └─ Seeded: ~20 conditions (fever, flu, etc.)                │
│  │                                                              │
│  ├─ condition_symptom (Pivot)                                   │
│  │  ├─ condition_id (FK), symptom_id (FK)                       │
│  │  └─ Defines symptom-condition relationships                  │
│  │                                                              │
│  ├─ consultations                                               │
│  │  ├─ id (PK), user_id (FK), notes, created_at, updated_at     │
│  │  └─ Stores user consultation history                         │
│  │                                                              │
│  ├─ consultation_symptom (Pivot)                                │
│  │  ├─ consultation_id (FK), symptom_id (FK)                    │
│  │  └─ Records which symptoms were selected in each check       │
│  │                                                              │
│  ├─ consultation_condition (Pivot)                              │
│  │  ├─ consultation_id (FK), condition_id (FK), confidence      │
│  │  └─ Records matched conditions & confidence scores           │
│  │                                                              │
│  ├─ health_vitals                                               │
│  │  ├─ id (PK), consultation_id (FK)                            │
│  │  ├─ temperature, blood_pressure, heart_rate, oxygen_sat      │
│  │  └─ Stores vital signs for each consultation                 │
│  │                                                              │
│  ├─ treatments                                                  │
│  │  ├─ id (PK), condition_id (FK), name, description            │
│  │  └─ Treatment options per condition                          │
│  │                                                              │
│  └─ medications                                                 │
│     ├─ id (PK), condition_id (FK), name, dosage, side_effects   │
│     └─ Medications recommended per condition                    │
│                                                                 │
│  SUPPORT TABLES:                                                │
│  ├─ users (authentication)                                      │
│  ├─ password_reset_tokens                                       │
│  ├─ cache, job_batches, jobs, failed_jobs (Laravel internals)   │
│  └─ sessions (session management)                               │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 3. Core Data Flow

### 3.1 Symptom Checking Flow
```
User Input → Symptom Selection + Vitals → SymptomCheckerController.store()
    ↓
Parse symptoms & vitals from request
    ↓
Query Condition model → Get all conditions with related symptoms
    ↓
Calculate Weighted Scores (for each condition):
    • Coverage = (matched_count / total_symptoms) × 40%
    • Severity = (avg_severity_score) × 30%
    • Vitals = (abnormal_vitals_count) × 30%
    • Confidence = Coverage + Severity + Vitals (0-100 scale)
    ↓
Rank conditions by confidence score (descending)
    ↓
Save to Consultation & join tables:
    • Insert row in consultations table
    • Insert rows in consultation_symptom (selected symptoms)
    • Insert rows in consultation_condition (matched conditions + scores)
    • Insert rows in health_vitals (vital signs)
    ↓
Display Results Page:
    • Show top 3 matched conditions
    • Show per-condition matched symptoms
    • Show confidence percentage
    • Provide treatment recommendations
```

### 3.2 User Dashboard Flow
```
Authenticated User → Dashboard Route → DashboardController.index()
    ↓
Fetch user's consultations from DB:
    • SELECT consultations WHERE user_id = ?
    ↓
For each consultation, join related data:
    • Join consultation_condition for matched conditions + scores
    • Join consultation_symptom for symptoms entered
    • Join health_vitals for vital signs entered
    ↓
Fetch vital trends over time:
    • Query health_vitals grouped by date/month
    ↓
Display dashboard with:
    • Recent consultation history
    • Condition match statistics
    • Vital sign trends (chart)
    • Treatment recommendations from last check
```

### 3.3 Blog & Articles Flow
```
User → Blog Listing → blog/index.blade.php
    ↓
Display articles organized by category:
    • Featured Articles (immune system, winter wellness, etc.)
    • Articles by Category (diet, fitness, mental health, prevention)
    ↓
Article Card Links → External Authoritative Sources:
    • Mayo Clinic
    • CDC (Centers for Disease Control)
    • Harvard Health
    • NIH (National Institutes of Health)
    ↓
User clicks article → Opens external health resource
    (No internal article routing - leverages trusted sources)
```

---

## 4. Technology Stack

### Frontend
- **Templating**: Laravel Blade
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **Interactivity**: Alpine.js
- **Icons**: Heroicons
- **Responsive Design**: Mobile-first approach

### Backend
- **Framework**: Laravel 12.0
- **Language**: PHP 8.2+
- **ORM**: Eloquent
- **Database**: MySQL
- **Authentication**: Laravel Breeze (built-in auth scaffolding)
- **Session**: Database driver
- **Caching**: Database cache store
- **Queue**: Database queue (for background jobs)

### Development Tools
- **Package Manager**: Composer (PHP), npm (Node.js)
- **Testing**: PHPUnit
- **Debugging**: Laravel Tinker
- **Version Control**: Git


---

## 5. Key Features

### 5.1 Symptom Checker Wizard
- Multi-step form for symptom selection
- Vital signs input (temperature, blood pressure, heart rate, O2 saturation)
- Real-time form validation
- Weighted scoring algorithm
- Results ranked by confidence

### 5.2 Results & Recommendations
- Top 3 matched conditions displayed
- Per-condition matched symptoms shown
- Confidence score visualization
- Treatment and medication recommendations
- Links to preventive care resources

### 5.3 User Dashboard
- Consultation history
- Vital sign trends (chart visualization)
- Profile management
- Persistent data storage
- Appointment notes

### 5.4 Blog & Health Resources
- Curated health articles
- Articles organized by category
- External links to authoritative sources (Mayo Clinic, CDC, Harvard, NIH)
- Responsive card layout
- Newsletter integration (optional) 

### 5.5 Authentication & Security
- User registration & login
- Password hashing (bcrypt)
- Session management
- CSRF protection
- SQL injection prevention (via Eloquent ORM)

---

## 6. PRoject Structure (Key Components)

```
symptomcheck/
├── app/
│   ├── Http/Controllers/
│   │   ├── SymptomCheckerController.php  ← Core algorithm
│   │   ├── DashboardController.php       ← User dashboard
│   │   └── ProfileController.php         ← User settings
│   ├── Models/
│   │   ├── User.php
│   │   ├── Symptom.php
│   │   ├── Condition.php
│   │   ├── Consultation.php
│   │   ├── HealthVital.php
│   │   ├── Treatment.php
│   │   └── Medication.php
│   └── Providers/
├── config/
│   ├── app.php               ← App configuration
│   ├── database.php          ← DB connections (MySQL config here)
│   └── auth.php
├── database/
│   ├── migrations/           ← 15 migration files (all MySQL compatible)
│   ├── seeders/
│   │   └── SymptomSeeder.php ← Loads initial symptom data
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── navigation.blade.php
│   │   ├── symptom_checker/
│   │   │   ├── index.blade.php      ← Wizard form
│   │   │   ├── results.blade.php    ← Results display
│   │   │   └── treatment.blade.php  ← Treatment details
│   │   ├── blog/
│   │   │   ├── index.blade.php      ← Blog listing
│   │   │   └── articles/
│   │   ├── dashboard/
│   │   │   └── index.blade.php
│   │   └── auth/
│   ├── css/
│   │   └── app.css          ← Tailwind CSS
│   └── js/
├── routes/
│   └── web.php              ← All routes defined here
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── public/
│   ├── index.php            ← Application entry point
│   ├── css/
│   └── images/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env                     ← Configuration (DB credentials, API keys)
├── composer.json
├── package.json
└── artisan                  ← Laravel CLI
```

---

## 7. Database Schema Overview

### Entity Relationships (ER Diagram)
```
User
  ├── PK: id
  ├── FK: (none)
  └── HAS_MANY: Consultation

Consultation
  ├── PK: id
  ├── FK: user_id → User
  ├── HAS_MANY: HealthVital
  ├── BELONGS_TO_MANY: Symptom (via consultation_symptom)
  └── BELONGS_TO_MANY: Condition (via consultation_condition)

Symptom
  ├── PK: id
  ├── FK: (none)
  ├── Attributes: name, category, severity (1-10)
  └── BELONGS_TO_MANY: Condition (via condition_symptom)

Condition
  ├── PK: id
  ├── FK: (none)
  ├── Attributes: name, description, severity, prevalence
  ├── HAS_MANY: Treatment
  ├── HAS_MANY: Medication
  └── BELONGS_TO_MANY: Symptom (via condition_symptom)

HealthVital
  ├── PK: id
  ├── FK: consultation_id → Consultation
  └── Attributes: temperature, blood_pressure, heart_rate, oxygen_saturation

Treatment
  ├── PK: id
  ├── FK: condition_id → Condition
  └── Attributes: name, description, duration

Medication
  ├── PK: id
  ├── FK: condition_id → Condition
  └── Attributes: name, dosage, frequency, side_effects

Pivot Tables:
  • condition_symptom (condition_id, symptom_id)
  • consultation_symptom (consultation_id, symptom_id)
  • consultation_condition (consultation_id, condition_id, confidence_score)
```

---

## 8. Scoring Algorithm (Detailed)

The system uses a **weighted multi-factor scoring model** to calculate confidence scores:

```
For each Condition C in Database:
  
  Matched_Symptoms = COUNT(selected_symptoms ∩ condition_symptoms)
  Total_Symptoms = COUNT(condition_symptoms)
  
  COVERAGE_SCORE = (Matched_Symptoms / Total_Symptoms) × 40
  
  SEVERITY_SCORE = AVG(severity of matched symptoms) × 30
  
  VITALS_ABNORMALITY = COUNT(vitals outside normal ranges) × 3.33
  VITALS_SCORE = VITALS_ABNORMALITY × 30 / 10  [max 30 points]
  
  CONFIDENCE = COVERAGE_SCORE + SEVERITY_SCORE + VITALS_SCORE
  
  Result: (Condition, CONFIDENCE_PERCENT, [matched_symptoms], [treatments])

RANK all conditions by CONFIDENCE descending
RETURN top 3 conditions with highest confidence scores
```

**Example:**
- Cold matches 6/8 of flu symptoms (75% coverage) → 30 points
- Average symptom severity: 5/10 → 15 points
- 1 abnormal vital (elevated temperature) → 10 points
- **Total Confidence: 55%**

---

## 9. Security Considerations

- **Authentication**: Laravel Breeze provides secure auth with password hashing
- **CSRF Protection**: Built-in CSRF tokens on forms
- **SQL Injection Prevention**: Eloquent ORM parameterizes queries
- **Password Security**: bcrypt hashing with configurable rounds (12)
- **Session Security**: Secure session cookies with HTTP-only flags
- **Input Validation**: Form requests validate user inputs
- **Data Privacy**: User consultations isolated per authenticated user


## 10. Future Enhancements

- **AI/ML Integration**: Use machine learning for symptom-to-condition prediction
- **Telemedicine**: Connect users with licensed healthcare providers
- **Mobile App**: React Native or Flutter mobile version
- **Advanced Analytics**: Symptom trend analysis across user base
- **Multi-language Support**: i18n for international expansion
- **API Layer**: RESTful API for third-party integrations
- **Voice Input**: Natural language processing for symptom entry
- **Medication Interactions**: Check for drug-drug interactions
- **Insurance Integration**: Check coverage for recommended treatments

---

## Summary

**SymptomChecker** is a well-architected Laravel application that:
1. **Accepts** user symptoms and vital signs via a wizard interface
2. **Processes** data through a weighted scoring algorithm
3. **Matches** user inputs against a database of conditions
4. **Returns** ranked health recommendations with confidence scores
5. **Stores** consultation history in PostgreSQL for user tracking
6. **Provides** health resources and treatment recommendations

