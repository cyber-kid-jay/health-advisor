# MySQL Migration Guide for SymptomChecker

## Quick Start (5-Step Process)

Your project is already configured for MySQL. Follow these steps to switch from SQLite to MySQL:

### Step 1: Create MySQL Database & User
Use MySQL Workbench, phpMyAdmin, or command line:

```sql
-- Create database
CREATE DATABASE symptomchecker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user (recommended for security)
CREATE USER 'symptomchecker'@'localhost' IDENTIFIED BY 'SecurePassword123!';

-- Grant privileges
GRANT ALL PRIVILEGES ON symptomchecker.* TO 'symptomchecker'@'localhost';
FLUSH PRIVILEGES;

-- Or use root user (simpler for development)
-- Just leave username as 'root' and password blank in .env
```

### Step 2: Update .env File

Change line 23 from `DB_CONNECTION=sqlite` to:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=symptomchecker
DB_USERNAME=symptomchecker
DB_PASSWORD=SecurePassword123!
```

**For local development with root:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=symptomchecker
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Run Migrations

Navigate to project directory and run:

```powershell
cd c:\Users\DELL\Documents\symptomChecker-features\SyptomChecker\symptomcheck

# Clear existing caches
php artisan cache:clear
php artisan config:clear

# Run migrations (creates all tables)
php artisan migrate

# Seed the database (populates symptoms, conditions, treatments)
php artisan db:seed
```

### Step 4: Clear Application Caches

```powershell
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:cache
```

### Step 5: Verify Connection

```powershell
php artisan tinker
> DB::connection()->getPdo()
> // Should show connection details if successful
```

---

## Detailed Migration Process

### Prerequisites Checklist

- [ ] MySQL Server installed and running
- [ ] PHP with `pdo_mysql` extension enabled (you have this ✓)
- [ ] MySQL port 3306 accessible
- [ ] MySQL user created with appropriate privileges
- [ ] Project directory accessible in terminal

### MySQL Compatibility

All your Laravel migrations are **100% compatible with MySQL**. The tables will be created identically:

| Table | Columns | Notes |
|-------|---------|-------|
| **users** | id, name, email, password, timestamps | Standard Laravel auth |
| **symptoms** | id, name, category, severity (1-10), description | ~50 seeded symptoms |
| **conditions** | id, name, description, severity, prevalence | ~20 seeded conditions |
| **consultations** | id, user_id, notes, timestamps | Stores user checks |
| **condition_symptom** | condition_id, symptom_id | Many-to-many |
| **consultation_symptom** | consultation_id, symptom_id | Tracks selected symptoms |
| **consultation_condition** | consultation_id, condition_id, confidence | Stores matched conditions |
| **health_vitals** | id, consultation_id, temperature, bp, hr, o2_sat | Vital signs per check |
| **treatments** | id, condition_id, name, description | Treatment options |
| **medications** | id, condition_id, name, dosage, frequency | Medications per condition |
| **Sessions, cache, jobs, etc.** | (Laravel internals) | Managed automatically |

---

## Step-by-Step Implementation

### Option A: Local MySQL (Recommended for Development)

**1. Install MySQL on Windows**
- Download: https://dev.mysql.com/downloads/mysql/
- Or use: `choco install mysql` (if you have Chocolatey)
- Default port: 3306
- Default user: `root` (no password on fresh install)

**2. Verify MySQL is Running**
```powershell
# Check if MySQL service is running
Get-Service MySQL80  # or whatever version you have

# Connect to MySQL (test connection)
mysql -u root
# Should see: mysql>
# Type: EXIT; to quit
```

**3. Create Database**
```powershell
mysql -u root
```

```sql
CREATE DATABASE symptomchecker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

**4. Update `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=symptomchecker
DB_USERNAME=root
DB_PASSWORD=
```

**5. Run Migrations**
```powershell
php artisan migrate --seed
```

---

### Option B: Remote MySQL (Cloud Hosting)

If using cloud MySQL (Azure Database for MySQL, AWS RDS, etc.):

```env
DB_CONNECTION=mysql
DB_HOST=your-server.mysql.database.azure.com
DB_PORT=3306
DB_DATABASE=symptomchecker
DB_USERNAME=adminuser@servername
DB_PASSWORD=CloudPassword123!
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

Then run migrations the same way:
```powershell
php artisan migrate --seed
```

---

## Troubleshooting MySQL Migration

### Error: "SQLSTATE[HY000] [1045] Access denied for user"
**Solution**: Check DB_USERNAME and DB_PASSWORD in `.env` file
```powershell
# Test connection manually
mysql -h 127.0.0.1 -u root -p
# Enter password if required
```

### Error: "SQLSTATE[HY000] [2002] Cannot assign requested address"
**Solution**: MySQL service not running
```powershell
# Start MySQL (Windows)
net start MySQL80  # or your version

# Or restart from Services:
# Windows Services → Search "Services" → Find MySQL → Right-click → Start
```

### Error: "Specified key was too long" on migration
**Solution**: Update charset in `.env`
```env
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

### Error: "Table already exists"
**Solution**: Database not empty. Either:
- Delete all tables and run: `php artisan migrate`
- Or: `php artisan migrate:fresh` (WARNING: deletes all data)

---

## Verification Steps

After migration, verify everything worked:

### 1. Check Database Connection
```powershell
php artisan tinker
DB::select('SELECT VERSION()')
# Should return MySQL version
```

### 2. Verify Tables Created
```powershell
php artisan tinker
DB::select('SHOW TABLES')
# Should show ~15 tables
```

### 3. Verify Data Seeded
```powershell
php artisan tinker
DB::table('symptoms')->count()
# Should return 50+ symptoms

DB::table('conditions')->count()
# Should return 20+ conditions
```

### 4. Test the Application
```powershell
php artisan serve
# Visit http://localhost:8000
# Test symptom checker flow
```

---

## Common MySQL Settings

### Connection Configuration (in `config/database.php`)
- **Driver**: `mysql`
- **Host**: `127.0.0.1` (local) or your cloud server
- **Port**: `3306` (default)
- **Charset**: `utf8mb4` (recommended for international support)
- **Collation**: `utf8mb4_unicode_ci` (case-insensitive)

### Recommended `.env` for Production
```env
DB_CONNECTION=mysql
DB_HOST=your-mysql-server.com
DB_PORT=3306
DB_DATABASE=symptomchecker_prod
DB_USERNAME=prod_user
DB_PASSWORD=StrongSecurePassword123!@
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

---

## Migration Data (If You Have Existing SQLite Data)

If you have data in SQLite that you want to migrate:

### Option 1: Export & Import (Recommended)
```powershell
# 1. Export from SQLite to CSV
php artisan export:csv

# 2. Import to MySQL
php artisan import:csv
```

### Option 2: Data Transfer Script
Create `database/migrations/transfer_data.php`:
```php
php artisan tinker

// Copy from SQLite to MySQL
$symptoms = DB::connection('sqlite')->table('symptoms')->get();
foreach ($symptoms as $symptom) {
    DB::connection('mysql')->table('symptoms')->insert((array)$symptom);
}
```

### Option 3: Fresh Start (Simpler)
Just run seeders to repopulate from scratch:
```powershell
php artisan db:seed
```

---

## Performance Optimization for MySQL

### Recommended Indexes (Already in Migrations)
Your migrations already include:
- PK on all tables (automatic)
- FK indexes on relationships
- Unique on emails (users table)

### Connection Pooling (Optional for Production)
```env
DB_POOL_MIN=2
DB_POOL_MAX=10
```

### Query Caching
```php
// In controller
$symptoms = Cache::remember('symptoms', 3600, function () {
    return Symptom::all();
});
```

---

## Switching Back to PostgreSQL (If Needed)

If you need to switch databases later:

```env
# For PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=symptomchecker
DB_USERNAME=postgres
DB_PASSWORD=password

# Then:
php artisan migrate:fresh --seed
```

The Laravel migrations work for both MySQL and PostgreSQL without changes!

---

## MySQL vs PostgreSQL Comparison

| Feature | MySQL | PostgreSQL |
|---------|-------|-----------|
| **Setup** | Simpler, more common | Slightly more complex |
| **Performance** | Good for small-medium apps | Better for complex queries |
| **JSON Support** | Good (`JSON` type) | Excellent (`JSONB` type) |
| **Scalability** | Good | Excellent |
| **Free/Open Source** | Yes | Yes |
| **Cloud Support** | Excellent (AWS RDS, Azure) | Excellent (AWS RDS, Azure) |
| **Laravel Support** | Full | Full |

**For your project**: MySQL is perfectly fine and more commonly taught in universities.

---

## Quick Reference: Complete Migration Steps

```powershell
# 1. Create MySQL database
mysql -u root
CREATE DATABASE symptomchecker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# 2. Update .env
# Change: DB_CONNECTION=sqlite
# To: DB_CONNECTION=mysql (and add DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 3. Clear caches
cd c:\Users\DELL\Documents\symptomChecker-features\SyptomChecker\symptomcheck
php artisan cache:clear
php artisan config:clear

# 4. Run migrations and seeds
php artisan migrate --seed

# 5. Start server
php artisan serve

# 6. Visit http://localhost:8000 and test!
```

---

## Summary

✅ **All your code is MySQL-ready**
✅ **PHP has MySQL driver installed**
✅ **Laravel config already supports MySQL**
✅ **Migrations are database-agnostic**
✅ **Seeds work with MySQL**

**Just 5 steps to migrate:**
1. Create MySQL database
2. Update `.env` file
3. Run migrations
4. Run seeders
5. Test the application

You're ready to go! 🚀
