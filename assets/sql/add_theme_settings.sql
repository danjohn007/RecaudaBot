-- SQL Migration to add Theme Color Settings
-- Add theme color settings to system_settings table

-- Insert default theme colors if they don't exist
INSERT INTO system_settings (setting_key, setting_value)
VALUES 
    ('theme_primary_color', '#0d6efd'),
    ('theme_secondary_color', '#6c757d'),
    ('theme_success_color', '#198754'),
    ('theme_danger_color', '#dc3545'),
    ('theme_warning_color', '#ffc107'),
    ('theme_info_color', '#0dcaf0'),
    ('theme_light_color', '#f8f9fa'),
    ('theme_dark_color', '#212529'),
    ('theme_chatbot_bg_color', '#0d6efd'),
    ('theme_chatbot_text_color', '#ffffff'),
    ('theme_chatbot_user_bg_color', '#e9ecef'),
    ('theme_chatbot_user_text_color', '#212529')
ON DUPLICATE KEY UPDATE 
    setting_value = VALUES(setting_value);

-- Note: This migration uses ON DUPLICATE KEY UPDATE to avoid errors if settings already exist
-- It will only insert if the setting_key doesn't exist, preserving existing configurations
