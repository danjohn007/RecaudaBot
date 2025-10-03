-- Sample Data for RecaudaBot
USE recaudabot;

-- Sample Users (password: password123 for all)
INSERT INTO users (username, email, password, full_name, phone, curp, rfc, address, role) VALUES
('admin', 'admin@municipio.gob.mx', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Administrador Municipal', '5551234567', 'AAAA800101HDFRRL01', 'AAAA800101A01', 'Palacio Municipal, Centro', 'admin'),
('jperez', 'jperez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Juan Pérez García', '5559876543', 'PEGJ850215HDFRXN02', 'PEGJ850215ABC', 'Av. Reforma 123, Col. Centro', 'citizen'),
('mlopez', 'mlopez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'María López Hernández', '5558765432', 'LOHM900320MDFRPR08', 'LOHM900320XYZ', 'Calle Hidalgo 456, Col. Juárez', 'citizen'),
('tesoreria', 'tesoreria@municipio.gob.mx', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Departamento de Tesorería', '5551112222', 'TESM800101HDFRRL01', 'TESM800101T01', 'Palacio Municipal, Planta Baja', 'municipal_area'),
('cgonzalez', 'cgonzalez@email.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5lsV7VHRu.HL.', 'Carlos González Ruiz', '5557654321', 'GORC880512HDFRRL09', 'GORC880512DEF', 'Av. Juárez 789, Col. Morelos', 'citizen');

-- Sample Properties
INSERT INTO properties (cadastral_key, owner_id, owner_name, address, area_m2, construction_m2, cadastral_value, zone_type) VALUES
('CAT-2024-001-0123', 2, 'Juan Pérez García', 'Av. Reforma 123, Col. Centro', 250.00, 180.00, 1500000.00, 'residential'),
('CAT-2024-002-0456', 3, 'María López Hernández', 'Calle Hidalgo 456, Col. Juárez', 180.00, 120.00, 1200000.00, 'residential'),
('CAT-2024-003-0789', 5, 'Carlos González Ruiz', 'Av. Juárez 789, Col. Morelos', 300.00, 250.00, 2500000.00, 'commercial'),
('CAT-2024-004-0321', NULL, 'Roberto Martínez Silva', 'Calle Morelos 321, Col. Centro', 200.00, 150.00, 1800000.00, 'residential');

-- Sample Property Taxes
INSERT INTO property_taxes (property_id, year, period, base_amount, discount_amount, interest_amount, total_amount, due_date, status) VALUES
(1, 2024, 'Q1', 3750.00, 375.00, 0.00, 3375.00, '2024-03-31', 'paid'),
(1, 2024, 'Q2', 3750.00, 0.00, 0.00, 3750.00, '2024-06-30', 'pending'),
(2, 2024, 'Q1', 3000.00, 0.00, 150.00, 3150.00, '2024-03-31', 'overdue'),
(2, 2024, 'Q2', 3000.00, 0.00, 0.00, 3000.00, '2024-06-30', 'pending'),
(3, 2024, 'Q1', 6250.00, 625.00, 0.00, 5625.00, '2024-03-31', 'paid'),
(3, 2024, 'Q2', 6250.00, 0.00, 0.00, 6250.00, '2024-06-30', 'pending'),
(4, 2023, 'annual', 18000.00, 0.00, 2700.00, 20700.00, '2023-12-31', 'overdue');

-- Sample Business Licenses
INSERT INTO business_licenses (user_id, business_name, business_type, rfc, address, phone, email, license_number, issue_date, expiry_date, status, annual_fee) VALUES
(5, 'Abarrotes González', 'Comercio al por menor', 'GORC880512DEF', 'Av. Juárez 789, Col. Morelos', '5557654321', 'abarrotes@email.com', 'LIC-2024-001', '2024-01-15', '2025-01-14', 'approved', 5000.00),
(3, 'Estética Mary', 'Servicios de belleza', 'LOHM900320XYZ', 'Calle Hidalgo 456, Col. Juárez', '5558765432', 'estetica@email.com', 'LIC-2024-002', '2024-02-01', '2025-01-31', 'approved', 3500.00),
(2, 'Taller Mecánico JP', 'Servicios automotrices', 'PEGJ850215ABC', 'Av. Reforma 123, Col. Centro', '5559876543', NULL, NULL, NULL, NULL, 'pending', 4500.00);

-- Sample Traffic Fines
INSERT INTO traffic_fines (folio, license_plate, driver_license, driver_name, infraction_type, infraction_code, description, location, infraction_date, officer_name, officer_badge, base_amount, discount_amount, total_amount, status, due_date, has_evidence) VALUES
('MT-2024-00001', 'ABC-123-XY', 'LIC123456', 'Juan Pérez García', 'Exceso de velocidad', 'ART-23', 'Circulaba a 90 km/h en zona de 50 km/h', 'Av. Principal km 5', '2024-05-10 14:30:00', 'Oficial Ramírez', 'OF-1234', 1500.00, 300.00, 1200.00, 'pending', '2024-06-10', 1),
('MT-2024-00002', 'XYZ-456-AB', 'LIC789012', 'María López Hernández', 'No respetar semáforo', 'ART-45', 'Cruzó semáforo en luz roja', 'Av. Juárez esq. Hidalgo', '2024-05-15 08:15:00', 'Oficial González', 'OF-5678', 2000.00, 0.00, 2000.00, 'pending', '2024-06-15', 1),
('MT-2024-00003', 'DEF-789-CD', 'LIC345678', 'Carlos González Ruiz', 'Estacionamiento prohibido', 'ART-67', 'Vehículo estacionado en zona prohibida', 'Calle Centro 234', '2024-05-20 16:45:00', 'Oficial Martínez', 'OF-9012', 800.00, 160.00, 640.00, 'paid', '2024-06-20', 0);

-- Sample Civic Fines
INSERT INTO civic_fines (folio, citizen_name, citizen_id, infraction_type, infraction_article, description, location, infraction_date, judge_name, base_amount, total_amount, status, due_date) VALUES
('MC-2024-00001', 'Roberto Sánchez Torres', 'SATRO850610HDFRRT05', 'Alteración del orden público', 'Art. 12 Fracción III', 'Música a volumen alto en horario nocturno', 'Calle Morelos 567', '2024-05-12 23:30:00', 'Juez Rodríguez', 1000.00, 1000.00, 'pending', '2024-06-12'),
('MC-2024-00002', 'Ana Martínez Cruz', 'MACA920315MDFRRT03', 'Falta de civismo', 'Art. 15 Fracción I', 'Tirar basura en vía pública', 'Parque Central', '2024-05-18 10:20:00', 'Juez García', 500.00, 500.00, 'pending', '2024-06-18');

-- Sample Payments
INSERT INTO payments (user_id, payment_type, reference_id, reference_number, amount, payment_method, transaction_id, status, paid_at) VALUES
(2, 'property_tax', 1, 'PAY-2024-00001', 3375.00, 'card', 'TXN-123456789', 'completed', '2024-03-25 10:30:00'),
(5, 'property_tax', 5, 'PAY-2024-00002', 5625.00, 'spei', 'SPEI-987654321', 'completed', '2024-03-28 15:45:00'),
(5, 'traffic_fine', 3, 'PAY-2024-00003', 640.00, 'oxxo', 'OXXO-456789123', 'completed', '2024-05-22 09:15:00');

-- Sample Receipts
INSERT INTO receipts (payment_id, receipt_number, uuid, receipt_type, issued_at) VALUES
(1, 'REC-2024-00001', 'a1b2c3d4-e5f6-4a5b-8c9d-0e1f2a3b4c5d', 'standard', '2024-03-25 10:31:00'),
(2, 'REC-2024-00002', 'b2c3d4e5-f6a7-5b6c-9d0e-1f2a3b4c5d6e', 'standard', '2024-03-28 15:46:00'),
(3, 'REC-2024-00003', 'c3d4e5f6-a7b8-6c7d-0e1f-2a3b4c5d6e7f', 'standard', '2024-05-22 09:16:00');

-- Sample Appointments
INSERT INTO appointments (user_id, service_type, appointment_date, appointment_time, duration_minutes, location, notes, status) VALUES
(2, 'Licencia de Funcionamiento - Nuevo', '2024-06-05', '10:00:00', 60, 'Ventanilla de Trámites', 'Llevar documentación completa', 'scheduled'),
(3, 'Revisión de Predial', '2024-06-08', '11:00:00', 30, 'Departamento de Catastro', 'Consulta sobre avalúo', 'scheduled'),
(5, 'Renovación de Licencia', '2024-06-10', '09:30:00', 45, 'Ventanilla de Trámites', 'Renovación anual', 'confirmed');

-- Sample Notifications
INSERT INTO notifications (user_id, type, title, message, reference_type, reference_id, status) VALUES
(2, 'email', 'Pago Exitoso', 'Su pago de impuesto predial ha sido procesado exitosamente.', 'payment', 1, 'sent'),
(3, 'email', 'Recordatorio de Vencimiento', 'Su impuesto predial Q1-2024 está vencido. Por favor, realice el pago a la brevedad.', 'property_tax', 3, 'sent'),
(2, 'push', 'Cita Programada', 'Tiene una cita programada para el 05/06/2024 a las 10:00 hrs.', 'appointment', 1, 'read'),
(5, 'email', 'Multa de Tránsito', 'Se ha registrado una nueva multa de tránsito a su nombre.', 'traffic_fine', 1, 'pending');

-- Sample System Settings
INSERT INTO system_settings (setting_key, setting_value, description) VALUES
('property_tax_rate', '0.0025', 'Tasa de impuesto predial (0.25%)'),
('early_payment_discount', '10', 'Descuento por pago anticipado (%)'),
('late_payment_interest', '5', 'Interés moratorio mensual (%)'),
('traffic_fine_discount_days', '15', 'Días para descuento en multas de tránsito'),
('traffic_fine_discount_rate', '20', 'Descuento por pronto pago en multas (%)'),
('appointment_duration', '30', 'Duración predeterminada de citas (minutos)'),
('max_appointments_per_day', '20', 'Máximo de citas por día'),
('business_hours_start', '08:00', 'Horario de inicio de atención'),
('business_hours_end', '16:00', 'Horario de fin de atención');

-- Sample Help Guides
INSERT INTO help_guides (category, title, content, order_index) VALUES
('property_tax', 'Cómo consultar mi deuda predial', 'Para consultar su deuda predial, ingrese a la sección de Impuesto Predial y proporcione su clave catastral o datos del propietario. El sistema mostrará todos los adeudos pendientes y vencidos.', 1),
('property_tax', 'Formas de pago del impuesto predial', 'Puede pagar su impuesto predial de las siguientes formas: 1) Pago en línea con tarjeta, 2) Transferencia SPEI, 3) Pago en tiendas OXXO, 4) Ventanilla bancaria con referencia.', 2),
('licenses', 'Requisitos para licencia de funcionamiento', 'Documentos necesarios: 1) Identificación oficial, 2) Comprobante de domicilio, 3) RFC, 4) Planos del local, 5) Uso de suelo, 6) Pago de derechos.', 1),
('traffic_fines', 'Cómo impugnar una multa de tránsito', 'Si considera que la multa es injusta, puede impugnarla en línea proporcionando evidencias y argumentos. El proceso será revisado por las autoridades correspondientes.', 1);

-- Sample FAQs
INSERT INTO faq (category, question, answer, order_index) VALUES
('general', '¿Cómo puedo registrarme en el sistema?', 'Haga clic en "Registrarse" en la página principal y complete el formulario con sus datos personales. Recibirá un correo de confirmación.', 1),
('general', '¿Qué hago si olvidé mi contraseña?', 'En la página de inicio de sesión, haga clic en "Olvidé mi contraseña" e ingrese su correo electrónico. Recibirá instrucciones para restablecerla.', 2),
('property_tax', '¿Cuándo vence el impuesto predial?', 'El impuesto predial se paga trimestralmente. Los vencimientos son: Q1 (31 marzo), Q2 (30 junio), Q3 (30 septiembre), Q4 (31 diciembre).', 1),
('property_tax', '¿Existe descuento por pronto pago?', 'Sí, existe un descuento del 10% si realiza el pago durante el primer mes del trimestre correspondiente.', 2),
('licenses', '¿Cuánto tarda el trámite de una licencia nueva?', 'El trámite de una licencia de funcionamiento nueva tarda aproximadamente 15 días hábiles una vez completada la documentación.', 1),
('traffic_fines', '¿Cómo puedo pagar una multa de tránsito?', 'Puede pagar en línea con tarjeta, transferencia bancaria, en tiendas OXXO o en ventanillas del departamento de tránsito.', 1),
('traffic_fines', '¿Hay descuento por pagar rápido?', 'Sí, existe un descuento del 20% si paga dentro de los primeros 15 días de emitida la infracción.', 2);

-- Sample Audit Log
INSERT INTO audit_log (user_id, action, entity_type, entity_id, ip_address, user_agent) VALUES
(2, 'login', 'user', 2, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'),
(2, 'payment_created', 'payment', 1, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'),
(1, 'user_created', 'user', 5, '192.168.1.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'),
(5, 'license_submitted', 'business_license', 1, '192.168.1.120', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)');
