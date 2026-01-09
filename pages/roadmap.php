<?php
$path = '../';
$page_title = 'RoadMap - NFT-VERSE';
$active_tab = 'roadmap';
$extra_css = '    <style>
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
            content: \'\';
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
    </style>';
include '../includes/header.php';
?>

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
            // Get roadmap from database
            require_once __DIR__ . '/../includes/functions.php';
            $roadmap = getRoadmap();

            foreach ($roadmap as $index => $phase):
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
                                <div class="text-muted small mb-1"><?php echo htmlspecialchars($phase['phase_name']); ?>
                                </div>
                                <h3 class="phase-title"><?php echo htmlspecialchars($phase['title']); ?></h3>
                            </div>
                            <span class="phase-status status-<?php echo $phase['status']; ?>">
                                <?php if ($phase['status'] == 'completed'): ?>
                                    <i class="fas fa-check-circle me-1"></i>
                                <?php elseif ($phase['status'] == 'progress'): ?>
                                    <i class="fas fa-spinner me-1"></i>
                                <?php else: ?>
                                    <i class="fas fa-clock me-1"></i>
                                <?php endif; ?>
                                <?php echo htmlspecialchars($phase['status_text']); ?>
                            </span>
                        </div>

                        <ul class="milestone-list">
                            <?php foreach ($phase['milestones'] as $milestone): ?>
                                <li class="milestone-item">
                                    <div class="milestone-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span
                                        class="milestone-text"><?php echo htmlspecialchars($milestone['milestone_text']); ?></span>
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

<?php include '../includes/footer.php'; ?>