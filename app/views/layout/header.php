<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'RecaudaBot'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/style.css">
    
    <!-- Dynamic Theme Colors -->
    <?php
    // Load theme colors from database
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT setting_key, setting_value FROM system_settings WHERE setting_key LIKE 'theme_%'");
    $stmt->execute();
    $themeSettings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    // Default colors if not set
    $themeColors = [
        'theme_primary_color' => $themeSettings['theme_primary_color'] ?? '#0d6efd',
        'theme_secondary_color' => $themeSettings['theme_secondary_color'] ?? '#6c757d',
        'theme_success_color' => $themeSettings['theme_success_color'] ?? '#198754',
        'theme_danger_color' => $themeSettings['theme_danger_color'] ?? '#dc3545',
        'theme_warning_color' => $themeSettings['theme_warning_color'] ?? '#ffc107',
        'theme_info_color' => $themeSettings['theme_info_color'] ?? '#0dcaf0',
        'theme_light_color' => $themeSettings['theme_light_color'] ?? '#f8f9fa',
        'theme_dark_color' => $themeSettings['theme_dark_color'] ?? '#212529',
        'theme_chatbot_bg_color' => $themeSettings['theme_chatbot_bg_color'] ?? '#0d6efd',
        'theme_chatbot_text_color' => $themeSettings['theme_chatbot_text_color'] ?? '#ffffff',
        'theme_chatbot_user_bg_color' => $themeSettings['theme_chatbot_user_bg_color'] ?? '#e9ecef',
        'theme_chatbot_user_text_color' => $themeSettings['theme_chatbot_user_text_color'] ?? '#212529'
    ];
    ?>
    <style>
        :root {
            --bs-primary: <?php echo $themeColors['theme_primary_color']; ?>;
            --bs-secondary: <?php echo $themeColors['theme_secondary_color']; ?>;
            --bs-success: <?php echo $themeColors['theme_success_color']; ?>;
            --bs-danger: <?php echo $themeColors['theme_danger_color']; ?>;
            --bs-warning: <?php echo $themeColors['theme_warning_color']; ?>;
            --bs-info: <?php echo $themeColors['theme_info_color']; ?>;
            --bs-light: <?php echo $themeColors['theme_light_color']; ?>;
            --bs-dark: <?php echo $themeColors['theme_dark_color']; ?>;
            
            --bs-primary-rgb: <?php echo implode(', ', sscanf($themeColors['theme_primary_color'], "#%02x%02x%02x")); ?>;
            --bs-secondary-rgb: <?php echo implode(', ', sscanf($themeColors['theme_secondary_color'], "#%02x%02x%02x")); ?>;
            --bs-success-rgb: <?php echo implode(', ', sscanf($themeColors['theme_success_color'], "#%02x%02x%02x")); ?>;
            --bs-danger-rgb: <?php echo implode(', ', sscanf($themeColors['theme_danger_color'], "#%02x%02x%02x")); ?>;
            --bs-warning-rgb: <?php echo implode(', ', sscanf($themeColors['theme_warning_color'], "#%02x%02x%02x")); ?>;
            --bs-info-rgb: <?php echo implode(', ', sscanf($themeColors['theme_info_color'], "#%02x%02x%02x")); ?>;
            
            --chatbot-bg-color: <?php echo $themeColors['theme_chatbot_bg_color']; ?>;
            --chatbot-text-color: <?php echo $themeColors['theme_chatbot_text_color']; ?>;
            --chatbot-user-bg-color: <?php echo $themeColors['theme_chatbot_user_bg_color']; ?>;
            --chatbot-user-text-color: <?php echo $themeColors['theme_chatbot_user_text_color']; ?>;
        }
        
        /* Apply theme colors to Bootstrap components */
        .bg-primary { background-color: var(--bs-primary) !important; }
        .text-primary { color: var(--bs-primary) !important; }
        .btn-primary { background-color: var(--bs-primary); border-color: var(--bs-primary); }
        .btn-primary:hover { background-color: var(--bs-primary); opacity: 0.9; }
        .navbar-dark.bg-primary { background-color: var(--bs-primary) !important; }
        
        .bg-secondary { background-color: var(--bs-secondary) !important; }
        .text-secondary { color: var(--bs-secondary) !important; }
        .btn-secondary { background-color: var(--bs-secondary); border-color: var(--bs-secondary); }
        
        .bg-success { background-color: var(--bs-success) !important; }
        .text-success { color: var(--bs-success) !important; }
        .btn-success { background-color: var(--bs-success); border-color: var(--bs-success); }
        
        .bg-danger { background-color: var(--bs-danger) !important; }
        .text-danger { color: var(--bs-danger) !important; }
        .btn-danger { background-color: var(--bs-danger); border-color: var(--bs-danger); }
        
        .bg-warning { background-color: var(--bs-warning) !important; }
        .text-warning { color: var(--bs-warning) !important; }
        .btn-warning { background-color: var(--bs-warning); border-color: var(--bs-warning); }
        
        .bg-info { background-color: var(--bs-info) !important; }
        .text-info { color: var(--bs-info) !important; }
        .btn-info { background-color: var(--bs-info); border-color: var(--bs-info); }
        
        /* Chatbot theming */
        .chatbot-container { background-color: var(--chatbot-bg-color); color: var(--chatbot-text-color); }
        .chatbot-header { background-color: var(--chatbot-bg-color); color: var(--chatbot-text-color); }
        .chatbot-message.bot { background-color: var(--chatbot-bg-color); color: var(--chatbot-text-color); }
        .chatbot-message.user { background-color: var(--chatbot-user-bg-color); color: var(--chatbot-user-text-color); }
        
        /* Badge colors */
        .badge.bg-primary { background-color: var(--bs-primary) !important; }
        .badge.bg-secondary { background-color: var(--bs-secondary) !important; }
        .badge.bg-success { background-color: var(--bs-success) !important; }
        .badge.bg-danger { background-color: var(--bs-danger) !important; }
        .badge.bg-warning { background-color: var(--bs-warning) !important; }
        .badge.bg-info { background-color: var(--bs-info) !important; }
        
        /* Card header colors */
        .card-header.bg-primary { background-color: var(--bs-primary) !important; }
        .card-header.bg-secondary { background-color: var(--bs-secondary) !important; }
        .card-header.bg-success { background-color: var(--bs-success) !important; }
        .card-header.bg-danger { background-color: var(--bs-danger) !important; }
        .card-header.bg-warning { background-color: var(--bs-warning) !important; }
        .card-header.bg-info { background-color: var(--bs-info) !important; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="bi bi-building"></i> RecaudaBot
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/impuesto-predial">
                            <i class="bi bi-house"></i> Impuesto Predial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/licencias">
                            <i class="bi bi-briefcase"></i> Licencias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/multas-transito">
                            <i class="bi bi-car-front"></i> Multas Tránsito
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/multas-civicas">
                            <i class="bi bi-exclamation-triangle"></i> Multas Cívicas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/orientacion">
                            <i class="bi bi-question-circle"></i> Orientación
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'municipal_area')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/admin">
                                <i class="bi bi-speedometer2"></i> Admin
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/comprobantes">
                                <i class="bi bi-receipt"></i> Comprobantes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/citas">
                                <i class="bi bi-calendar"></i> Citas
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/perfil">Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo PUBLIC_URL; ?>/logout_direct.php" style="margin: 0;">
                                        <button type="submit" class="dropdown-item border-0 bg-transparent w-100 text-start" style="cursor: pointer;">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/login">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/register">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="container my-4">
