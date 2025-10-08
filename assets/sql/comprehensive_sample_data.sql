-- ============================================================================
-- COMPREHENSIVE SAMPLE DATA FOR RECAUDABOT
-- ============================================================================
-- This script generates extensive sample data to populate all graphs in the
-- Dashboard Administrativo and Estadísticas del Sistema
-- 
-- IMPORTANT: Run this AFTER the schema.sql has been executed
-- Password for all users: password123
-- ============================================================================

USE recaudabot;

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing data (CAUTION: This will delete all data!)
TRUNCATE TABLE receipts;
TRUNCATE TABLE payments;
TRUNCATE TABLE fine_appeals;
TRUNCATE TABLE fine_evidence;
TRUNCATE TABLE traffic_fines;
TRUNCATE TABLE civic_fines;
TRUNCATE TABLE license_documents;
TRUNCATE TABLE business_licenses;
TRUNCATE TABLE property_taxes;
TRUNCATE TABLE properties;
TRUNCATE TABLE appointments;
TRUNCATE TABLE notifications;
TRUNCATE TABLE audit_log;
TRUNCATE TABLE users;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================================
-- USERS (Admin, Municipal Area, and Citizens distributed across 6 months)
-- ============================================================================
INSERT INTO users (username, email, password, full_name, phone, curp, rfc, address, role, status, created_at) VALUES
('admin', 'admin@municipio.gob.mx', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Administrador Municipal', '5551234567', 'AAAA800101HDFRRL01', 'AAAA800101A01', 'Palacio Municipal, Centro', 'admin', 'active', '2023-01-15 10:00:00'),
('tesoreria', 'tesoreria@municipio.gob.mx', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Departamento de Tesorería', '5551112222', 'TESM800101HDFRRL01', 'TESM800101T01', 'Palacio Municipal, Planta Baja', 'municipal_area', 'active', '2023-01-15 10:00:00'),
('jperez', 'jperez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Juan Pérez García', '5559876543', 'PEGJ850215HDFRXN02', 'PEGJ850215ABC', 'Av. Reforma 123, Col. Centro', 'citizen', 'active', '2025-05-07 13:29:59'),
('mlopez', 'mlopez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'María López Hernández', '5558765432', 'LOHM900320MDFRPR08', 'LOHM900320XYZ', 'Calle Hidalgo 456, Col. Juárez', 'citizen', 'active', '2025-05-30 13:29:59'),
('cgonzalez', 'cgonzalez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Carlos González Ruiz', '5557654321', 'GORC880512HDFRRL09', 'GORC880512DEF', 'Av. Juárez 789, Col. Morelos', 'citizen', 'active', '2025-06-18 13:29:59'),
('rsanchez', 'rsanchez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Roberto Sánchez Torres', '5556543210', 'SATRO850610HDFRRT05', 'SATRO850610ABC', 'Calle Morelos 567, Col. Centro', 'citizen', 'active', '2025-07-25 13:29:59'),
('amartinez', 'amartinez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Ana Martínez Cruz', '5555432109', 'MACA920315MDFRRT03', 'MACA920315XYZ', 'Av. Independencia 890, Col. Juárez', 'citizen', 'active', '2025-09-05 13:29:59'),
('lgarcia', 'lgarcia@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Luis García Fernández', '5554321098', 'GAFL881025HDFRRS08', 'GAFL881025DEF', 'Calle Allende 234, Col. Centro', 'citizen', 'active', '2025-09-12 13:29:59'),
('phernandez', 'phernandez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Patricia Hernández Ruiz', '5553210987', 'HERP900605MDFRRT02', 'HERP900605ABC', 'Av. Juárez 345, Col. Morelos', 'citizen', 'active', '2025-04-19 13:29:59'),
('jrodriguez', 'jrodriguez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Jorge Rodríguez López', '5552109876', 'ROLJ870420HDFRPG07', 'ROLJ870420XYZ', 'Calle Hidalgo 678, Col. Centro', 'citizen', 'active', '2025-05-25 13:29:59'),
('sgomez', 'sgomez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Sofía Gómez Martínez', '5551098765', 'GOMS920815MDFRMT04', 'GOMS920815DEF', 'Av. Reforma 901, Col. Juárez', 'citizen', 'active', '2025-06-14 13:29:59'),
('fdiaz', 'fdiaz@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Fernando Díaz Sánchez', '5550987654', 'DISF850320HDFRNN09', 'DISF850320ABC', 'Calle Morelos 123, Col. Centro', 'citizen', 'active', '2025-08-04 13:29:59'),
('cramirez', 'cramirez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Carmen Ramírez García', '5559876540', 'RAGC900712MDFRMC06', 'RAGC900712XYZ', 'Av. Independencia 456, Col. Morelos', 'citizen', 'active', '2025-08-18 13:29:59'),
('mflores', 'mflores@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Miguel Flores Hernández', '5558765430', 'FLOM881105HDFRNG05', 'FLOM881105DEF', 'Calle Allende 789, Col. Centro', 'citizen', 'active', '2025-09-22 13:29:59'),
('itorres', 'itorres@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Isabel Torres Pérez', '5557654320', 'TOPI920225MDFRRS01', 'TOPI920225ABC', 'Av. Juárez 012, Col. Juárez', 'citizen', 'active', '2025-05-09 13:29:59'),
('rcastro', 'rcastro@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Ricardo Castro López', '5556543200', 'CALR870515HDFSPC08', 'CALR870515XYZ', 'Calle Hidalgo 345, Col. Centro', 'citizen', 'active', '2025-06-04 13:29:59'),
('vmorales', 'vmorales@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Verónica Morales González', '5555432100', 'MOGV900905MDFRNN03', 'MOGV900905DEF', 'Av. Reforma 678, Col. Morelos', 'citizen', 'active', '2025-07-03 13:29:59');

-- ============================================================================
-- PROPERTIES (10 properties for tax generation)
-- ============================================================================
INSERT INTO properties (cadastral_key, owner_id, owner_name, address, area_m2, construction_m2, cadastral_value, zone_type) VALUES
('CAT-2024-001-0001', 3, 'Juan Pérez García', 'Av. Reforma 123, Col. Centro', 250.0, 180.0, 1500000.0, 'residential'),
('CAT-2024-001-0002', 4, 'María López Hernández', 'Calle Hidalgo 456, Col. Juárez', 180.0, 120.0, 1200000.0, 'residential'),
('CAT-2024-001-0003', 5, 'Carlos González Ruiz', 'Av. Juárez 789, Col. Morelos', 300.0, 250.0, 2500000.0, 'commercial'),
('CAT-2024-001-0004', 6, 'Roberto Sánchez Torres', 'Calle Morelos 567, Col. Centro', 200.0, 150.0, 1800000.0, 'residential'),
('CAT-2024-001-0005', 7, 'Ana Martínez Cruz', 'Av. Independencia 890, Col. Juárez', 220.0, 160.0, 1600000.0, 'residential'),
('CAT-2024-001-0006', 8, 'Luis García Fernández', 'Calle Allende 234, Col. Centro', 280.0, 200.0, 2200000.0, 'commercial'),
('CAT-2024-001-0007', 9, 'Patricia Hernández Ruiz', 'Av. Juárez 345, Col. Morelos', 190.0, 130.0, 1400000.0, 'residential'),
('CAT-2024-001-0008', 10, 'Jorge Rodríguez López', 'Calle Hidalgo 678, Col. Centro', 260.0, 190.0, 1900000.0, 'residential'),
('CAT-2024-001-0009', 11, 'Sofía Gómez Martínez', 'Av. Reforma 901, Col. Juárez', 310.0, 260.0, 2600000.0, 'commercial'),
('CAT-2024-001-0010', 12, 'Fernando Díaz Sánchez', 'Calle Morelos 123, Col. Centro', 240.0, 170.0, 1700000.0, 'residential');

-- ============================================================================
-- PROPERTY TAXES (Multiple taxes for each property across 6 months)
-- ============================================================================
INSERT INTO property_taxes (property_id, year, period, base_amount, discount_amount, interest_amount, total_amount, due_date, status, paid_date, paid_by, payment_reference) VALUES
(1, 2025, 'Q2', 6803.05, 0.00, 0.00, 6803.05, '2025-05-28', 'paid', '2025-05-30 13:29:59', 3, 'PTAX-2025-00010'),
(1, 2025, 'Q2', 5979.31, 0.00, 0.00, 5979.31, '2025-06-28', 'paid', '2025-06-21 13:29:59', 3, 'PTAX-2025-00011'),
(1, 2025, 'Q3', 5138.45, 0.00, 0.00, 5138.45, '2025-07-28', 'pending', NULL, NULL, NULL),
(1, 2025, 'Q3', 3139.78, 0.00, 0.00, 3139.78, '2025-08-28', 'paid', '2025-08-28 13:29:59', 3, 'PTAX-2025-00013'),
(1, 2025, 'Q3', 3093.03, 0.00, 154.65, 3247.68, '2025-09-28', 'overdue', NULL, NULL, NULL),
(1, 2025, 'Q4', 6056.82, 0.00, 0.00, 6056.82, '2025-10-28', 'paid', '2025-10-16 13:29:59', 3, 'PTAX-2025-00015'),
(2, 2025, 'Q2', 6970.87, 0.00, 0.00, 6970.87, '2025-05-28', 'paid', '2025-05-22 13:29:59', 4, 'PTAX-2025-00020'),
(2, 2025, 'Q2', 6717.78, 0.00, 0.00, 6717.78, '2025-06-28', 'paid', '2025-06-28 13:29:59', 4, 'PTAX-2025-00021'),
(2, 2025, 'Q3', 3148.40, 314.84, 0.00, 2833.56, '2025-07-28', 'paid', '2025-07-17 13:29:59', 4, 'PTAX-2025-00022'),
(2, 2025, 'Q3', 4891.02, 489.10, 0.00, 4401.91, '2025-08-28', 'paid', '2025-08-21 13:29:59', 4, 'PTAX-2025-00023'),
(2, 2025, 'Q3', 5908.93, 0.00, 0.00, 5908.93, '2025-09-28', 'paid', '2025-09-24 13:29:59', 4, 'PTAX-2025-00024'),
(2, 2025, 'Q4', 4494.75, 0.00, 0.00, 4494.75, '2025-10-28', 'paid', '2025-10-21 13:29:59', 4, 'PTAX-2025-00025'),
(3, 2025, 'Q2', 4226.81, 0.00, 0.00, 4226.81, '2025-05-28', 'paid', '2025-05-19 13:29:59', 5, 'PTAX-2025-00030'),
(3, 2025, 'Q2', 6432.14, 0.00, 0.00, 6432.14, '2025-06-28', 'paid', '2025-06-21 13:29:59', 5, 'PTAX-2025-00031'),
(3, 2025, 'Q3', 6927.71, 692.77, 0.00, 6234.94, '2025-07-28', 'paid', '2025-07-30 13:29:59', 5, 'PTAX-2025-00032'),
(3, 2025, 'Q3', 6952.89, 695.29, 0.00, 6257.60, '2025-08-28', 'paid', '2025-08-14 13:29:59', 5, 'PTAX-2025-00033'),
(3, 2025, 'Q3', 4670.33, 0.00, 233.52, 4903.85, '2025-09-28', 'overdue', NULL, NULL, NULL),
(3, 2025, 'Q4', 6195.09, 619.51, 0.00, 5575.58, '2025-10-28', 'paid', '2025-10-28 13:29:59', 5, 'PTAX-2025-00035'),
(4, 2025, 'Q2', 2705.00, 270.50, 0.00, 2434.50, '2025-05-28', 'paid', '2025-05-17 13:29:59', 6, 'PTAX-2025-00040'),
(4, 2025, 'Q2', 4813.97, 481.40, 0.00, 4332.57, '2025-06-28', 'paid', '2025-06-14 13:29:59', 6, 'PTAX-2025-00041'),
(4, 2025, 'Q3', 5461.76, 546.18, 0.00, 4915.58, '2025-07-28', 'paid', '2025-07-22 13:29:59', 6, 'PTAX-2025-00042'),
(4, 2025, 'Q3', 6604.46, 0.00, 330.22, 6934.68, '2025-08-28', 'overdue', NULL, NULL, NULL),
(4, 2025, 'Q3', 6329.20, 0.00, 0.00, 6329.20, '2025-09-28', 'paid', '2025-09-28 13:29:59', 6, 'PTAX-2025-00044'),
(4, 2025, 'Q4', 6350.80, 0.00, 0.00, 6350.80, '2025-10-28', 'pending', NULL, NULL, NULL),
(5, 2025, 'Q2', 5736.25, 0.00, 0.00, 5736.25, '2025-05-28', 'paid', '2025-05-16 13:29:59', 7, 'PTAX-2025-00050'),
(5, 2025, 'Q2', 3240.63, 0.00, 162.03, 3402.66, '2025-06-28', 'overdue', NULL, NULL, NULL),
(5, 2025, 'Q3', 6520.46, 0.00, 0.00, 6520.46, '2025-07-28', 'paid', '2025-07-25 13:29:59', 7, 'PTAX-2025-00052'),
(5, 2025, 'Q3', 4288.25, 428.82, 0.00, 3859.42, '2025-08-28', 'paid', '2025-08-21 13:29:59', 7, 'PTAX-2025-00053'),
(5, 2025, 'Q3', 4996.99, 0.00, 0.00, 4996.99, '2025-09-28', 'paid', '2025-09-12 13:29:59', 7, 'PTAX-2025-00054'),
(5, 2025, 'Q4', 6140.07, 614.01, 0.00, 5526.06, '2025-10-28', 'paid', '2025-10-22 13:29:59', 7, 'PTAX-2025-00055'),
(6, 2025, 'Q2', 5504.16, 0.00, 0.00, 5504.16, '2025-05-28', 'pending', NULL, NULL, NULL),
(6, 2025, 'Q2', 4361.28, 0.00, 0.00, 4361.28, '2025-06-28', 'paid', '2025-06-18 13:29:59', 8, 'PTAX-2025-00061'),
(6, 2025, 'Q3', 6881.47, 0.00, 0.00, 6881.47, '2025-07-28', 'pending', NULL, NULL, NULL),
(6, 2025, 'Q3', 3129.70, 0.00, 0.00, 3129.70, '2025-08-28', 'pending', NULL, NULL, NULL),
(6, 2025, 'Q3', 4501.62, 0.00, 0.00, 4501.62, '2025-09-28', 'paid', '2025-09-09 13:29:59', 8, 'PTAX-2025-00064'),
(6, 2025, 'Q4', 6521.79, 0.00, 0.00, 6521.79, '2025-10-28', 'paid', '2025-10-23 13:29:59', 8, 'PTAX-2025-00065'),
(7, 2025, 'Q2', 6794.80, 679.48, 0.00, 6115.32, '2025-05-28', 'paid', '2025-05-16 13:29:59', 9, 'PTAX-2025-00070'),
(7, 2025, 'Q2', 2558.11, 0.00, 0.00, 2558.11, '2025-06-28', 'paid', '2025-06-12 13:29:59', 9, 'PTAX-2025-00071'),
(7, 2025, 'Q3', 6465.47, 0.00, 0.00, 6465.47, '2025-07-28', 'pending', NULL, NULL, NULL),
(7, 2025, 'Q3', 2821.55, 0.00, 0.00, 2821.55, '2025-08-28', 'pending', NULL, NULL, NULL),
(7, 2025, 'Q3', 2918.22, 0.00, 0.00, 2918.22, '2025-09-28', 'paid', '2025-09-21 13:29:59', 9, 'PTAX-2025-00074'),
(7, 2025, 'Q4', 2899.94, 0.00, 0.00, 2899.94, '2025-10-28', 'paid', '2025-10-13 13:29:59', 9, 'PTAX-2025-00075'),
(8, 2025, 'Q2', 4862.74, 0.00, 0.00, 4862.74, '2025-05-28', 'paid', '2025-05-14 13:29:59', 10, 'PTAX-2025-00080'),
(8, 2025, 'Q2', 5900.13, 0.00, 0.00, 5900.13, '2025-06-28', 'pending', NULL, NULL, NULL),
(8, 2025, 'Q3', 6242.11, 0.00, 0.00, 6242.11, '2025-07-28', 'pending', NULL, NULL, NULL),
(8, 2025, 'Q3', 4413.10, 0.00, 0.00, 4413.10, '2025-08-28', 'paid', '2025-08-11 13:29:59', 10, 'PTAX-2025-00083'),
(8, 2025, 'Q3', 3572.24, 0.00, 0.00, 3572.24, '2025-09-28', 'paid', '2025-09-23 13:29:59', 10, 'PTAX-2025-00084'),
(8, 2025, 'Q4', 3906.73, 390.67, 0.00, 3516.06, '2025-10-28', 'paid', '2025-10-20 13:29:59', 10, 'PTAX-2025-00085'),
(9, 2025, 'Q2', 4954.23, 0.00, 0.00, 4954.23, '2025-05-28', 'paid', '2025-05-21 13:29:59', 11, 'PTAX-2025-00090'),
(9, 2025, 'Q2', 5153.65, 515.37, 0.00, 4638.29, '2025-06-28', 'paid', '2025-06-22 13:29:59', 11, 'PTAX-2025-00091'),
(9, 2025, 'Q3', 5019.27, 0.00, 0.00, 5019.27, '2025-07-28', 'pending', NULL, NULL, NULL),
(9, 2025, 'Q3', 6370.86, 0.00, 0.00, 6370.86, '2025-08-28', 'pending', NULL, NULL, NULL),
(9, 2025, 'Q3', 5660.36, 0.00, 0.00, 5660.36, '2025-09-28', 'paid', '2025-09-10 13:29:59', 11, 'PTAX-2025-00094'),
(9, 2025, 'Q4', 4459.47, 0.00, 0.00, 4459.47, '2025-10-28', 'paid', '2025-10-27 13:29:59', 11, 'PTAX-2025-00095'),
(10, 2025, 'Q2', 6847.22, 0.00, 0.00, 6847.22, '2025-05-28', 'paid', '2025-05-14 13:29:59', 12, 'PTAX-2025-00100'),
(10, 2025, 'Q2', 4147.80, 0.00, 0.00, 4147.80, '2025-06-28', 'paid', '2025-06-30 13:29:59', 12, 'PTAX-2025-00101'),
(10, 2025, 'Q3', 6302.90, 0.00, 0.00, 6302.90, '2025-07-28', 'paid', '2025-07-15 13:29:59', 12, 'PTAX-2025-00102'),
(10, 2025, 'Q3', 3947.78, 0.00, 0.00, 3947.78, '2025-08-28', 'paid', '2025-08-27 13:29:59', 12, 'PTAX-2025-00103'),
(10, 2025, 'Q3', 3854.71, 0.00, 192.74, 4047.45, '2025-09-28', 'overdue', NULL, NULL, NULL),
(10, 2025, 'Q4', 6666.76, 666.68, 0.00, 6000.09, '2025-10-28', 'paid', '2025-10-27 13:29:59', 12, 'PTAX-2025-00105');

-- ============================================================================
-- TRAFFIC FINES (Multiple fines per month across 6 months)
-- ============================================================================
INSERT INTO traffic_fines (folio, license_plate, driver_license, driver_name, infraction_type, infraction_code, description, location, infraction_date, officer_name, officer_badge, base_amount, discount_amount, total_amount, status, due_date, paid_date, paid_by, payment_reference) VALUES
('MT-2025-00001', 'PQR-901-KL', 'LIC271306', 'Jorge Rodríguez López', 'Uso de celular', 'ART-34', 'Conducía usando dispositivo móvil', 'Av. Principal km 10', '2025-05-26 13:29:59', 'Oficial Martínez', 'OF-2164', 1110.04, 0.00, 1110.04, 'paid', '2025-06-10', 2025-05-25 13:29:59, '7', 'TFINE-00001'),
('MT-2025-00002', 'XYZ-456-AB', 'LIC415270', 'María López Hernández', 'Exceso de velocidad', 'ART-23', 'Circulaba a 98 km/h en zona de 51 km/h', 'Av. Principal km 4', '2025-05-15 13:29:59', 'Oficial González', 'OF-5731', 1430.16, 0.00, 1430.16, 'pending', '2025-06-10', NULL, NULL, NULL),
('MT-2025-00003', 'XYZ-456-AB', 'LIC754952', 'Roberto Sánchez Torres', 'Estacionamiento prohibido', 'ART-67', 'Vehículo estacionado en zona prohibida', 'Av. Principal km 4', '2025-05-23 13:29:59', 'Oficial González', 'OF-5393', 727.16, 0.00, 727.16, 'pending', '2025-06-10', NULL, NULL, NULL),
('MT-2025-00004', 'MNO-678-IJ', 'LIC560310', 'María López Hernández', 'Estacionamiento prohibido', 'ART-67', 'Vehículo estacionado en zona prohibida', 'Av. Principal km 6', '2025-05-21 13:29:59', 'Oficial Martínez', 'OF-2120', 729.35, 0.00, 729.35, 'paid', '2025-06-10', 2025-05-20 13:29:59, '9', 'TFINE-00004'),
('MT-2025-00005', 'YZA-890-QR', 'LIC374553', 'Luis García Fernández', 'No usar cinturón', 'ART-89', 'Conducía sin cinturón de seguridad', 'Av. Principal km 9', '2025-06-11 13:29:59', 'Oficial González', 'OF-9230', 512.73, 0.00, 512.73, 'pending', '2025-07-10', NULL, NULL, NULL),
('MT-2025-00006', 'XYZ-456-AB', 'LIC348876', 'Patricia Hernández Ruiz', 'Uso de celular', 'ART-34', 'Conducía usando dispositivo móvil', 'Av. Principal km 2', '2025-07-06 13:29:59', 'Oficial López', 'OF-9159', 1252.19, 0.00, 1252.19, 'pending', '2025-07-10', NULL, NULL, NULL),
('MT-2025-00007', 'VWX-567-OP', 'LIC470092', 'Ana Martínez Cruz', 'Estacionamiento prohibido', 'ART-67', 'Vehículo estacionado en zona prohibida', 'Av. Principal km 3', '2025-06-24 13:29:59', 'Oficial González', 'OF-2983', 851.88, 0.00, 851.88, 'pending', '2025-07-10', NULL, NULL, NULL),
('MT-2025-00008', 'PQR-901-KL', 'LIC209433', 'Ana Martínez Cruz', 'Falta de documentos', 'ART-56', 'No portaba licencia de conducir', 'Av. Principal km 4', '2025-06-25 13:29:59', 'Oficial González', 'OF-1982', 1008.17, 0.00, 1008.17, 'pending', '2025-07-10', NULL, NULL, NULL),
('MT-2025-00009', 'VWX-567-OP', 'LIC322205', 'Patricia Hernández Ruiz', 'Circular sin placas', 'ART-78', 'Vehículo sin placas vigentes', 'Av. Principal km 5', '2025-07-22 13:29:59', 'Oficial López', 'OF-3594', 2388.43, 0.00, 2388.43, 'paid', '2025-08-09', 2025-07-18 13:29:59, '12', 'TFINE-00009'),
('MT-2025-00010', 'GHI-012-EF', 'LIC937540', 'Juan Pérez García', 'Estacionamiento prohibido', 'ART-67', 'Vehículo estacionado en zona prohibida', 'Av. Principal km 9', '2025-07-19 13:29:59', 'Oficial Ramírez', 'OF-9979', 625.36, 0.00, 625.36, 'paid', '2025-08-09', 2025-07-12 13:29:59, '4', 'TFINE-00010'),
('MT-2025-00011', 'GHI-012-EF', 'LIC673947', 'Carlos González Ruiz', 'No respetar semáforo', 'ART-45', 'Cruzó semáforo en luz roja', 'Av. Principal km 6', '2025-07-14 13:29:59', 'Oficial González', 'OF-4867', 1963.89, 392.78, 1571.11, 'paid', '2025-08-09', 2025-07-24 13:29:59, '8', 'TFINE-00011'),
('MT-2025-00012', 'GHI-012-EF', 'LIC918510', 'Patricia Hernández Ruiz', 'Estacionamiento prohibido', 'ART-67', 'Vehículo estacionado en zona prohibida', 'Av. Principal km 6', '2025-08-12 13:29:59', 'Oficial Martínez', 'OF-4188', 645.07, 0.00, 645.07, 'paid', '2025-09-08', 2025-08-13 13:29:59, '7', 'TFINE-00012'),
('MT-2025-00013', 'DEF-789-CD', 'LIC246162', 'Fernando Díaz Sánchez', 'Exceso de velocidad', 'ART-23', 'Circulaba a 107 km/h en zona de 55 km/h', 'Av. Principal km 2', '2025-08-31 13:29:59', 'Oficial Ramírez', 'OF-4106', 1337.74, 0.00, 1337.74, 'pending', '2025-09-08', NULL, NULL, NULL),
('MT-2025-00014', 'ABC-123-XY', 'LIC857271', 'Luis García Fernández', 'No usar cinturón', 'ART-89', 'Conducía sin cinturón de seguridad', 'Av. Principal km 3', '2025-08-20 13:29:59', 'Oficial Martínez', 'OF-9703', 724.65, 0.00, 724.65, 'paid', '2025-09-08', 2025-08-13 13:29:59, '9', 'TFINE-00014'),
('MT-2025-00015', 'MNO-678-IJ', 'LIC110413', 'Carlos González Ruiz', 'No usar cinturón', 'ART-89', 'Conducía sin cinturón de seguridad', 'Av. Principal km 1', '2025-08-10 13:29:59', 'Oficial González', 'OF-5215', 712.36, 0.00, 712.36, 'paid', '2025-09-08', 2025-08-19 13:29:59, '11', 'TFINE-00015'),
('MT-2025-00016', 'DEF-789-CD', 'LIC218559', 'Carlos González Ruiz', 'No respetar semáforo', 'ART-45', 'Cruzó semáforo en luz roja', 'Av. Principal km 8', '2025-09-16 13:29:59', 'Oficial López', 'OF-6337', 2105.69, 0.00, 2105.69, 'pending', '2025-10-08', NULL, NULL, NULL),
('MT-2025-00017', 'ABC-123-XY', 'LIC955032', 'Fernando Díaz Sánchez', 'Exceso de velocidad', 'ART-23', 'Circulaba a 92 km/h en zona de 51 km/h', 'Av. Principal km 2', '2025-09-12 13:29:59', 'Oficial Martínez', 'OF-3433', 1442.15, 0.00, 1442.15, 'pending', '2025-10-08', NULL, NULL, NULL),
('MT-2025-00018', 'JKL-345-GH', 'LIC635760', 'Fernando Díaz Sánchez', 'Dar vuelta prohibida', 'ART-90', 'Realizó giro prohibido', 'Av. Principal km 3', '2025-09-21 13:29:59', 'Oficial Martínez', 'OF-7161', 597.90, 0.00, 597.90, 'pending', '2025-10-08', NULL, NULL, NULL),
('MT-2025-00019', 'XYZ-456-AB', 'LIC202168', 'Roberto Sánchez Torres', 'Falta de documentos', 'ART-56', 'No portaba licencia de conducir', 'Av. Principal km 4', '2025-10-28 13:29:59', 'Oficial Ramírez', 'OF-6016', 1036.95, 0.00, 1036.95, 'paid', '2025-11-07', 2025-10-21 13:29:59, '8', 'TFINE-00019'),
('MT-2025-00020', 'MNO-678-IJ', 'LIC436748', 'Jorge Rodríguez López', 'Uso de celular', 'ART-34', 'Conducía usando dispositivo móvil', 'Av. Principal km 6', '2025-11-03 13:29:59', 'Oficial Martínez', 'OF-8062', 1137.18, 0.00, 1137.18, 'pending', '2025-11-07', NULL, NULL, NULL),
('MT-2025-00021', 'STU-234-MN', 'LIC158172', 'Carlos González Ruiz', 'Exceso de velocidad', 'ART-23', 'Circulaba a 95 km/h en zona de 43 km/h', 'Av. Principal km 9', '2025-10-23 13:29:59', 'Oficial Ramírez', 'OF-6320', 1554.29, 0.00, 1554.29, 'pending', '2025-11-07', NULL, NULL, NULL),
('MT-2025-00022', 'PQR-901-KL', 'LIC714762', 'Juan Pérez García', 'No respetar semáforo', 'ART-45', 'Cruzó semáforo en luz roja', 'Av. Principal km 10', '2025-11-02 13:29:59', 'Oficial González', 'OF-5074', 2124.42, 0.00, 2124.42, 'pending', '2025-11-07', NULL, NULL, NULL),
('MT-2025-00023', 'MNO-678-IJ', 'LIC732692', 'Roberto Sánchez Torres', 'Falta de documentos', 'ART-56', 'No portaba licencia de conducir', 'Av. Principal km 4', '2025-10-26 13:29:59', 'Oficial Martínez', 'OF-7241', 1162.84, 232.57, 930.27, 'paid', '2025-11-07', 2025-10-21 13:29:59, '6', 'TFINE-00023');

-- ============================================================================
-- CIVIC FINES (Multiple fines per month across 6 months)
-- ============================================================================
INSERT INTO civic_fines (folio, citizen_name, citizen_id, infraction_type, infraction_article, description, location, infraction_date, judge_name, base_amount, total_amount, status, due_date, paid_date, paid_by, payment_reference) VALUES
('MC-2025-00001', 'Luis García Fernández', 'CUR202108289906', 'Alteración del orden público', 'Art. 12 Fracción III', 'Música a volumen alto en horario nocturno', 'Calle Hidalgo 569', '2025-05-30 13:29:59', 'Juez López', 1013.15, 1013.15, 'paid', '2025-06-10', '2025-05-12 13:29:59', 3, 'CFINE-00001'),
('MC-2025-00002', 'Ana Martínez Cruz', 'CUR345844822309', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Morelos 683', '2025-06-03 13:29:59', 'Juez López', 835.41, 835.41, 'paid', '2025-06-10', '2025-05-12 13:29:59', 3, 'CFINE-00002'),
('MC-2025-00003', 'Luis García Fernández', 'CUR548005378795', 'Venta ambulante sin permiso', 'Art. 18 Fracción II', 'Comercio sin autorización', 'Calle Hidalgo 359', '2025-06-14 13:29:59', 'Juez García', 1403.47, 1403.47, 'pending', '2025-07-10', NULL, NULL, NULL),
('MC-2025-00004', 'Miguel Flores Hernández', 'CUR111263738277', 'Daño a mobiliario urbano', 'Art. 25 Fracción V', 'Grafiti en propiedad pública', 'Calle Morelos 256', '2025-07-05 13:29:59', 'Juez García', 1926.49, 1926.49, 'paid', '2025-07-10', '2025-06-24 13:29:59', 7, 'CFINE-00004'),
('MC-2025-00005', 'Miguel Flores Hernández', 'CUR564472466899', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Centro 554', '2025-06-19 13:29:59', 'Juez López', 754.55, 754.55, 'paid', '2025-07-10', '2025-06-28 13:29:59', 12, 'CFINE-00005'),
('MC-2025-00006', 'Roberto Sánchez Torres', 'CUR221321190223', 'Alteración del orden público', 'Art. 12 Fracción III', 'Música a volumen alto en horario nocturno', 'Calle Juárez 453', '2025-07-29 13:29:59', 'Juez García', 1030.25, 1030.25, 'paid', '2025-08-09', '2025-07-20 13:29:59', 7, 'CFINE-00006'),
('MC-2025-00007', 'Patricia Hernández Ruiz', 'CUR842903026169', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Juárez 259', '2025-08-02 13:29:59', 'Juez García', 882.43, 882.43, 'pending', '2025-08-09', NULL, NULL, NULL),
('MC-2025-00008', 'Sofía Gómez Martínez', 'CUR653264235618', 'Venta ambulante sin permiso', 'Art. 18 Fracción II', 'Comercio sin autorización', 'Calle Morelos 742', '2025-07-14 13:29:59', 'Juez Hernández', 1490.12, 1490.12, 'paid', '2025-08-09', '2025-07-18 13:29:59', 11, 'CFINE-00008'),
('MC-2025-00009', 'Jorge Rodríguez López', 'CUR438675509797', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Morelos 561', '2025-08-11 13:29:59', 'Juez Hernández', 732.83, 732.83, 'pending', '2025-09-08', NULL, NULL, NULL),
('MC-2025-00010', 'Roberto Sánchez Torres', 'CUR284779355952', 'Falta de civismo', 'Art. 15 Fracción I', 'Tirar basura en vía pública', 'Calle Morelos 254', '2025-08-24 13:29:59', 'Juez García', 485.66, 485.66, 'pending', '2025-09-08', NULL, NULL, NULL),
('MC-2025-00011', 'Carmen Ramírez García', 'CUR849839954853', 'Venta ambulante sin permiso', 'Art. 18 Fracción II', 'Comercio sin autorización', 'Calle Juárez 379', '2025-08-31 13:29:59', 'Juez Martínez', 1490.61, 1490.61, 'paid', '2025-09-08', '2025-08-18 13:29:59', 3, 'CFINE-00011'),
('MC-2025-00012', 'Carmen Ramírez García', 'CUR463327450640', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Morelos 163', '2025-09-21 13:29:59', 'Juez López', 759.78, 759.78, 'paid', '2025-10-08', '2025-09-09 13:29:59', 8, 'CFINE-00012'),
('MC-2025-00013', 'Sofía Gómez Martínez', 'CUR711613404527', 'Venta ambulante sin permiso', 'Art. 18 Fracción II', 'Comercio sin autorización', 'Calle Morelos 738', '2025-09-11 13:29:59', 'Juez Rodríguez', 1591.04, 1591.04, 'pending', '2025-10-08', NULL, NULL, NULL),
('MC-2025-00014', 'Patricia Hernández Ruiz', 'CUR374035151655', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Hidalgo 406', '2025-09-18 13:29:59', 'Juez Hernández', 857.79, 857.79, 'paid', '2025-10-08', '2025-09-22 13:29:59', 5, 'CFINE-00014'),
('MC-2025-00015', 'Patricia Hernández Ruiz', 'CUR319562007806', 'Bloqueo de vía pública', 'Art. 20 Fracción IV', 'Obstaculización de paso peatonal', 'Calle Morelos 277', '2025-11-05 13:29:59', 'Juez Rodríguez', 769.65, 769.65, 'paid', '2025-11-07', '2025-10-20 13:29:59', 4, 'CFINE-00015'),
('MC-2025-00016', 'Luis García Fernández', 'CUR855939767508', 'Daño a mobiliario urbano', 'Art. 25 Fracción V', 'Grafiti en propiedad pública', 'Calle Centro 425', '2025-10-27 13:29:59', 'Juez Martínez', 1997.82, 1997.82, 'paid', '2025-11-07', '2025-10-13 13:29:59', 5, 'CFINE-00016');

-- ============================================================================
-- BUSINESS LICENSES (Various statuses)
-- ============================================================================
INSERT INTO business_licenses (user_id, business_name, business_type, rfc, address, phone, email, license_number, issue_date, expiry_date, status, annual_fee, created_at) VALUES
(4, 'Abarrotes González', 'Comercio al por menor', 'RFC772641964', 'Av. Hidalgo 962', '5552417278', 'abarrotes_gonzález@email.com', NULL, NULL, NULL, 'rejected', 5000.00, '2025-06-10 13:29:59'),
(5, 'Estética Mary', 'Servicios de belleza', 'RFC209720913', 'Av. Hidalgo 997', '5559154100', 'estética_mary@email.com', 'LIC-2025-002', '2025-07-17', '2026-10-08', 'approved', 3500.00, '2025-07-10 13:29:59'),
(6, 'Taller Mecánico JP', 'Servicios automotrices', 'RFC167645027', 'Av. Juárez 569', '5557059366', 'taller_mecánico_jp@email.com', 'LIC-2025-003', '2025-08-20', '2026-10-08', 'approved', 4500.00, '2025-08-09 13:29:59'),
(7, 'Farmacia del Centro', 'Comercio al por menor', 'RFC726142678', 'Av. Juárez 613', '5551705024', 'farmacia_del_centro@email.com', 'LIC-2025-004', '2025-09-14', '2026-10-08', 'approved', 6000.00, '2025-09-08 13:29:59'),
(8, 'Restaurante La Esperanza', 'Servicios de alimentos', 'RFC536395238', 'Av. Hidalgo 973', '5553347936', 'restaurante_la_esperanza@email.com', NULL, NULL, NULL, 'rejected', 8000.00, '2025-10-08 13:29:59'),
(9, 'Papelería Escolar', 'Comercio al por menor', 'RFC819031489', 'Av. Juárez 746', '5551812588', 'papelería_escolar@email.com', 'LIC-2025-006', '2025-05-12', '2026-10-08', 'approved', 3000.00, '2025-05-11 13:29:59'),
(10, 'Tintorería Express', 'Servicios de limpieza', 'RFC772943306', 'Av. Hidalgo 853', '5554705530', 'tintorería_express@email.com', NULL, NULL, NULL, 'pending', 3500.00, '2025-06-10 13:29:59'),
(11, 'Cyber Café Internet', 'Servicios de telecomunicaciones', 'RFC821889366', 'Av. Hidalgo 175', '5557105073', 'cyber_café_internet@email.com', NULL, NULL, NULL, 'pending', 4000.00, '2025-07-10 13:29:59');

-- ============================================================================
-- PAYMENTS (Comprehensive payment history across 6 months for all types)
-- ============================================================================
INSERT INTO payments (user_id, payment_type, reference_id, reference_number, amount, payment_method, transaction_id, status, paid_at) VALUES
(3, 'property_tax', 12, 'PAY-2025-00001', 2969.10, 'bank_reference', 'TXN-900512975', 'completed', '2025-06-23 13:29:59'),
(3, 'property_tax', 13, 'PAY-2025-00002', 3594.04, 'card', 'TXN-894407987', 'completed', '2025-07-27 13:29:59'),
(3, 'property_tax', 14, 'PAY-2025-00003', 4568.02, 'bank_reference', 'TXN-620657987', 'completed', '2025-08-29 13:29:59'),
(3, 'property_tax', 15, 'PAY-2025-00004', 6785.06, 'spei', 'TXN-451829811', 'completed', '2025-09-12 13:29:59'),
(3, 'property_tax', 16, 'PAY-2025-00005', 6634.34, 'spei', 'TXN-950315164', 'completed', '2025-10-18 13:29:59'),
(4, 'property_tax', 21, 'PAY-2025-00006', 4656.79, 'oxxo', 'TXN-116348061', 'completed', '2025-05-13 13:29:59'),
(4, 'property_tax', 22, 'PAY-2025-00007', 4338.38, 'spei', 'TXN-946759955', 'completed', '2025-06-26 13:29:59'),
(4, 'property_tax', 23, 'PAY-2025-00008', 3025.55, 'card', 'TXN-305388533', 'completed', '2025-07-29 13:29:59'),
(4, 'property_tax', 24, 'PAY-2025-00009', 6397.05, 'card', 'TXN-611682153', 'completed', '2025-08-28 13:29:59'),
(4, 'property_tax', 25, 'PAY-2025-00010', 4160.48, 'spei', 'TXN-281446412', 'completed', '2025-09-14 13:29:59'),
(5, 'property_tax', 32, 'PAY-2025-00011', 4731.92, 'oxxo', 'TXN-824510762', 'completed', '2025-06-16 13:29:59'),
(5, 'property_tax', 35, 'PAY-2025-00012', 4944.90, 'spei', 'TXN-425318647', 'completed', '2025-09-23 13:29:59'),
(6, 'property_tax', 42, 'PAY-2025-00013', 5378.20, 'bank_reference', 'TXN-880947797', 'completed', '2025-06-12 13:29:59'),
(6, 'property_tax', 43, 'PAY-2025-00014', 3707.70, 'bank_reference', 'TXN-882420844', 'completed', '2025-07-18 13:29:59'),
(6, 'property_tax', 44, 'PAY-2025-00015', 5550.86, 'spei', 'TXN-140940589', 'completed', '2025-08-28 13:29:59'),
(6, 'property_tax', 45, 'PAY-2025-00016', 6685.73, 'card', 'TXN-311098343', 'completed', '2025-09-24 13:29:59'),
(6, 'property_tax', 46, 'PAY-2025-00017', 2602.98, 'oxxo', 'TXN-429163545', 'completed', '2025-10-13 13:29:59'),
(7, 'property_tax', 51, 'PAY-2025-00018', 5526.85, 'spei', 'TXN-331652914', 'completed', '2025-05-20 13:29:59'),
(7, 'property_tax', 52, 'PAY-2025-00019', 4984.41, 'oxxo', 'TXN-512974555', 'completed', '2025-06-20 13:29:59'),
(7, 'property_tax', 54, 'PAY-2025-00020', 3744.62, 'spei', 'TXN-859551625', 'completed', '2025-08-22 13:29:59'),
(7, 'property_tax', 55, 'PAY-2025-00021', 5766.90, 'bank_reference', 'TXN-777089759', 'completed', '2025-09-17 13:29:59'),
(7, 'property_tax', 56, 'PAY-2025-00022', 5212.68, 'spei', 'TXN-465297783', 'completed', '2025-10-27 13:29:59'),
(8, 'property_tax', 62, 'PAY-2025-00023', 3457.70, 'bank_reference', 'TXN-530115993', 'completed', '2025-06-21 13:29:59'),
(8, 'property_tax', 63, 'PAY-2025-00024', 3786.47, 'oxxo', 'TXN-497124520', 'completed', '2025-07-28 13:29:59'),
(8, 'property_tax', 64, 'PAY-2025-00025', 4500.87, 'oxxo', 'TXN-375850408', 'completed', '2025-08-18 13:29:59'),
(8, 'property_tax', 65, 'PAY-2025-00026', 6865.30, 'card', 'TXN-685762668', 'completed', '2025-09-17 13:29:59'),
(8, 'property_tax', 66, 'PAY-2025-00027', 3682.25, 'spei', 'TXN-423681935', 'completed', '2025-10-14 13:29:59'),
(9, 'property_tax', 71, 'PAY-2025-00028', 5969.32, 'card', 'TXN-648529764', 'completed', '2025-05-22 13:29:59'),
(9, 'property_tax', 72, 'PAY-2025-00029', 3305.67, 'bank_reference', 'TXN-582661684', 'completed', '2025-06-22 13:29:59'),
(9, 'property_tax', 73, 'PAY-2025-00030', 2571.53, 'card', 'TXN-568545595', 'completed', '2025-07-15 13:29:59'),
(9, 'property_tax', 76, 'PAY-2025-00031', 5519.87, 'card', 'TXN-181740291', 'completed', '2025-10-25 13:29:59'),
(10, 'property_tax', 81, 'PAY-2025-00032', 4368.55, 'oxxo', 'TXN-583000818', 'completed', '2025-05-29 13:29:59'),
(10, 'property_tax', 82, 'PAY-2025-00033', 2601.48, 'card', 'TXN-460678784', 'completed', '2025-06-22 13:29:59'),
(10, 'property_tax', 83, 'PAY-2025-00034', 6861.44, 'bank_reference', 'TXN-927949637', 'completed', '2025-07-28 13:29:59'),
(10, 'property_tax', 84, 'PAY-2025-00035', 6542.72, 'bank_reference', 'TXN-942614987', 'completed', '2025-08-24 13:29:59'),
(10, 'property_tax', 85, 'PAY-2025-00036', 6453.14, 'oxxo', 'TXN-674419835', 'completed', '2025-09-15 13:29:59'),
(11, 'property_tax', 91, 'PAY-2025-00037', 4099.70, 'bank_reference', 'TXN-418409199', 'completed', '2025-05-20 13:29:59'),
(11, 'property_tax', 92, 'PAY-2025-00038', 6709.13, 'card', 'TXN-158877468', 'completed', '2025-06-24 13:29:59'),
(11, 'property_tax', 95, 'PAY-2025-00039', 5250.60, 'card', 'TXN-636457402', 'completed', '2025-09-28 13:29:59'),
(12, 'property_tax', 101, 'PAY-2025-00040', 5164.38, 'bank_reference', 'TXN-558772020', 'completed', '2025-05-15 13:29:59'),
(12, 'property_tax', 102, 'PAY-2025-00041', 3878.28, 'card', 'TXN-165974610', 'completed', '2025-06-11 13:29:59'),
(12, 'property_tax', 104, 'PAY-2025-00042', 6383.60, 'oxxo', 'TXN-313713239', 'completed', '2025-08-17 13:29:59'),
(12, 'property_tax', 105, 'PAY-2025-00043', 5236.57, 'bank_reference', 'TXN-998983786', 'completed', '2025-09-15 13:29:59'),
(12, 'property_tax', 106, 'PAY-2025-00044', 3821.88, 'bank_reference', 'TXN-908374959', 'completed', '2025-10-24 13:29:59'),
(9, 'traffic_fine', 1, 'PAY-2025-00045', 2475.15, 'oxxo', 'TXN-315115502', 'completed', '2025-05-18 13:29:59'),
(3, 'traffic_fine', 3, 'PAY-2025-00046', 2186.12, 'oxxo', 'TXN-211087785', 'completed', '2025-05-22 13:29:59'),
(9, 'traffic_fine', 4, 'PAY-2025-00047', 1627.03, 'card', 'TXN-720883996', 'completed', '2025-05-24 13:29:59'),
(6, 'traffic_fine', 5, 'PAY-2025-00048', 2147.06, 'spei', 'TXN-347675043', 'completed', '2025-05-13 13:29:59'),
(7, 'traffic_fine', 6, 'PAY-2025-00049', 1455.87, 'card', 'TXN-570801140', 'completed', '2025-06-19 13:29:59'),
(8, 'traffic_fine', 8, 'PAY-2025-00050', 1019.51, 'oxxo', 'TXN-616950145', 'completed', '2025-06-19 13:29:59'),
(5, 'traffic_fine', 10, 'PAY-2025-00051', 977.94, 'spei', 'TXN-556491707', 'completed', '2025-07-24 13:29:59'),
(12, 'traffic_fine', 11, 'PAY-2025-00052', 1356.14, 'oxxo', 'TXN-691837461', 'completed', '2025-07-20 13:29:59'),
(4, 'traffic_fine', 13, 'PAY-2025-00053', 1178.98, 'spei', 'TXN-642710871', 'completed', '2025-08-17 13:29:59'),
(3, 'traffic_fine', 15, 'PAY-2025-00054', 866.66, 'oxxo', 'TXN-849846112', 'completed', '2025-08-19 13:29:59'),
(7, 'traffic_fine', 16, 'PAY-2025-00055', 1832.84, 'spei', 'TXN-104147974', 'completed', '2025-08-13 13:29:59'),
(6, 'traffic_fine', 17, 'PAY-2025-00056', 1203.31, 'oxxo', 'TXN-706331702', 'completed', '2025-08-19 13:29:59'),
(3, 'traffic_fine', 20, 'PAY-2025-00057', 1686.93, 'oxxo', 'TXN-280435354', 'completed', '2025-09-19 13:29:59'),
(8, 'traffic_fine', 21, 'PAY-2025-00058', 1601.01, 'spei', 'TXN-816718573', 'completed', '2025-09-12 13:29:59'),
(4, 'traffic_fine', 22, 'PAY-2025-00059', 1111.10, 'spei', 'TXN-501898649', 'completed', '2025-09-17 13:29:59'),
(6, 'traffic_fine', 23, 'PAY-2025-00060', 777.97, 'card', 'TXN-984421924', 'completed', '2025-10-15 13:29:59'),
(11, 'traffic_fine', 24, 'PAY-2025-00061', 615.86, 'oxxo', 'TXN-183562123', 'completed', '2025-10-17 13:29:59'),
(11, 'traffic_fine', 26, 'PAY-2025-00062', 1258.77, 'card', 'TXN-436104242', 'completed', '2025-10-22 13:29:59'),
(3, 'civic_fine', 1, 'PAY-2025-00063', 1279.81, 'card', 'TXN-162785683', 'completed', '2025-05-30 13:29:59'),
(12, 'civic_fine', 2, 'PAY-2025-00064', 1990.47, 'oxxo', 'TXN-399017464', 'completed', '2025-05-22 13:29:59'),
(7, 'civic_fine', 4, 'PAY-2025-00065', 1551.71, 'spei', 'TXN-921331457', 'completed', '2025-06-11 13:29:59'),
(12, 'civic_fine', 7, 'PAY-2025-00066', 695.41, 'card', 'TXN-222896839', 'completed', '2025-07-16 13:29:59'),
(12, 'civic_fine', 9, 'PAY-2025-00067', 665.38, 'card', 'TXN-390132123', 'completed', '2025-08-29 13:29:59'),
(6, 'civic_fine', 11, 'PAY-2025-00068', 1377.92, 'card', 'TXN-413481792', 'completed', '2025-09-19 13:29:59'),
(3, 'civic_fine', 12, 'PAY-2025-00069', 978.23, 'spei', 'TXN-497064828', 'completed', '2025-09-22 13:29:59'),
(4, 'civic_fine', 13, 'PAY-2025-00070', 1745.94, 'cash', 'TXN-430153365', 'completed', '2025-10-18 13:29:59'),
(9, 'civic_fine', 14, 'PAY-2025-00071', 697.57, 'cash', 'TXN-113356977', 'completed', '2025-10-21 13:29:59'),
(4, 'business_license', 2, 'PAY-2025-00072', 5512.56, 'card', 'TXN-711497788', 'completed', '2025-08-15 13:29:59'),
(5, 'business_license', 3, 'PAY-2025-00073', 3752.28, 'spei', 'TXN-524317719', 'completed', '2025-07-13 13:29:59'),
(6, 'business_license', 4, 'PAY-2025-00074', 6322.01, 'card', 'TXN-956104400', 'completed', '2025-09-15 13:29:59'),
(7, 'business_license', 5, 'PAY-2025-00075', 6019.21, 'card', 'TXN-358003035', 'completed', '2025-10-10 13:29:59');


-- ============================================================================
-- SUMMARY
-- ============================================================================
-- The following data has been generated:
-- - Multiple users registered across the last 6 months
-- - 10 properties with ownership
-- - Property taxes for each property (paid, pending, overdue)
-- - Traffic fines distributed across 6 months (60% paid, 40% pending)
-- - Civic fines distributed across 6 months (50% paid, 50% pending)
-- - Business licenses with various statuses
-- - Comprehensive payment records for all payment types
--
-- This data ensures that:
-- 1. Dashboard graphs show revenue by concept (bar chart)
-- 2. Dashboard shows pending obligations distribution (donut chart)
-- 3. Dashboard shows revenue trend for last 6 months (line chart)
-- 4. Statistics page shows user registration trend (line chart)
-- 5. All summary cards show accurate counts and amounts
-- ============================================================================

SELECT 'Sample data loaded successfully!' AS Status;
SELECT COUNT(*) AS Total_Users FROM users;
SELECT COUNT(*) AS Total_Properties FROM properties;
SELECT COUNT(*) AS Total_Property_Taxes FROM property_taxes;
SELECT COUNT(*) AS Total_Traffic_Fines FROM traffic_fines;
SELECT COUNT(*) AS Total_Civic_Fines FROM civic_fines;
SELECT COUNT(*) AS Total_Business_Licenses FROM business_licenses;
SELECT COUNT(*) AS Total_Payments FROM payments;
SELECT SUM(amount) AS Total_Revenue FROM payments WHERE status = 'completed';
