<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoadMap - NFT-VERSE</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* Roadmap Specific Styles */
        .roadmap-page {
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 50px;
        }
        
        .roadmap-header {
            text-align: center;
            margin-bottom: 5rem;
        }
        
        .roadmap-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
        
        .roadmap-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Vertical Line */
        .roadmap-container::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            transform: translateX(-50%);
            z-index: 0;
        }
        
        .roadmap-phase {
            position: relative;
            margin-bottom: 5rem;
            opacity: 0;
            animation: fadeInUp 0.8s forwards;
        }
        
        .roadmap-phase:nth-child(1) { animation-delay: 0.2s; }
        .roadmap-phase:nth-child(2) { animation-delay: 0.4s; }
        .roadmap-phase:nth-child(3) { animation-delay: 0.6s; }
        .roadmap-phase:nth-child(4) { animation-delay: 0.8s; }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Phase Number Circle */
        .phase-number {
            position: absolute;
            left: 50%;
            top: 0;
            width: 80px;
            height: 80px;
            background: var(--gradient-1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 900;
            color: white;
            transform: translateX(-50%);
            z-index: 2;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
            border: 4px solid var(--darker-bg);
        }
        
        /* Phase Content */
        .phase-content {
            width: calc(50% - 60px);
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }
        
        .phase-content:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: 0 20px 40px rgba(0, 245, 255, 0.3);
        }
        
        /* Alternate sides */
        .roadmap-phase:nth-child(odd) .phase-content {
            margin-left: auto;
        }
        
        .roadmap-phase:nth-child(even) .phase-content {
            margin-right: auto;
        }
        
        .phase-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .phase-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin: 0;
        }
        
        .phase-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        .status-completed {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }
        
        .status-progress {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }
        
        .status-upcoming {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }
        
        .milestone-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .milestone-item {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(0, 245, 255, 0.1);
            display: flex;
            align-items: center;
        }
        
        .milestone-item:last-child {
            border-bottom: none;
        }
        
        .milestone-icon {
            width: 30px;
            height: 30px;
            background: var(--gradient-3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .milestone-icon i {
            font-size: 0.8rem;
            color: white;
        }
        
        .milestone-text {
            color: var(--text-secondary);
            flex: 1;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .roadmap-container::before {
                left: 20px;
            }
            
            .phase-number {
                left: 20px;
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .phase-content {
                width: calc(100% - 100px);
                margin-left: 100px !important;
            }
            
            .roadmap-phase:nth-child(even) .phase-content {
                margin-left: 100px !important;
            }
            
            .roadmap-header h1 {
                font-size: 2rem;
            }
            
            .phase-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    
    <!-- Particle Background -->
    <div id="particles-js"></div>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-gem me-2"></i>
                <span class="brand-text">NFT-VERSE</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="roadmap.php">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gallery.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team.php">Tim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-mint" href="mint.php">
                            <i class="fas fa-fire me-1"></i> Mint Sekarang
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Roadmap Page -->
    <section class="roadmap-page">
        <div class="container">
            <!-- Header -->
            <div class="roadmap-header" data-aos="fade-up">
                <h1 class="gradient-text">Perjalanan Kami</h1>
                <p class="section-subtitle">Peta jalan transparan menuju masa depan bersama</p>
            </div>
            
            <!-- Roadmap Timeline -->
            <div class="roadmap-container">
                
                <?php
                // Roadmap Data
                $roadmap = [
                    [
                        'phase' => 'Q1 2024',
                        'title' => 'Genesis - Peluncuran & Komunitas',
                        'status' => 'completed',
                        'status_text' => 'Selesai',
                        'milestones' => [
                            '10.000 NFT Terjual Habis dalam 48 Jam',
                            'Komunitas Discord Mencapai 15.000 Anggota',
                            'Pengungkapan Lengkap Semua Trait Koleksi',
                            'Donasi $50.000 untuk Mitra Amal',
                            'Kemitraan dengan Marketplace NFT Utama'
                        ]
                    ],
                    [
                        'phase' => 'Q2 2024',
                        'title' => 'Evolusi - Peluncuran Utilitas',
                        'status' => 'progress',
                        'status_text' => 'Dalam Proses',
                        'milestones' => [
                            'Peluncuran Platform Staking (Live)',
                            'Pembukaan Toko Merchandise Eksklusif',
                            'Mekanisme Breeding Generasi Pertama',
                            'Acara Komunitas & AMA Pemegang NFT',
                            'Rilis Beta Aplikasi Mobile'
                        ]
                    ],
                    [
                        'phase' => 'Q3 2024',
                        'title' => 'Ekspansi - Integrasi Metaverse',
                        'status' => 'upcoming',
                        'status_text' => 'Segera Hadir',
                        'milestones' => [
                            'Airdrop Token $CRYPTO untuk Semua Pemegang',
                            'Peluncuran Beta Game Play-to-Earn',
                            'Penjualan Tanah Virtual di Dunia NFT-Verse',
                            'Kolaborasi dengan Selebriti & Brand',
                            'Koleksi NFT Generasi Kedua'
                        ]
                    ],
                    [
                        'phase' => 'Q4 2024',
                        'title' => 'Revolusi - DAO & Masa Depan',
                        'status' => 'upcoming',
                        'status_text' => 'Masa Depan',
                        'milestones' => [
                            'Implementasi Tata Kelola DAO Penuh',
                            'Grand Opening Metaverse NFT-Verse',
                            'Pengembangan Bridge Cross-Chain',
                            'Acara Fisik & Konferensi Pemegang',
                            'Pengumuman Kemitraan Strategis'
                        ]
                    ]
                ];
                
                foreach($roadmap as $index => $phase):
                ?>
                
                <div class="roadmap-phase">
                    <!-- Phase Number -->
                    <div class="phase-number">
                        <?php echo $index + 1; ?>
                    </div>
                    
                    <!-- Phase Content -->
                    <div class="phase-content">
                        <div class="phase-header">
                            <div>
                                <div class="text-muted small mb-1"><?php echo $phase['phase']; ?></div>
                                <h3 class="phase-title"><?php echo $phase['title']; ?></h3>
                            </div>
                            <span class="phase-status status-<?php echo $phase['status']; ?>">
                                <?php if($phase['status'] == 'completed'): ?>
                                    <i class="fas fa-check-circle me-1"></i>
                                <?php elseif($phase['status'] == 'progress'): ?>
                                    <i class="fas fa-spinner me-1"></i>
                                <?php else: ?>
                                    <i class="fas fa-clock me-1"></i>
                                <?php endif; ?>
                                <?php echo $phase['status_text']; ?>
                            </span>
                        </div>
                        
                        <ul class="milestone-list">
                            <?php foreach($phase['milestones'] as $milestone): ?>
                            <li class="milestone-item">
                                <div class="milestone-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="milestone-text"><?php echo $milestone; ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <?php endforeach; ?>
                
            </div>
            
            <!-- CTA Section -->
            <div class="text-center mt-5" data-aos="fade-up">
                <div class="cta-box" style="max-width: 800px; margin: 0 auto;">
                    <h3 class="mb-3">Ingin Menjadi Bagian dari Perjalanan Ini?</h3>
                    <p class="mb-4">Bergabunglah dengan komunitas kami dan bantu membentuk masa depan NFT-Verse</p>
                    <a href="https://discord.gg" target="_blank" class="btn btn-light btn-lg me-2 mb-2">
                        <i class="fab fa-discord me-2"></i> Gabung Discord
                    </a>
                    <a href="mint.php" class="btn btn-outline-light btn-lg mb-2">
                        <i class="fas fa-rocket me-2"></i> Mint NFT Anda
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h5 class="footer-title">
                        <i class="fas fa-gem me-2"></i> NFT-VERSE
                    </h5>
                    <p class="footer-text">Membangun masa depan kepemilikan digital melalui teknologi NFT inovatif.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="social-link"><i class="fab fa-discord"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="footer-subtitle">Link Cepat</h6>
                    <ul class="footer-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="roadmap.php">Peta Jalan</a></li>
                        <li><a href="gallery.php">Galeri</a></li>
                        <li><a href="team.php">Tim</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="footer-subtitle">Newsletter</h6>
                    <p class="footer-text">Berlangganan untuk update</p>
                    <form class="newsletter-form">
                        <input type="email" class="form-control" placeholder="Email Anda" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <hr class="footer-divider">
            
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright">&copy; 2025 NFT-Verse. Hak cipta dilindungi.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="footer-legal">Kebijakan Privasi</a>
                    <span class="mx-2">|</span>
                    <a href="#" class="footer-legal">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    
</body>
</html>