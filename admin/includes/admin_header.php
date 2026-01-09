<?php
/**
 * Admin Header
 * NFT-Verse Dynamic Website
 * 
 * NOTE: session.php and functions.php should be included by the calling page
 * BEFORE this header is included, to allow redirects to work properly.
 */

// Check if session is already included, if not include it
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/functions.php';
}

// Require admin access
requireAdmin();

$admin_path = '/nft/admin/';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Admin' : 'Admin Panel'; ?> | NFT-Verse</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #00f5ff;
            --secondary-color: #667eea;
            --dark-bg: #0a0a1a;
            --darker-bg: #050510;
            --card-bg: rgba(20, 20, 40, 0.9);
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--darker-bg);
            color: #fff;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark-bg);
            border-right: 1px solid rgba(0, 245, 255, 0.1);
            padding: 1.5rem;
            overflow-y: auto;
            z-index: 1000;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 245, 255, 0.1);
        }

        .admin-logo i {
            font-size: 1.8rem;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
        }

        .admin-nav {
            list-style: none;
        }

        .admin-nav-item {
            margin-bottom: 0.25rem;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .admin-nav-link:hover {
            background: rgba(0, 245, 255, 0.1);
            color: var(--primary-color);
        }

        .admin-nav-link.active {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: #fff;
        }

        .admin-nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Bar */
        .admin-topbar {
            background: var(--dark-bg);
            border-bottom: 1px solid rgba(0, 245, 255, 0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(0, 245, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
            background: rgba(0, 245, 255, 0.2);
            color: var(--primary-color);
        }

        /* Content Area */
        .admin-content {
            padding: 2rem;
        }

        /* Cards */
        .admin-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 245, 255, 0.1);
        }

        .admin-card-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Stats Cards */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            padding: 1rem;
            background: rgba(0, 245, 255, 0.05);
            border-bottom: 1px solid rgba(0, 245, 255, 0.1);
            font-weight: 600;
            color: var(--primary-color);
        }

        .admin-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 245, 255, 0.05);
            color: rgba(255, 255, 255, 0.8);
        }

        .admin-table tr:hover td {
            background: rgba(0, 245, 255, 0.02);
        }

        /* Forms */
        .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(0, 0, 0, 0.4);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 245, 255, 0.1);
            color: #fff;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-primary {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--dark-bg);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        /* Badge */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .badge-info {
            background: rgba(0, 245, 255, 0.2);
            color: var(--primary-color);
        }

        .badge-secondary {
            background: rgba(107, 114, 128, 0.2);
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="/nft/index.php" class="admin-logo">
            <i class="fas fa-gem"></i>
            <span>NFT-Verse</span>
        </a>

        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="<?php echo $admin_path; ?>index.php"
                        class="admin-nav-link <?php echo ($admin_page ?? '') === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Kelola Konten</div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="<?php echo $admin_path; ?>nfts.php"
                        class="admin-nav-link <?php echo ($admin_page ?? '') === 'nfts' ? 'active' : ''; ?>">
                        <i class="fas fa-images"></i>
                        <span>Koleksi NFT</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="<?php echo $admin_path; ?>team.php"
                        class="admin-nav-link <?php echo ($admin_page ?? '') === 'team' ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span>Tim</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="<?php echo $admin_path; ?>roadmap.php"
                        class="admin-nav-link <?php echo ($admin_page ?? '') === 'roadmap' ? 'active' : ''; ?>">
                        <i class="fas fa-road"></i>
                        <span>Roadmap</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Sistem</div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="<?php echo $admin_path; ?>users.php"
                        class="admin-nav-link <?php echo ($admin_page ?? '') === 'users' ? 'active' : ''; ?>">
                        <i class="fas fa-user-cog"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="<?php echo $admin_path; ?>settings.php"
                        class="admin-nav-link <?php echo ($admin_page ?? '') === 'settings' ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section"
            style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(0, 245, 255, 0.1);">
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="/nft/index.php" class="admin-nav-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Lihat Website</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="/nft/auth/logout.php" class="admin-nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <h1 class="topbar-title"><?php echo $page_title ?? 'Dashboard'; ?></h1>
            <div class="topbar-actions">
                <a href="#" class="user-dropdown">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars(getCurrentUsername()); ?></span>
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">