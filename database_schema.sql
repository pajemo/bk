-- Migration: 2024_06_01_000000_add_role_to_users_table.php
-- Add 'role' column only if it does not exist
ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(255) DEFAULT 'user' AFTER email;

-- Migration: 2024_07_10_000000_create_content_management_tables.php
CREATE TABLE IF NOT EXISTS contents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    body TEXT,
    type VARCHAR(255) DEFAULT 'page',
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS files (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(255) NOT NULL,
    mime_type VARCHAR(255),
    uploaded_by BIGINT UNSIGNED,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
    -- Foreign key constraint removed due to MySQL error 150
);

-- Migration: 2024_07_02_000000_add_missing_columns_to_users_table.php
-- Add columns only if they do not exist
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS FirstName VARCHAR(100) NULL AFTER id,
    ADD COLUMN IF NOT EXISTS Surname VARCHAR(100) NULL AFTER FirstName,
    ADD COLUMN IF NOT EXISTS DateOfBirth DATE NULL AFTER Surname,
    ADD COLUMN IF NOT EXISTS Address TEXT NULL AFTER DateOfBirth,
    ADD COLUMN IF NOT EXISTS PhoneNumber VARCHAR(20) NULL AFTER Address,
    ADD COLUMN IF NOT EXISTS IDType VARCHAR(50) NULL AFTER PhoneNumber,
    ADD COLUMN IF NOT EXISTS IDNumber VARCHAR(100) NULL AFTER IDType,
    ADD COLUMN IF NOT EXISTS IDUpload VARCHAR(255) NULL AFTER IDNumber;

-- Migration: 2024_07_05_000000_fix_users_primary_key_and_email_verification_columns.php
-- Rename UserID to id if exists
-- Add email_verified_at column if not exists
-- Drop IsEmailVerified column if exists
-- Adjust foreign keys in related tables accordingly

-- Migration: 2024_07_07_000000_create_accounts_table.php
CREATE TABLE IF NOT EXISTS accounts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    account_number VARCHAR(255) NOT NULL,
    balance DECIMAL(15,2) DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Migration: 2025_06_05_000000_create_admin_contents_table.php
CREATE TABLE IF NOT EXISTS admin_contents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
