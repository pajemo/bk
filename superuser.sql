-- SQL to create superuser and admin accounts in users table
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at)
VALUES 
('Superuser', 'superuser@example.com', '$2y$10$XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'super_admin', NOW(), NOW(), NOW()),
('Admin', 'admin@example.com', '$2y$10$YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY', 'admin', NOW(), NOW(), NOW());
