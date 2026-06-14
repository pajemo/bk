# EinlageCapital Banking System

A PHP/MySQL web banking platform with customer dashboards, transfers, loans, international transactions, and an administrative back office.

## Overview

This repository contains a traditional PHP application designed to run on Apache (for example via XAMPP) with MySQL as the database.

Main capabilities include:
- User registration, login, and verification flows
- Account dashboard and transaction history
- Deposits, withdrawals, local transfers, and international transfer handling
- Loan application and management flows
- Admin tools for users, transactions, activations, and operational content

## Tech Stack

- PHP 7.4+ (8.x recommended)
- MySQL/MariaDB
- Apache/Nginx (Apache + XAMPP is the primary local setup)
- PHPMailer (via Composer)
- HTML/CSS/JavaScript (Bootstrap-style frontend)

## Repository Structure

- `index.php`, `dashboard.php`, `login.php`, `register.php`: user-facing entry points
- `admin/`: admin panel pages and SQL migration snippets
- `uploads/`: runtime user-uploaded files (ignored in Git)
- `vendor/`: Composer dependencies (ignored in Git)
- `laravelproject/`: separate Laravel app area preserved as-is
- `database_schema.sql`, `database.sql`, `install.php`: database/install assets

## Local Setup (Windows + XAMPP)

1. Place the project in your web root:
   - `C:\xampp\htdocs\project2`
2. Create a MySQL database (example: `bank`).
3. Import schema files appropriate for your target environment (start from `database_schema.sql` and/or use `install.php`).
4. Install PHP dependencies:
   - `composer install`
5. Configure runtime values:
   - Database settings in `config.php`
   - SMTP settings via environment variables (see Environment Variables section)
6. Run Apache + MySQL in XAMPP.
7. Open:
   - `http://localhost/project2`

## Environment Variables

`mailer.php` supports environment variables for SMTP setup:

- `SMTP_HOST` (default: `smtp.gmail.com`)
- `SMTP_PORT` (default: `465`)
- `SMTP_SECURE` (default: `ssl`) - accepted: `ssl`, `tls`, `starttls`, `none`
- `SMTP_AUTH` (default: `true`)
- `SMTP_USERNAME`
- `SMTP_PASSWORD`
- `SMTP_FROM_EMAIL` (default: `SMTP_USERNAME`)
- `SMTP_FROM_NAME` (default: `EinlageCapital`)
- `SMTP_REPLY_TO_EMAIL` (default: `SMTP_FROM_EMAIL`)
- `SMTP_REPLY_TO_NAME` (default: `SMTP_FROM_NAME`)

Important:
- Do not commit real credentials to Git.
- Keep production secrets in server environment settings.

## GitHub Preparation Notes

This repository is configured to avoid committing common sensitive/runtime artifacts:
- Local credentials and override files
- Runtime uploads and temporary files
- Dependency folders (`vendor/`, `node_modules/`)
- Debug/test output and IDE system files

See `.gitignore` for details.

## Suggested First Commit Workflow

1. Initialize repository (if needed):
   - `git init`
2. Review changes:
   - `git status`
3. Add files:
   - `git add .`
4. Commit:
   - `git commit -m "Prepare project for GitHub with docs and safe defaults"`
5. Add remote and push:
   - `git remote add origin <your-repo-url>`
   - `git branch -M main`
   - `git push -u origin main`

## Security Checklist Before Publishing

- Remove any hardcoded credentials from all PHP files.
- Confirm `config.php`, mail credentials, and user-uploaded files are not staged.
- Rotate any secrets that may have been exposed previously.
- Review admin-only endpoints before making a repository public.

## Documentation

Additional project docs available in this repository:
- `PROJECT_DOCUMENTATION.md`
- `USER_GUIDE.md`
- `TECHNICAL_REFERENCE.md`
- `ADMIN_MANUAL.md`
- `ACTIVATION_SYSTEM_README.md`

## License

No open-source license is currently declared for this repository.
By default, all rights are reserved unless you add a specific license file.
