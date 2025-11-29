# Database SQL Files

This directory contains SQL dump files for the Budget Tracker database.

## Files

### `budget_tracker_schema.sql`
Contains the database schema (structure only) without any data. Use this file to:
- Set up a fresh database with the correct table structure
- Review the database design
- Initialize a new environment

**Import command:**
```bash
# MySQL
mysql -u your_username -p your_database_name < database/budget_tracker_schema.sql

# PostgreSQL (if migrating)
# You'll need to convert the schema or use Laravel migrations instead
php artisan migrate
```

### `budget_tracker_full.sql`
Contains the complete database dump including all data. Use this file to:
- Clone the entire database with sample data
- Backup/restore the database
- Migrate to another server with existing data

**Import command:**
```bash
mysql -u your_username -p your_database_name < database/budget_tracker_full.sql
```

## Laravel Migrations (Recommended)

Instead of importing SQL files, you can use Laravel migrations which work with both MySQL and PostgreSQL:

```bash
# Run all migrations
php artisan migrate

# Run migrations with seeding (if seeders exist)
php artisan migrate --seed

# Refresh database (drop all tables and re-migrate)
php artisan migrate:fresh

# Refresh with seeding
php artisan migrate:fresh --seed
```

## Database Structure

The database includes the following main tables:
- **users** - User authentication and profiles
- **accounts** - User financial accounts (cash, bank, credit card)
- **categories** - Transaction categories (income/expense)
- **transactions** - Financial transactions
- **budgets** - Budget tracking and limits
- **cache** - Application cache
- **jobs** - Queue jobs
- **sessions** - User sessions
- **personal_access_tokens** - API authentication tokens

## Notes

- The SQL dumps are for **MySQL/MariaDB**
- For **PostgreSQL** (used in Render deployment), use Laravel migrations instead
- Update SQL dumps periodically to reflect schema changes
- **Do not commit** `budget_tracker_full.sql` if it contains sensitive data
