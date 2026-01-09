<?php
$path = './';
$page_title = 'Nft Verse';
$active_tab = 'home';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 hero-content" data-aos="fade-right">
                <div class="hero-badge mb-3">
                    <i class="fas fa-star me-2"></i>
                    <span>10,000 Unique NFTs</span>
                </div>
                <h1 class="hero-title">
                    Bukan Sekadar Gambar,
                    <span class="gradient-text">Ini Kunci Anda</span>
                    Menuju Masa Depan Digital
                </h1>
                <p class="hero-subtitle">
                    Bergabunglah dengan revolusi Web3. Koleksi NFT eksklusif dengan utility nyata,
                    staking rewards, dan akses ke ekosistem metaverse kami.
                </p>

                <!-- Countdown Timer -->
                <div class="countdown-timer mb-4">
                    <div class="timer-label">PUBLIC MINT STARTS IN:</div>
                    <div class="timer-display" id="countdown">
                        <div class="time-unit">
                            <span class="time-value" id="days">00</span>
                            <span class="time-label">Days</span>
                        </div>
                        <div class="time-unit">
                            <span class="time-value" id="hours">00</span>
                            <span class="time-label">Hours</span>
                        </div>
                        <div class="time-unit">
                            <span class="time-value" id="minutes">00</span>
                            <span class="time-label">Min</span>
                        </div>
                        <div class="time-unit">
                            <span class="time-value" id="seconds">00</span>
                            <span class="time-label">Sec</span>
                        </div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="hero-cta">
                    <a href="https://discord.gg" target="_blank" class="btn btn-primary btn-glow me-3">
                        <i class="fab fa-discord me-2"></i> Gabung Discord
                    </a>
                    <a href="pages/mint.php" class="btn btn-outline-light btn-hover">
                        <i class="fas fa-rocket me-2"></i> Mint Sekarang
                    </a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-visual">
                    <div class="nft-showcase">
                        <div class="nft-card-3d">
                            <div class="nft-card-inner">
                                <img src="assets/images/NR_WK04_Delta.png" alt="Featured NFT"
                                    class="img-fluid nft-main-image">
                                <div class="nft-glow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="mouse">
            <div class="wheel"></div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stat-number" data-count="15000">0</h3>
                    <p class="stat-label">Komunitas</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <h3 class="stat-number" data-count="10000">0</h3>
                    <p class="stat-label">Total Supply</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-ethereum"></i>
                    </div>
                    <h3 class="stat-number">0.08</h3>
                    <p class="stat-label">Mint Price (ETH)</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <h3 class="stat-number" data-count="150">0</h3>
                    <p class="stat-label">Unique Traits</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured NFTs Section -->
<section class="featured-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Koleksi Favorit</h2>
            <p class="section-subtitle">Telusuri koleksi NFT kami yang paling eksklusif dan langka</p>
        </div>

        <div class="row g-4">
            <?php
            // Get featured NFTs from database
            require_once __DIR__ . '/includes/functions.php';
            $nfts = getFeaturedNFTs(4);

            foreach ($nfts as $index => $nft):
                $delay = ($index + 1) * 100;
                ?>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                    <div class="nft-card">
                        <div class="nft-card-image">
                            <img src="<?php echo htmlspecialchars($nft['image_path']); ?>"
                                alt="<?php echo htmlspecialchars($nft['name']); ?>" class="img-fluid">
                            <div class="nft-overlay">
                                <a href="pages/gallery.php" class="btn btn-sm btn-light">View Details</a>
                            </div>
                            <span class="rarity-badge rarity-<?php echo strtolower($nft['rarity']); ?>">
                                <?php echo ucfirst($nft['rarity']); ?>
                            </span>
                        </div>
                        <div class="nft-card-body">
                            <h5 class="nft-title"><?php echo htmlspecialchars($nft['name']); ?></h5>
                            <div class="nft-price">
                                <i class="fab fa-ethereum me-1"></i>
                                <span><?php echo $nft['price']; ?> ETH</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="pages/gallery.php" class="btn btn-primary btn-glow">
                <i class="fas fa-th me-2"></i> View Full Gallery
            </a>
        </div>
    </div>
</section>

<!-- Utility Section -->
<section class="utility-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Keuntungan Eksklusif</h2>
            <p class="section-subtitle">Punya NFT ini, rasakan keuntungannya langsung</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="utility-card">
                    <div class="utility-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h4>Hadiah Staking NFT</h4>
                    <p>Dapatkan penghasilan pasif dengan melakukan staking NFT dan terima token $CRYPTO setiap hari.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="utility-card">
                    <div class="utility-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h4>Akses Metaverse</h4>
                    <p>Hak eksklusif untuk memainkan game play-to-earn dan memiliki lahan virtual.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="utility-card">
                    <div class="utility-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h4>Airdrop Eksklusif</h4>
                    <p>Airdrop rutin berisi NFT baru, token, dan merchandise khusus bagi pemegang setia.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="utility-card">
                    <div class="utility-icon">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                    <h4>Hak Suara DAO</h4>
                    <p>Pemegang token berhak memilih keputusan penting dan mengarahkan perkembangan CryptoVerse.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="utility-card">
                    <div class="utility-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h4>Merchandise Eksklusif</h4>
                    <p>Nikmati kesempatan memiliki barang fisik edisi terbatas serta hasil kolaborasi eksklusif.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="utility-card">
                    <div class="utility-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4>Forum Komunitas</h4>
                    <p>Ikuti acara privat, sesi AMA (Ask Me Anything), dan kesempatan berjejaring bersama tim.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-box" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="cta-title">Ready to Join the Revolution?</h2>
                    <p class="cta-text">Don't miss out on this opportunity. Join our community and be part of the
                        future.</p>
                </div>
                <div class="col-lg-4 text-lg-end text-center mt-4 mt-lg-0">
                    <a href="https://discord.gg" target="_blank" class="btn btn-light btn-lg me-2 mb-2">
                        <i class="fab fa-discord me-2"></i> Discord
                    </a>
                    <a href="https://twitter.com" target="_blank" class="btn btn-outline-light btn-lg mb-2">
                        <i class="fab fa-twitter me-2"></i> Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>