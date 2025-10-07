-- Migration SQL for RecaudaBot Updates
-- This file contains the necessary SQL updates to support new features

-- ============================================
-- 1. Ensure system_settings table exists
-- ============================================
CREATE TABLE IF NOT EXISTS system_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. Insert default system settings
-- ============================================

-- PayPal Configuration
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('paypal_client_id', '', 'PayPal Client ID'),
('paypal_secret', '', 'PayPal Secret Key'),
('paypal_mode', 'sandbox', 'PayPal Mode (sandbox or live)'),
('paypal_currency', 'MXN', 'PayPal Currency Code');

-- Email Configuration
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('email_from', 'noreply@municipio.gob.mx', 'Email sender address'),
('email_from_name', 'RecaudaBot', 'Email sender name'),
('email_host', 'smtp.gmail.com', 'SMTP server host'),
('email_port', '587', 'SMTP server port'),
('email_username', '', 'SMTP username'),
('email_password', '', 'SMTP password'),
('email_encryption', 'tls', 'Email encryption (tls or ssl)');

-- Currency and Tax Configuration
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('currency_symbol', '$', 'Currency symbol'),
('currency_code', 'MXN', 'Currency code'),
('tax_rate', '16', 'Default tax rate percentage'),
('tax_include_in_price', '0', 'Whether tax is included in displayed prices');

-- Site Configuration
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('site_name', 'RecaudaBot', 'Site name'),
('site_description', 'Sistema Integral de Recaudación Municipal', 'Site description'),
('site_logo_url', '', 'URL to site logo'),
('site_favicon_url', '', 'URL to site favicon'),
('site_footer_text', 'Municipio. Todos los derechos reservados.', 'Footer text');

-- Terms and Conditions
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('terms_and_conditions', 'Al usar este sistema, usted acepta cumplir con todas las leyes y regulaciones municipales aplicables.', 'Terms and conditions text');

-- WhatsApp Configuration
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('whatsapp_number', '', 'WhatsApp chatbot number'),
('whatsapp_enabled', '0', 'Enable WhatsApp integration'),
('whatsapp_api_key', '', 'WhatsApp API key');

-- Banking Information
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('bank_name_1', 'Banco Nacional', 'Primary bank name'),
('bank_account_1', '', 'Primary bank account number'),
('bank_clabe_1', '', 'Primary bank CLABE'),
('bank_name_2', '', 'Secondary bank name'),
('bank_account_2', '', 'Secondary bank account number'),
('bank_clabe_2', '', 'Secondary bank CLABE');

-- Contact Information
INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES
('contact_phone_main', '', 'Main contact phone'),
('contact_phone_toll_free', '01 800 123 4567', 'Toll-free contact phone'),
('contact_email', 'info@municipio.gob.mx', 'Contact email'),
('contact_address', 'Palacio Municipal, Centro', 'Physical address'),
('contact_hours_weekday', '8:00 AM - 4:00 PM', 'Weekday hours'),
('contact_hours_saturday', '9:00 AM - 1:00 PM', 'Saturday hours'),
('contact_hours_sunday', 'Cerrado', 'Sunday hours');

-- ============================================
-- 3. Update users table to make username nullable
-- (since we're removing it from registration)
-- ============================================
ALTER TABLE users MODIFY COLUMN username VARCHAR(50) NULL;

-- Add unique constraint to prevent duplicate usernames
-- (only if it doesn't already exist)
ALTER TABLE users ADD UNIQUE INDEX idx_username_unique (username);

-- ============================================
-- 4. Update phone field validation
-- ============================================
-- No structural changes needed, validation is done at application level

-- ============================================
-- 5. Add indexes for better query performance
-- ============================================

-- Indexes for search and filtering
ALTER TABLE users ADD INDEX idx_full_name (full_name);
ALTER TABLE users ADD INDEX idx_created_at (created_at);

ALTER TABLE properties ADD INDEX idx_owner_name (owner_name);

ALTER TABLE property_taxes ADD INDEX idx_year_period (year, period);

-- ALTER TABLE traffic_fines ADD INDEX idx_folio (folio); -- Ya existe, línea comentada
ALTER TABLE traffic_fines ADD INDEX idx_driver_name (driver_name);

-- ALTER TABLE civic_fines ADD INDEX idx_folio (folio); -- Comenta si ya existe
-- ALTER TABLE civic_fines ADD INDEX idx_infractor_name (infractor_name); -- Comentada porque la columna no existe

ALTER TABLE payments ADD INDEX idx_paid_at (paid_at);
ALTER TABLE payments ADD INDEX idx_payment_type (payment_type);

-- ============================================
-- 6. Create audit log for imports (if not exists)
-- ============================================
CREATE TABLE IF NOT EXISTS import_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    import_type VARCHAR(50) NOT NULL,
    filename VARCHAR(255),
    records_imported INT DEFAULT 0,
    records_failed INT DEFAULT 0,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_import_type (import_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 7. Add report generation tracking
-- ============================================
CREATE TABLE IF NOT EXISTS report_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    report_type VARCHAR(50) NOT NULL,
    filters JSON,
    format VARCHAR(10) NOT NULL,
    records_count INT DEFAULT 0,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_report_type (report_type),
    INDEX idx_generated_at (generated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 8. Update existing data if necessary
-- ============================================

-- Set default usernames for existing users without one
UPDATE users 
SET username = CONCAT('user_', id) 
WHERE username IS NULL OR username = '';

-- ============================================
-- 9. Grant necessary permissions (if applicable)
-- ============================================
-- This would depend on your specific database user setup
-- Example:
-- GRANT SELECT, INSERT, UPDATE, DELETE ON recaudabot.* TO 'recaudabot_user'@'localhost';

-- ============================================
-- END OF MIGRATION
-- ============================================

-- Verification queries (run these to verify the migration)
-- SELECT * FROM system_settings ORDER BY setting_key;
-- SHOW INDEXES FROM users;
-- SHOW INDEXES FROM payments;
-- DESCRIBE import_logs;
-- DESCRIBE report_history;
