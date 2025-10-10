<?php
// Script para crear usuario admin si no existe
require_once 'config/config.php';
require_once 'config/database.php';

try {
    $database = Database::getInstance();
    $pdo = $database->getConnection();
    echo "Conexión a base de datos exitosa\n";
    
    // Verificar si existe un usuario admin
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE role = 'admin'");
    $stmt->execute();
    $admins = $stmt->fetchAll();
    
    if (count($admins) > 0) {
        echo "Usuarios admin existentes:\n";
        foreach ($admins as $admin) {
            echo "- ID: {$admin['id']}, Email: {$admin['email']}, Nombre: {$admin['name']}\n";
        }
    } else {
        echo "No se encontraron usuarios admin. Creando uno...\n";
        
        // Crear usuario admin por defecto
        $adminEmail = 'admin@recaudabot.com';
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $adminName = 'Administrador';
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, 'admin', NOW())");
        $result = $stmt->execute([$adminName, $adminEmail, $adminPassword]);
        
        if ($result) {
            echo "✓ Usuario admin creado exitosamente\n";
            echo "Email: {$adminEmail}\n";
            echo "Password: admin123\n";
        } else {
            echo "✗ Error al crear usuario admin\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>