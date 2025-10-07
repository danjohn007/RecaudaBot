-- ============================================
-- SQL para Actualización de Campo civic_fines
-- ============================================
-- 
-- PROBLEMA REPORTADO:
-- "El campo Infractor en Multas Cívicas Encontradas muestra este error ya que no existe el campo en la tabla"
-- Warning: Undefined array key "infractor_name"
-- 
-- ANÁLISIS:
-- La tabla civic_fines NO tiene un campo llamado "infractor_name"
-- La tabla civic_fines SÍ tiene un campo llamado "citizen_name" que cumple la misma función
-- 
-- SOLUCIÓN IMPLEMENTADA:
-- Se actualizaron las vistas PHP para usar el nombre de campo correcto: "citizen_name"
-- NO se requiere modificar la base de datos
-- 
-- ============================================

-- OPCIÓN 1: NO HACER NADA (RECOMENDADO) ✓
-- Las vistas PHP ya fueron actualizadas para usar citizen_name
-- Esta es la solución más limpia y evita redundancia de datos

-- ============================================
-- OPCIÓN 2: Agregar columna infractor_name como alias (NO RECOMENDADO)
-- ============================================
-- Solo ejecutar si realmente se necesita mantener compatibilidad con código legacy
-- que espera el campo "infractor_name"

-- Descomenta las siguientes líneas SOLO si es absolutamente necesario:

/*
-- Agregar la columna infractor_name
ALTER TABLE civic_fines 
ADD COLUMN infractor_name VARCHAR(200) AFTER citizen_name
COMMENT 'Alias de citizen_name para compatibilidad';

-- Copiar datos existentes de citizen_name a infractor_name
UPDATE civic_fines 
SET infractor_name = citizen_name 
WHERE infractor_name IS NULL;

-- Crear trigger para mantener sincronizados ambos campos
DELIMITER //

CREATE TRIGGER civic_fines_sync_names_insert
BEFORE INSERT ON civic_fines
FOR EACH ROW
BEGIN
    IF NEW.infractor_name IS NULL THEN
        SET NEW.infractor_name = NEW.citizen_name;
    END IF;
    IF NEW.citizen_name IS NULL THEN
        SET NEW.citizen_name = NEW.infractor_name;
    END IF;
END//

CREATE TRIGGER civic_fines_sync_names_update
BEFORE UPDATE ON civic_fines
FOR EACH ROW
BEGIN
    IF NEW.infractor_name IS NULL THEN
        SET NEW.infractor_name = NEW.citizen_name;
    END IF;
    IF NEW.citizen_name IS NULL THEN
        SET NEW.citizen_name = NEW.infractor_name;
    END IF;
END//

DELIMITER ;
*/

-- ============================================
-- OPCIÓN 3: Crear vista con alias (ALTERNATIVA LIMPIA)
-- ============================================
-- Esta opción crea una vista que expone ambos nombres de campo
-- sin duplicar datos en la tabla

/*
CREATE OR REPLACE VIEW vw_civic_fines AS
SELECT 
    id,
    folio,
    citizen_name,
    citizen_name AS infractor_name,  -- Alias para compatibilidad
    citizen_id,
    citizen_id AS curp,              -- Alias para compatibilidad
    infraction_type,
    infraction_article,
    description,
    location,
    infraction_date,
    judge_name,
    base_amount,
    total_amount,
    status,
    due_date,
    paid_date,
    paid_by,
    payment_reference,
    created_at,
    updated_at
FROM civic_fines;

-- Luego modificar las consultas en PHP para usar vw_civic_fines en lugar de civic_fines
*/

-- ============================================
-- VERIFICACIÓN
-- ============================================
-- Ejecuta estas consultas para verificar la estructura actual:

-- Ver estructura de la tabla
SHOW COLUMNS FROM civic_fines;

-- Ver datos de ejemplo
SELECT id, folio, citizen_name, citizen_id, infraction_type, status 
FROM civic_fines 
LIMIT 5;

-- ============================================
-- ÍNDICES ADICIONALES PARA RENDIMIENTO
-- ============================================
-- Estos índices mejoran el rendimiento de búsquedas
-- (Ya deben existir según migration_updates.sql)

-- Verifica si existe el índice en folio
SHOW INDEX FROM civic_fines WHERE Key_name = 'idx_folio';

-- Si no existe, créalo:
-- ALTER TABLE civic_fines ADD INDEX idx_folio (folio);

-- Índice en citizen_name para búsquedas
SHOW INDEX FROM civic_fines WHERE Key_name = 'idx_citizen_name';

-- Si no existe, créalo:
-- ALTER TABLE civic_fines ADD INDEX idx_citizen_name (citizen_name);

-- ============================================
-- RECOMENDACIÓN FINAL
-- ============================================
-- NO ejecutar ninguna SQL adicional
-- La solución correcta ya está implementada en el código PHP
-- La tabla está correctamente estructurada con los campos:
-- - citizen_name (nombre del infractor)
-- - citizen_id (identificación del infractor, equivalente a CURP)
