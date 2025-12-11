<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - CryptoVerse NFT</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* Gallery Specific Styles */
        .gallery-page {
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 50px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-header h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
        
        /* Filter Section */
        .filter-section {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            backdrop-filter: blur(10px);
        }
        
        .filter-title {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .filter-btn {
            padding: 0.6rem 1.5rem;
            border: 2px solid rgba(0, 245, 255, 0.3);
            background: transparent;
            color: var(--text-secondary);
            border-radius: 25px;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--gradient-1);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Search Box */
        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto 3rem;
        }
        
        .search-input {
            width: 100%;
            padding: 1rem 3rem 1rem 1.5rem;
            background: var(--card-bg);
            border: 2px solid rgba(0, 245, 255, 0.3);
            border-radius: 30px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.3);
        }
        
        .search-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        /* NFT Grid */
        .nft-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .gallery-nft-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            backdrop-filter: blur(10px);
            cursor: pointer;
        }
        
        .gallery-nft-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: var(--primary-color);
            box-shadow: 0 25px 50px rgba(0, 245, 255, 0.4);
        }
        
        .gallery-nft-image {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
        }
        
        .gallery-nft-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .gallery-nft-card:hover .gallery-nft-image img {
            transform: scale(1.15);
        }
        
        .nft-id {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }
        
        .gallery-nft-info {
            padding: 1.5rem;
        }
        
        .nft-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }
        
        .nft-traits {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .trait-tag {
            padding: 0.3rem 0.8rem;
            background: rgba(0, 245, 255, 0.1);
            border: 1px solid rgba(0, 245, 255, 0.3);
            border-radius: 15px;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .nft-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 245, 255, 0.1);
        }
        
        .nft-rarity {
            font-size: 0.9rem;
            font-weight: 700;
        }
        
        .rarity-score {
            color: var(--primary-color);
            font-size: 1.1rem;
        }
        
        /* Rarity Explorer Modal Styles */
        .modal-content {
            background: var(--card-bg);
            border: 2px solid rgba(0, 245, 255, 0.3);
            backdrop-filter: blur(20px);
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(0, 245, 255, 0.2);
        }
        
        .modal-title {
            color: var(--primary-color);
        }
        
        .btn-close {
            filter: invert(1);
        }
        
        .modal-body {
            color: var(--text-secondary);
        }
        
        /* Loading Animation */
        .loading {
            text-align: center;
            padding: 3rem;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(0, 245, 255, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .no-results i {
            font-size: 4rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .nft-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }
            
            .filter-buttons {
                justify-content: center;
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
                        <a class="nav-link" href="roadmap.php">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="gallery.php">Galeri</a>
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

    <!-- Gallery Page -->
    <section class="gallery-page">
        <div class="container">
            
            <!-- Header -->
            <div class="page-header" data-aos="fade-up">
                <h1 class="gradient-text">Galeri NFT</h1>
                <p class="section-subtitle">Eksplorasi 10.000 aset unik yang hanya tersedia di sini.</p>
            </div>
            
            <!-- Search Box -->
            <div class="search-box" data-aos="fade-up" data-aos-delay="100">
                <input type="text" class="search-input" id="searchInput" placeholder="Search by Token ID or Name...">
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <!-- Filters -->
            <div class="filter-section" data-aos="fade-up" data-aos-delay="200">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="filter-title">Filter by Rarity:</div>
                        <div class="filter-buttons" id="rarityFilters">
                            <button class="filter-btn active" data-filter="all">All</button>
                            <button class="filter-btn" data-filter="legendary">Legendary</button>
                            <button class="filter-btn" data-filter="epic">Epic</button>
                            <button class="filter-btn" data-filter="rare">Rare</button>
                            <button class="filter-btn" data-filter="common">Common</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="filter-title">Filter by Trait:</div>
                        <div class="filter-buttons" id="traitFilters">
                            <button class="filter-btn active" data-filter="all">All</button>
                            <button class="filter-btn" data-filter="cyber">Cyber</button>
                            <button class="filter-btn" data-filter="neon">Neon</button>
                            <button class="filter-btn" data-filter="holographic">Holographic</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- NFT Grid -->
            <div class="nft-grid" id="nftGrid">
                <?php
                // Generate sample NFT data
                $nfts = [];
                $rarities = ['legendary', 'epic', 'rare', 'common'];
                $traits = ['cyber', 'neon', 'holographic'];
                $prefixes = ['Cyber', 'Neon', 'Digital', 'Quantum', 'Cosmic', 'Virtual'];
                $suffixes = ['Warrior', 'Guardian', 'Phoenix', 'Dragon', 'Knight', 'Samurai'];
                
                for($i = 1; $i <= 24; $i++) {
                    $rarity = $rarities[array_rand($rarities)];
                    $trait = $traits[array_rand($traits)];
                    $prefix = $prefixes[array_rand($prefixes)];
                    $suffix = $suffixes[array_rand($suffixes)];
                    
                    $nfts[] = [
                        'id' => str_pad($i, 4, '0', STR_PAD_LEFT),
                        'name' => "$prefix $suffix",
                        'rarity' => $rarity,
                        'trait' => $trait,
                        'score' => rand(50, 999) / 10,
                        'price' => number_format(rand(5, 50) / 10, 2)
                    ];
                }
                
                foreach($nfts as $nft):
                ?>
                <div class="gallery-nft-card" 
                     data-aos="zoom-in" 
                     data-rarity="<?php echo $nft['rarity']; ?>"
                     data-trait="<?php echo $nft['trait']; ?>"
                     data-name="<?php echo strtolower($nft['name']); ?>"
                     data-id="<?php echo $nft['id']; ?>">
                    
                    <div class="gallery-nft-image">
                        <img src="../assets/images/nft-<?php echo ($nft['id'] % 15) + 1; ?>.png" alt="<?php echo $nft['name']; ?>">
                        <div class="nft-id">#<?php echo $nft['id']; ?></div>
                        <span class="rarity-badge rarity-<?php echo $nft['rarity']; ?>">
                            <?php echo ucfirst($nft['rarity']); ?>
                        </span>
                    </div>
                    
                    <div class="gallery-nft-info">
                        <h5 class="nft-name"><?php echo $nft['name']; ?></h5>
                        
                        <div class="nft-traits">
                            <span class="trait-tag">
                                <i class="fas fa-cube me-1"></i> <?php echo ucfirst($nft['trait']); ?>
                            </span>
                            <span class="trait-tag">
                                <i class="fas fa-star me-1"></i> Score: <?php echo $nft['score']; ?>
                            </span>
                        </div>
                        
                        <div class="nft-footer">
                            <div class="nft-price">
                                <i class="fab fa-ethereum me-1"></i>
                                <span><?php echo $nft['price']; ?> ETH</span>
                            </div>
                            <button class="btn btn-sm btn-outline-light" onclick="viewDetails('<?php echo $nft['id']; ?>')">
                                <i class="fas fa-eye me-1"></i> View
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- No Results Message -->
            <div class="no-results" id="noResults" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>No NFTs Found</h3>
                <p class="text-muted">Try adjusting your filters or search query</p>
            </div>
            
            <!-- Load More Button -->
            <div class="text-center mt-5" data-aos="fade-up">
                <button class="btn btn-primary btn-glow btn-lg" id="loadMoreBtn">
                    <i class="fas fa-sync-alt me-2"></i> Load More NFTs
                </button>
            </div>
            
        </div>
    </section>

    <!-- NFT Detail Modal -->
    <div class="modal fade" id="nftModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-cube me-2"></i> NFT Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="../assets/images/nft-<?php echo ($nft['id'] % 4) + 1; ?>.png" class="img-fluid rounded" id="modalImage">
                        </div>
                        <div class="col-md-6">
                            <h3 id="modalTitle">NFT Name</h3>
                            <p class="text-muted">Token ID: <span id="modalId">#0001</span></p>
                            <hr>
                            <div class="mb-3">
                                <strong>Rarity:</strong>
                                <span id="modalRarity" class="ms-2"></span>
                            </div>
                            <div class="mb-3">
                                <strong>Rarity Score:</strong>
                                <span id="modalScore" class="ms-2 text-primary"></span>
                            </div>
                            <div class="mb-3">
                                <strong>Current Price:</strong>
                                <span id="modalPrice" class="ms-2"></span>
                            </div>
                            <hr>
                            <h5>Attributes</h5>
                            <div id="modalTraits"></div>
                            <hr>
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-primary btn-glow">
                                    <i class="fas fa-shopping-cart me-2"></i> Buy Now
                                </a>
                                <a href="#" class="btn btn-outline-light">
                                    <i class="fas fa-external-link-alt me-2"></i> View on OpenSea
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    
    <script>
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const nftCards = document.querySelectorAll('.gallery-nft-card');
        const searchInput = document.getElementById('searchInput');
        const noResults = document.getElementById('noResults');
        
        let activeRarityFilter = 'all';
        let activeTraitFilter = 'all';
        
        // Rarity Filter
        document.getElementById('rarityFilters').addEventListener('click', function(e) {
            if(e.target.classList.contains('filter-btn')) {
                this.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                activeRarityFilter = e.target.dataset.filter;
                applyFilters();
            }
        });
        
        // Trait Filter
        document.getElementById('traitFilters').addEventListener('click', function(e) {
            if(e.target.classList.contains('filter-btn')) {
                this.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                activeTraitFilter = e.target.dataset.filter;
                applyFilters();
            }
        });
        
        // Search functionality
        searchInput.addEventListener('input', applyFilters);
        
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            let visibleCount = 0;
            
            nftCards.forEach(card => {
                const rarity = card.dataset.rarity;
                const trait = card.dataset.trait;
                const name = card.dataset.name;
                const id = card.dataset.id;
                
                const matchesRarity = activeRarityFilter === 'all' || rarity === activeRarityFilter;
                const matchesTrait = activeTraitFilter === 'all' || trait === activeTraitFilter;
                const matchesSearch = searchTerm === '' || name.includes(searchTerm) || id.includes(searchTerm);
                
                if(matchesRarity && matchesTrait && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
        
        // View Details Modal
        function viewDetails(tokenId) {
            const modal = new bootstrap.Modal(document.getElementById('nftModal'));
            document.getElementById('modalId').textContent = '#' + tokenId;
            modal.show();
        }
        
        // Load More Button
        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';
            
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check me-2"></i> All NFTs Loaded';
                this.disabled = true;
            }, 1500);
        });
    </script>
    
</body>
</html>