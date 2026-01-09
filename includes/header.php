<?php
// Include session handler
require_once __DIR__ . '/session.php';

// Default path if not set
$path = isset($path) ? $path : './';
$active_tab = isset($active_tab) ? $active_tab : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Nft Verse'; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/style.css">

    <?php if (isset($extra_css))
        echo $extra_css; ?>
</head>

<body>

    <!-- Particle Background -->
    <div id="particles-js"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $path; ?>index.php">
                <i class="fas fa-gem me-2"></i>
                <span class="brand-text">NFT-VERSE</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_tab == 'home') ? 'active' : ''; ?>"
                            href="<?php echo $path; ?>index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_tab == 'roadmap') ? 'active' : ''; ?>"
                            href="<?php echo $path; ?>pages/roadmap.php">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_tab == 'gallery') ? 'active' : ''; ?>"
                            href="<?php echo $path; ?>pages/gallery.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_tab == 'team') ? 'active' : ''; ?>"
                            href="<?php echo $path; ?>pages/team.php">Tim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-mint <?php echo ($active_tab == 'mint') ? 'active' : ''; ?>"
                            href="<?php echo $path; ?>pages/mint.php">
                            <i class="fas fa-fire me-1"></i> Mint Sekarang !
                        </a>
                    </li>

                    <!-- Auth Navigation -->
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo htmlspecialchars(getCurrentUsername()); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <?php if (isAdmin()): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo $path; ?>admin/index.php">
                                            <i class="fas fa-cogs me-2"></i>Admin Panel
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $path; ?>auth/logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $path; ?>auth/login.php">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>