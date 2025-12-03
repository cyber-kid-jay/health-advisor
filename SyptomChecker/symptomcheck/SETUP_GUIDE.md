# SymptomChecker - Quick Start Setup Guide

## For First-Time Setup (After Cloning from GitHub)

This guide helps new developers get SymptomChecker up and running locally in **10 minutes**.

---

## Prerequisites

Before you start, ensure you have:

- **PHP 8.2+** - [Download](https://www.php.net/downloads)
- **Composer** - [Download](https://getcomposer.org/download/)
- **Node.js & npm** - [Download](https://nodejs.org/)
- **MySQL Server** - [Download](https://dev.mysql.com/downloads/mysql/) or use **XAMPP** (recommended)
- **Git** - [Download](https://git-scm.com/download/win)

**Recommended**: Install **XAMPP** (includes PHP, MySQL, Apache, phpMyAdmin all-in-one)
- Download: https://www.apachefriends.org/

---

## Quick Setup (5 Steps)

### Step 1: Clone the Repository
```powershell
git clone https://github.com/cyber-kid-jay/health-advisor.git
cd health-advisor\SyptomChecker\symptomcheck
```

### Step 2: Install Dependencies
```powershell
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Configure Environment
```powershell
# Copy example env file
cp .env.example .env

# Generate app key
php artisan key:generate
```

Then **edit `.env` file** and update database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=symptomchecker
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database & Run Migrations
```powershell
# Create the database (via phpMyAdmin or MySQL CLI)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS symptomchecker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations and seed data
php artisan migrate --seed
```

### Step 5: Start Development Server
```powershell
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite asset compiler
npm run dev
```

**Access the application:**
- Main App: http://localhost:8000
- phpMyAdmin: http://localhost/phpmyadmin

---

## Detailed Setup Instructions

### Windows Setup

#### 1. Install XAMPP (Easiest Option)

1. Download from: https://www.apachefriends.org/
2. Run installer with default settings
3. Launch XAMPP Control Panel
4. Click **Start** for:
   - Apache
   - MySQL
5. Click **Admin** next to MySQL to open phpMyAdmin

#### 2. Install PHP Composer

1. Download: https://getcomposer.org/download/
2. Run Windows installer
3. Choose your PHP installation (should detect automatically)
4. Finish installation

**Verify Composer is installed:**
```powershell
composer --version
```

#### 3. Install Node.js

1. Download LTS version: https://nodejs.org/
2. Run installer with default settings
3. Restart your terminal/PowerShell

**Verify Node.js is installed:**
```powershell
node --version
npm --version
```

#### 4. Clone the Repository

```powershell
cd c:\your\desired\path
git clone https://github.com/cyber-kid-jay/health-advisor.git
cd health-advisor\SyptomChecker\symptomcheck
```

#### 5. Install PHP Dependencies

```powershell
composer install
```

**If you get permission errors**, run PowerShell as Administrator.

#### 6. Install Node.js Dependencies

```powershell
npm install
```

 # SymptomChecker - Windows Quick Setup (Concise)

 This file shows the exact, copy-paste PowerShell steps to get SymptomChecker running on a Windows developer machine using XAMPP (recommended) or a standalone MySQL install.

 Prerequisites (Windows)
 - Git
 - XAMPP (recommended; includes PHP, MySQL, phpMyAdmin)
 - Composer (PHP dependency manager)
 - Node.js + npm

 Recommended: install XAMPP from https://www.apachefriends.org/ and start Apache + MySQL from its Control Panel.

 1) Clone repository

 ```powershell
 cd C:\Users\<your-user>\Projects
 git clone https://github.com/cyber-kid-jay/health-advisor.git
 cd .\health-advisor\SyptomChecker\symptomcheck
 ```

 2) Install PHP & Node dependencies

 ```powershell
 composer install
 npm install
 ```

 3) Create `.env` and generate app key

 ```powershell
 Copy-Item .env.example .env
 php artisan key:generate
 ```

 4) Configure database settings (edit `.env`)

 - If using XAMPP defaults (phpMyAdmin):

 ```text
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=symptomchecker
 DB_USERNAME=root
 DB_PASSWORD=
 ```

 - If you created a custom MySQL user, replace `DB_USERNAME` and `DB_PASSWORD` accordingly.

 5) Create the `symptomchecker` database (phpMyAdmin recommended)

 - Open: http://localhost/phpmyadmin
 - Click **New** → Database name: `symptomchecker` → Collation: `utf8mb4_unicode_ci` → Create

 If you prefer the MySQL CLI (only if `mysql` is in PATH):

 ```powershell
 mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS symptomchecker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
 ```

 6) Run migrations and seed initial data

 ```powershell
 # from project root
 php artisan migrate --seed
 ```

 7) Clear caches

 ```powershell
 php artisan cache:clear
 php artisan view:clear
 php artisan config:clear
 ```

 8) Start the app + asset watcher (two terminals)

 Terminal A (Laravel backend):
 ```powershell
 php artisan serve
 # Server runs at: http://127.0.0.1:8000
 ```

 Terminal B (Vite dev server for assets):
 ```powershell
 npm run dev
 ```

 9) Verify the app

 - Open http://localhost:8000 and test the symptom checker flow.
 - Open http://localhost/phpmyadmin to inspect the `symptomchecker` database and tables.

 Troubleshooting (Windows)
 - "PHP not found": ensure XAMPP's PHP path is in your PATH or run commands from XAMPP's shell (`C:\xampp\php\php.exe artisan ...`).
 - "Access denied for user": check `.env` credentials and log into phpMyAdmin with same user.
 - "MySQL not running": open XAMPP control panel and start MySQL.
 - Migrations error "Specified key was too long": ensure `DB_CHARSET=utf8mb4` and `DB_COLLATION=utf8mb4_unicode_ci` in `.env`.

 Quick copy checklist (PowerShell)
 ```powershell
 # From repo root
 composer install
 npm install
 Copy-Item .env.example .env
 php artisan key:generate
 # create DB in phpMyAdmin or run mysql CLI
 php artisan migrate --seed
 php artisan cache:clear
 php artisan serve
 # in second terminal
 npm run dev
 ```

 That's it — the app should be running locally on Windows. If you'd like, I can:
 - Add a short `start-dev.ps1` script that runs the commands for you, or
 - Add a one-click `.bat` for XAMPP users to start everything.

```
VITE v5.x.x  ready in xxx ms
```

#### 12. Open the Application

- **Main App**: http://localhost:8000
- **phpMyAdmin**: http://localhost/phpmyadmin (username: `root`, no password)

Test the symptom checker:
1. Click **"Check Symptoms"**
2. Select symptoms
3. Enter vital signs
4. View results

---

### macOS/Linux Setup

Same steps as above, but use package managers:

```bash
# Install Homebrew (if not installed)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP
brew install php@8.2

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
brew install node

# Install MySQL
brew install mysql

# Start MySQL
brew services start mysql

# Then follow the same Docker/setup steps as above
```

---

## Troubleshooting

### Error: "composer not found"
**Solution**: Composer not installed or not in PATH
```powershell
# Verify Composer installation
composer --version

# If not found, reinstall from: https://getcomposer.org/download/
```

### Error: "php not found"
**Solution**: PHP not in PATH
```powershell
# Verify PHP installation
php --version

# If not found, add PHP to PATH or use full path
C:\xampp\php\php.exe artisan serve
```

### Error: "SQLSTATE[HY000] [2002] Cannot assign requested address"
**Solution**: MySQL service not running
```powershell
# Start XAMPP and click "Start" for MySQL
# OR manually start MySQL service:
net start MySQL80
```

### Error: "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'"
**Solution**: Wrong database credentials in `.env`
```env
# Check these values in .env:
DB_HOST=127.0.0.1
DB_USERNAME=root
DB_PASSWORD=
# (leave password blank if you didn't set one)
```

### Error: "Specified key was too long" during migration
**Solution**: Update `.env` charset
```env
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

### Error: "npm ERR! code ERESOLVE"
**Solution**: Update npm
```powershell
npm install -g npm@latest
npm install
```

---

## Project Structure

```
health-advisor/
└── SyptomChecker/
    └── symptomcheck/
        ├── app/
        │   ├── Http/Controllers/
        │   │   ├── SymptomCheckerController.php
        │   │   ├── DashboardController.php
        │   │   └── ProfileController.php
        │   └── Models/
        │       ├── User.php
        │       ├── Symptom.php
        │       ├── Condition.php
        │       ├── Consultation.php
        │       └── ...
        ├── database/
        │   ├── migrations/        ← Database schema
        │   └── seeders/           ← Initial data
        ├── resources/
        │   ├── views/             ← Blade templates
        │   │   ├── symptom_checker/
        │   │   ├── blog/
        │   │   ├── dashboard/
        │   │   └── auth/
        │   ├── css/               ← Tailwind CSS
        │   └── js/
        ├── routes/
        │   └── web.php            ← URL routes
        ├── .env                   ← Configuration (create from .env.example)
        ├── composer.json          ← PHP dependencies
        ├── package.json           ← Node.js dependencies
        └── artisan                ← Laravel CLI
```

---

## Common Commands

```powershell
# Laravel commands
php artisan migrate              # Run database migrations
php artisan migrate:fresh        # Reset database (deletes data!)
php artisan db:seed              # Seed initial data
php artisan cache:clear          # Clear application cache
php artisan view:clear           # Clear compiled views
php artisan tinker               # Interactive PHP shell
php artisan serve                # Start dev server

# npm commands
npm run dev                       # Start Vite dev server
npm run build                     # Build for production
npm run lint                      # Check code style

# Composer commands
composer install                 # Install dependencies
composer update                  # Update dependencies
composer require package-name     # Add new package
```

---

## Environment Variables (.env)

Key variables to configure:

```env
# Application
APP_NAME=SymptomChecker
APP_ENV=local                    # Change to 'production' for prod
APP_DEBUG=true                   # Change to false for prod
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=symptomchecker
DB_USERNAME=root
DB_PASSWORD=

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (optional)
MAIL_MAILER=log                  # Use 'log' for development
```

---

## Production Deployment

For deploying to production (Azure, AWS, etc.):

1. Change `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Use strong database passwords
4. Use environment-specific `.env` files
5. Run `npm run build` before deploying
6. Configure proper logging and monitoring
7. Set up SSL/TLS certificates

See **ARCHITECTURE.md** for more deployment details.

---

## Getting Help

- **Laravel Documentation**: https://laravel.com/docs
- **Blade Templating**: https://laravel.com/docs/blade
- **Eloquent ORM**: https://laravel.com/docs/eloquent
- **Project Architecture**: See `ARCHITECTURE.md`
- **Project Defense**: See `PROJECT_DEFENSE_PRESENTATION.md`

---

## Verification Checklist

After setup, verify everything works:

- [ ] `php artisan serve` runs without errors
- [ ] `npm run dev` compiles assets
- [ ] http://localhost:8000 loads the home page
- [ ] http://localhost/phpmyadmin shows your database
- [ ] Database has 15+ tables
- [ ] Symptoms table has 50+ records
- [ ] "Check Symptoms" button works
- [ ] You can select symptoms and submit the form
- [ ] Results page displays matched conditions
- [ ] Dashboard shows consultation history

---

## Summary

**Total time to get running: ~15 minutes**

1. ✅ Install prerequisites (5 min)
2. ✅ Clone repository (1 min)
3. ✅ Install dependencies (3 min)
4. ✅ Configure .env (2 min)
5. ✅ Create database (1 min)
6. ✅ Run migrations (2 min)
7. ✅ Start servers (1 min)

**You're ready to contribute or present your project!** 🚀
