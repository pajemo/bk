-- Insert super admin user manually into users table
INSERT INTO users (name, email, PasswordHash, role, email_verified_at, created_at, updated_at)
VALUES (
    'Superuser',
    'superuser@example.com',
    -- Password hash for 'SuperSecretPassword123'
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'super_admin',
    NOW(),
    NOW(),
    NOW()
);
