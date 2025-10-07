-- SQL Migration to add Theme Color Settings
-- Add theme color settings to system_settings table

-- Insert default theme colors if they don't exist
INSERT INTO system_settings (setting_key, setting_value, created_at) 
VALUES 
    ('theme_primary_color', '#0d6efd', NOW()),
    ('theme_secondary_color', '#6c757d', NOW()),
    ('theme_success_color', '#198754', NOW()),
    ('theme_danger_color', '#dc3545', NOW()),
    ('theme_warning_color', '#ffc107', NOW()),
    ('theme_info_color', '#0dcaf0', NOW()),
    ('theme_light_color', '#f8f9fa', NOW()),
    ('theme_dark_color', '#212529', NOW()),
    ('theme_chatbot_bg_color', '#0d6efd', NOW()),
    ('theme_chatbot_text_color', '#ffffff', NOW()),
    ('theme_chatbot_user_bg_color', '#e9ecef', NOW()),
    ('theme_chatbot_user_text_color', '#212529', NOW())
ON DUPLICATE KEY UPDATE 
    setting_key = VALUES(setting_key);

-- Note: This migration uses ON DUPLICATE KEY UPDATE to avoid errors if settings already exist
-- It will only insert if the setting_key doesn't exist, preserving existing configurations
