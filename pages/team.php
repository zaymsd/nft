<?php
$path = '../';
$page_title = 'Team & Lore - CryptoVerse NFT';
$active_tab = 'team';
$extra_css = '    <style>
        /* Team Page Specific Styles */
        .team-page {
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 50px;
        }
        
        /* Lore Section */
        .lore-section {
            margin-bottom: 5rem;
        }
        
        .lore-container {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 30px;
            padding: 3rem;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .lore-container::before {
            content: \'\';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 245, 255, 0.05) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        .lore-content {
            position: relative;
            z-index: 1;
        }
        
        .lore-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .lore-text {
            font-size: 1.1rem;
            line-height: 2;
            color: var(--text-secondary);
            text-align: justify;
            margin-bottom: 1.5rem;
        }
        
        .lore-highlight {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        /* Manifesto Box */
        .manifesto-box {
            background: var(--gradient-1);
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
        }
        
        .manifesto-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .manifesto-text {
            font-size: 1.1rem;
            line-height: 1.8;
            font-style: italic;
        }
        
        /* Team Section */
        .team-section {
            margin-top: 5rem;
        }
        
        .section-divider {
            width: 100px;
            height: 4px;
            background: var(--gradient-3);
            margin: 3rem auto;
            border-radius: 2px;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .team-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .team-card::before {
            content: \'\';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-1);
            transform: scaleX(0);
            transition: var(--transition);
        }
        
        .team-card:hover {
            transform: translateY(-15px);
            border-color: var(--primary-color);
            box-shadow: 0 25px 50px rgba(0, 245, 255, 0.3);
        }
        
        .team-card:hover::before {
            transform: scaleX(1);
        }
        
        .team-avatar {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--primary-color);
            box-shadow: 0 10px 30px rgba(0, 245, 255, 0.4);
            position: relative;
        }
        
        .team-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .team-card:hover .team-avatar img {
            transform: scale(1.1);
        }
        
        .team-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .team-role {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }
        
        .team-bio {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .team-socials {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        
        .social-btn {
            width: 40px;
            height: 40px;
            background: rgba(0, 245, 255, 0.1);
            border: 1px solid rgba(0, 245, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            transition: var(--transition);
            text-decoration: none;
        }
        
        .social-btn:hover {
            background: var(--primary-color);
            color: var(--dark-bg);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 245, 255, 0.4);
        }
        
        /* Stats Cards */
        .team-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }
        
        .stat-box {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-family: \'Orbitron\', sans-serif;
        }
        
        .stat-label {
            color: var(--text-secondary);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .lore-container {
                padding: 2rem;
            }
            
            .lore-title {
                font-size: 2rem;
            }
            
            .manifesto-box {
                padding: 1.5rem;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>';
include '../includes/header.php';
?>

<!-- Team Page -->
<section class="team-page">
    <div class="container">

        <!-- Page Header -->
        <div class="page-header text-center" data-aos="fade-up">
            <h1 class="gradient-text">Profil & Tim Kreator</h1>
            <p class="section-subtitle">Temui para visioner di balik NFT-Verse.</p>
        </div>

        <!-- Lore Section -->
        <div class="lore-section" data-aos="fade-up" data-aos-delay="100">
            <div class="lore-container">
                <div class="lore-content">
                    <h2 class="lore-title">
                        <i class="fas fa-book-open me-3"></i>
                        Perjalanan Epik NFT-Verse
                    </h2>

                    <p class="lore-text">
                        Pada tahun <span class="lore-highlight">2025</span>, umat manusia mencapai hal yang
                        mustahil—sebuah penyatuan sempurna antara dunia fisik dan digital. Lahir lah <span
                            class="lore-highlight">NFT-Verse</span> sebuah metaverse tanpa batas di mana kesadaran dapat
                        mengalir bebas di antara realitas.
                    </p>

                    <p class="lore-text">
                        Namun, kekuatan besar selalu datang bersama tanggung jawab besar. <span
                            class="lore-highlight">10,000 Pionir</span> muncul sebagai para penjaga dimensi baru ini.
                        Setiap NFT merepresentasikan entitas unik—jiwa digital dengan kisah, kemampuan, dan takdirnya
                        sendiri. Ini bukan sekadar gambar <span class="lore-highlight">mereka adalah kunci untuk membuka
                            masa depan.</span>.
                    </p>

                    <p class="lore-text">
                        Sebagai seorang pemegang, Anda menjadi bagian dari narasi epik ini. Anda memperoleh akses ke
                        dunia eksklusif, berpartisipasi dalam membentuk evolusi NFT-Verse, dan meraih imbalan yang
                        menjembatani kedua dunia. Pertanyaannya adalah: <span class="lore-highlight">Apakah Anda siap
                            bergabung dalam revolusi ini?
                        </span>
                    </p>


                </div>
            </div>

            <!-- Manifesto -->
            <div class="manifesto-box" data-aos="zoom-in" data-aos-delay="200">
                <h3 class="manifesto-title">
                    <i class="fas fa-quote-left me-2"></i>
                    Komitmen Kami
                    <i class="fas fa-quote-right ms-2"></i>
                </h3>
                <p class="manifesto-text">
                    "Kami percaya pada masa depan di mana kepemilikan digital sama mendasarnya dengan kepemilikan fisik.
                    Di mana komunitas menjadi penggerak inovasi, bukan korporasi.
                    Di mana seni, teknologi, dan kemanusiaan berpadu untuk menciptakan sesuatu yang lebih besar dari
                    sekadar jumlah bagiannya.
                    NFT-Verse bukan sekadar proyek—ini adalah sebuah gerakan menuju masa depan yang terdesentralisasi,
                    adil, dan luar biasa."

                </p>
                <div class="mt-3">
                    <strong>Pendiri NFT-Verse</strong>
                </div>
            </div>
        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- Team Section -->
        <div class="team-section">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-title">Kenali Tim Kami</h2>
                <p class="section-subtitle">Para profesional berpengalaman yang berdedikasi membangun masa depan.</p>
            </div>

            <div class="team-grid">
                <?php
                $team = [
                    [
                        'name' => 'Zaelani "zaym" Mursid',
                        'role' => 'Founder & CEO',
                        'bio' => 'Memiliki rekam jejak lebih dari satu dekade di industri blockchain dan berhasil mengelola proyek NFT dengan penjualan mencapai $50 juta.',
                        'twitter' => 'https://twitter.com',
                        'linkedin' => 'https://linkedin.com',
                        'avatar' => 'https://i.pravatar.cc/300?img=12'
                    ],
                    [
                        'name' => 'Sarah "CodeQueen" Park',
                        'role' => 'Lead Developer',
                        'bio' => 'Full-stack blockchain developer. Former Ethereum Foundation contributor with expertise in smart contracts.',
                        'twitter' => 'https://twitter.com',
                        'github' => 'https://github.com',
                        'avatar' => 'https://i.pravatar.cc/300?img=5'
                    ],
                    [
                        'name' => 'Marcus "PixelMaster" Rivera',
                        'role' => 'Art Director',
                        'bio' => 'Award-winning digital artist. Worked with major brands and created art for Fortune 500 companies.',
                        'twitter' => 'https://twitter.com',
                        'instagram' => 'https://instagram.com',
                        'avatar' => 'https://i.pravatar.cc/300?img=33'
                    ],
                    [
                        'name' => 'Emily "Web3Guru" Foster',
                        'role' => 'Community Manager',
                        'bio' => 'Built and managed communities of 100k+ members. Expert in engagement and growth strategies.',
                        'twitter' => 'https://twitter.com',
                        'discord' => 'https://discord.gg',
                        'avatar' => 'https://i.pravatar.cc/300?img=9'
                    ],
                    [
                        'name' => 'David "MarketingNinja" Lee',
                        'role' => 'Marketing Lead',
                        'bio' => 'Growth hacker with proven track record. Generated $10M+ revenue across multiple Web3 projects.',
                        'twitter' => 'https://twitter.com',
                        'linkedin' => 'https://linkedin.com',
                        'avatar' => 'https://i.pravatar.cc/300?img=15'
                    ],
                    [
                        'name' => 'Rachel "SmartContract" Kim',
                        'role' => 'Blockchain Architect',
                        'bio' => 'Security researcher and auditor. Audited 50+ smart contracts with zero security breaches.',
                        'twitter' => 'https://twitter.com',
                        'github' => 'https://github.com',
                        'avatar' => 'https://i.pravatar.cc/300?img=16'
                    ]
                ];

                foreach ($team as $index => $member):
                    $delay = ($index + 1) * 100;
                    ?>
                    <div class="team-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="team-avatar">
                            <img src="<?php echo $member['avatar']; ?>" alt="<?php echo $member['name']; ?>">
                        </div>
                        <h4 class="team-name"><?php echo $member['name']; ?></h4>
                        <div class="team-role"><?php echo $member['role']; ?></div>
                        <p class="team-bio"><?php echo $member['bio']; ?></p>
                        <div class="team-socials">
                            <?php if (isset($member['twitter'])): ?>
                                <a href="<?php echo $member['twitter']; ?>" class="social-btn" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (isset($member['linkedin'])): ?>
                                <a href="<?php echo $member['linkedin']; ?>" class="social-btn" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (isset($member['github'])): ?>
                                <a href="<?php echo $member['github']; ?>" class="social-btn" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (isset($member['instagram'])): ?>
                                <a href="<?php echo $member['instagram']; ?>" class="social-btn" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (isset($member['discord'])): ?>
                                <a href="<?php echo $member['discord']; ?>" class="social-btn" target="_blank">
                                    <i class="fab fa-discord"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Team Stats -->
            <div class="team-stats" data-aos="fade-up">
                <div class="stat-box">
                    <div class="stat-value">50+</div>
                    <div class="stat-label">- Pengalaman Kolektif</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">$100M+</div>
                    <div class="stat-label">Total Pendapatan yang Dihasilkan</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">20+</div>
                    <div class="stat-label">projek berhasil</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">500K+</div>
                    <div class="stat-label">member komunitas</div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-5" data-aos="fade-up">
            <div class="cta-box" style="max-width: 800px; margin: 0 auto;">
                <h3 class="mb-3">Ingin Menjadi Bagian dari Perjalanan Ini?</h3>
                <p class="mb-4">Bergabunglah dengan komunitas kami dan bantu membentuk masa depan NFT-Verse</p>
                <a href="https://discord.gg" target="_blank" class="btn btn-light btn-lg me-2 mb-2">
                    <i class="fab fa-discord me-2"></i> Bergabung Discord
                </a>
                <a href="https://twitter.com" target="_blank" class="btn btn-outline-light btn-lg mb-2">
                    <i class="fab fa-twitter me-2"></i> Ikuti Twitter
                </a>
            </div>
        </div>

    </div>
</section>

<?php include '../includes/footer.php'; ?>