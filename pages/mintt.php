<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mint Your NFT - CryptoVerse</title>
    
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
        /* Mint Page Specific Styles */
        .mint-page {
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 50px;
        }
        
        /* Mint Container */
        .mint-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .mint-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }
        
        /* Preview Section */
        .mint-preview {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 30px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            position: sticky;
            top: 100px;
        }
        
        .preview-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 20px 50px rgba(0, 245, 255, 0.3);
        }
        
        .preview-image img {
            width: 100%;
            height: auto;
            display: block;
            animation: float 6s ease-in-out infinite;
        }
        
        .mystery-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gradient-1);
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.5);
        }
        
        .preview-info {
            text-align: center;
        }
        
        .preview-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .preview-text {
            color: var(--text-secondary);
            line-height: 1.8;
        }
        
        /* Mint Interface */
        .mint-interface {
            background: var(--card-bg);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 30px;
            padding: 3rem;
            backdrop-filter: blur(10px);
        }
        
        .mint-status {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(0, 245, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(0, 245, 255, 0.2);
        }
        
        .status-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }
        
        .status-value {
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary-color);
            font-family: 'Orbitron', sans-serif;
        }
        
        .progress-bar-container {
            margin-top: 1rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            height: 10px;
            overflow: hidden;
        }
        
        .progress-bar-fill {
            height: 100%;
            background: var(--gradient-1);
            border-radius: 10px;
            transition: width 0.5s ease;
        }
        
        /* Wallet Section */
        .wallet-section {
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .wallet-btn {
            width: 100%;
            padding: 1.5rem;
            background: var(--card-bg);
            border: 2px solid rgba(0, 245, 255, 0.3);
            border-radius: 15px;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        
        .wallet-btn:hover {
            background: rgba(0, 245, 255, 0.1);
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 245, 255, 0.3);
        }
        
        .wallet-btn i {
            font-size: 1.5rem;
        }
        
        .wallet-connected {
            background: rgba(16, 185, 129, 0.1);
            border-color: #10b981;
        }
        
        .wallet-address {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-family: 'Courier New', monospace;
        }
        
        /* Mint Controls */
        .mint-controls {
            margin-bottom: 2rem;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .qty-btn {
            width: 50px;
            height: 50px;
            background: var(--card-bg);
            border: 2px solid rgba(0, 245, 255, 0.3);
            border-radius: 50%;
            color: var(--primary-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .qty-btn:hover:not(:disabled) {
            background: var(--primary-color);
            color: var(--dark-bg);
            transform: scale(1.1);
        }
        
        .qty-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .qty-display {
            font-size: 3rem;
            font-weight: 900;
            color: var(--primary-color);
            min-width: 100px;
            text-align: center;
            font-family: 'Orbitron', sans-serif;
        }
        
        .price-info {
            background: rgba(0, 245, 255, 0.05);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .price-row:last-child {
            margin-bottom: 0;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 245, 255, 0.2);
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        .price-label {
            color: var(--text-secondary);
        }
        
        .price-value {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        /* Mint Button */
        .mint-btn {
            width: 100%;
            padding: 1.5rem;
            background: var(--gradient-1);
            border: none;
            border-radius: 15px;
            color: white;
            font-size: 1.3rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
        }
        
        .mint-btn:hover:not(:disabled) {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.7);
        }
        
        .mint-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .mint-btn i {
            margin-right: 0.5rem;
        }
        
        /* FAQ Section */
        .faq-section {
            margin-top: 3rem;
        }
        
        .faq-item {
            background: rgba(0, 245, 255, 0.05);
            border: 1px solid rgba(0, 245, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .faq-question {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .faq-answer {
            color: var(--text-secondary);
            line-height: 1.8;
        }
        
        /* Success Modal */
        .success-animation {
            text-align: center;
            padding: 2rem;
        }
        
        .success-icon {
            font-size: 5rem;
            color: #10b981;
            animation: scaleIn 0.5s ease;
        }
        
        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .mint-main {
                grid-template-columns: 1fr;
            }
            
            .mint-preview {
                position: relative;
                top: 0;
            }
            
            .mint-interface {
                padding: 2rem;
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
                        <a class="nav-link" href="gallery.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="team.php">Tim</a>
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

    <!-- Mint Page -->
    <section class="mint-page">
        <div class="container mint-container">
            
            <!-- Page Header -->
            <div class="page-header text-center mb-5" data-aos="fade-up">
                <h1 class="gradient-text">Mint Your NFT</h1>
                <p class="section-subtitle">Secure your spot in the CryptoVerse revolution</p>
            </div>
            
            <!-- Mint Status Bar -->
            <div class="mint-status" data-aos="fade-up" data-aos-delay="100">
                <div class="status-label">Minting NFT</div>
                <div class="status-value">
                    <span id="mintedCount">7,842</span> / 10,000
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" id="progressBar" style="width: 78.42%"></div>
                </div>
            </div>
            
            <!-- Main Mint Interface -->
            <div class="mint-main">
                
                <!-- Preview Section -->
                <div class="mint-preview" data-aos="fade-right" data-aos-delay="200">
                    <div class="preview-image">
                        <img src="../assets/images/nft-9.png" alt="Mystery NFT" id="previewImage">
                        <div class="mystery-badge">
                            <i class="fas fa-question-circle me-2"></i>
                            Mystery Box
                        </div>
                    </div>
                    <div class="preview-info">
                        <h3 class="preview-title">What Will You Get?</h3>
                        <p class="preview-text">
                            Each NFT is unique with randomly generated traits. Your NFT will be revealed 
                            48 hours after minting. Rarity levels include: Common, Rare, Epic, and Legendary!
                        </p>
                    </div>
                </div>
                
                <!-- Mint Interface -->
                <div class="mint-interface" data-aos="fade-left" data-aos-delay="200">
                    
                    <!-- Wallet Connection -->
                    <div class="wallet-section">
                        <h3 class="section-title">
                            <i class="fas fa-wallet me-2"></i> 1. Connect Wallet
                        </h3>
                        <button class="wallet-btn" id="connectWalletBtn" onclick="connectWallet()">
                            <span>
                                <i class="fab fa-ethereum me-2"></i>
                                <span id="walletStatus">Connect MetaMask</span>
                            </span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <!-- Mint Controls -->
                    <div class="mint-controls">
                        <h3 class="section-title">
                            <i class="fas fa-sliders-h me-2"></i> 2. Select Quantity
                        </h3>
                        
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="decreaseQty()" id="decreaseBtn">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="qty-display" id="quantity">1</div>
                            <button class="qty-btn" onclick="increaseQty()" id="increaseBtn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <div class="text-center mb-3">
                            <small class="text-muted">Maximum 10 NFTs per transaction</small>
                        </div>
                        
                        <div class="price-info">
                            <div class="price-row">
                                <span class="price-label">Price per NFT:</span>
                                <span class="price-value">0.08 ETH</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Quantity:</span>
                                <span class="price-value" id="qtyDisplay">1</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Total Price:</span>
                                <span class="price-value">
                                    <i class="fab fa-ethereum me-1"></i>
                                    <span id="totalPrice">0.08</span> ETH
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mint Button -->
                    <button class="mint-btn" id="mintBtn" onclick="mintNFT()" disabled>
                        <i class="fas fa-lock"></i> Connect Wallet First
                    </button>
                    
                    <!-- FAQ Mini -->
                    <div class="faq-section">
                        <h3 class="section-title">
                            <i class="fas fa-question-circle me-2"></i> Quick FAQ
                        </h3>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fas fa-chevron-right me-2"></i>
                                What is the mint price?
                            </div>
                            <div class="faq-answer">
                                0.08 ETH per NFT. Maximum 10 NFTs per transaction.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fas fa-chevron-right me-2"></i>
                                When is the reveal?
                            </div>
                            <div class="faq-answer">
                                Your NFT will be revealed 48 hours after mint completes or when all 10,000 are sold out.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fas fa-chevron-right me-2"></i>
                                Which wallets are supported?
                            </div>
                            <div class="faq-answer">
                                MetaMask, WalletConnect, Coinbase Wallet, and Phantom are all supported.
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </section>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="success-animation">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="mt-3 mb-2">Congratulations!</h3>
                        <p class="text-muted mb-4">Your NFT has been minted successfully!</p>
                        <p>Token ID: <strong class="text-primary">#<span id="tokenId">0000</span></strong></p>
                        <hr>
                        <div class="d-grid gap-2 mt-4">
                            <a href="gallery.php" class="btn btn-primary">
                                <i class="fas fa-images me-2"></i> View in Gallery
                            </a>
                            <button class="btn btn-outline-light" data-bs-dismiss="modal">
                                Close
                            </button>
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
        // Mint Configuration
        const MINT_PRICE = 0.08;
        const MAX_QUANTITY = 10;
        let currentQty = 1;
        let walletConnected = false;
        
        // Connect Wallet Function
        function connectWallet() {
            const btn = document.getElementById('connectWalletBtn');
            const status = document.getElementById('walletStatus');
            const mintBtn = document.getElementById('mintBtn');
            
            // Simulate wallet connection
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Connecting...';
            
            setTimeout(() => {
                walletConnected = true;
                btn.classList.add('wallet-connected');
                btn.innerHTML = `
                    <span>
                        <i class="fas fa-check-circle me-2"></i>
                        <span class="wallet-address">0x742d...a3f9</span>
                    </span>
                    <i class="fas fa-power-off"></i>
                `;
                
                mintBtn.disabled = false;
                mintBtn.innerHTML = '<i class="fas fa-fire me-2"></i> Mint Now';
                
                // Change onclick to disconnect
                btn.setAttribute('onclick', 'disconnectWallet()');
            }, 1500);
        }
        
        // Disconnect Wallet
        function disconnectWallet() {
            walletConnected = false;
            const btn = document.getElementById('connectWalletBtn');
            const mintBtn = document.getElementById('mintBtn');
            
            btn.classList.remove('wallet-connected');
            btn.innerHTML = `
                <span>
                    <i class="fab fa-ethereum me-2"></i>
                    Connect MetaMask
                </span>
                <i class="fas fa-chevron-right"></i>
            `;
            btn.setAttribute('onclick', 'connectWallet()');
            
            mintBtn.disabled = true;
            mintBtn.innerHTML = '<i class="fas fa-lock"></i> Connect Wallet First';
        }
        
        // Quantity Functions
        function increaseQty() {
            if(currentQty < MAX_QUANTITY) {
                currentQty++;
                updateQuantity();
            }
        }
        
        function decreaseQty() {
            if(currentQty > 1) {
                currentQty--;
                updateQuantity();
            }
        }
        
        function updateQuantity() {
            document.getElementById('quantity').textContent = currentQty;
            document.getElementById('qtyDisplay').textContent = currentQty;
            
            const total = (MINT_PRICE * currentQty).toFixed(2);
            document.getElementById('totalPrice').textContent = total;
            
            // Update buttons
            document.getElementById('decreaseBtn').disabled = currentQty <= 1;
            document.getElementById('increaseBtn').disabled = currentQty >= MAX_QUANTITY;
        }
        
        // Mint Function
        function mintNFT() {
            if(!walletConnected) {
                alert('Please connect your wallet first!');
                return;
            }
            
            const mintBtn = document.getElementById('mintBtn');
            mintBtn.disabled = true;
            mintBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Minting...';
            
            // Simulate minting process
            setTimeout(() => {
                // Generate random token ID
                const tokenId = Math.floor(Math.random() * 10000);
                document.getElementById('tokenId').textContent = String(tokenId).padStart(4, '0');
                
                // Show success modal
                const modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
                
                // Reset button
                mintBtn.disabled = false;
                mintBtn.innerHTML = '<i class="fas fa-fire me-2"></i> Mint Now';
                
                // Update minted count
                const currentMinted = parseInt(document.getElementById('mintedCount').textContent.replace(',', ''));
                const newMinted = currentMinted + currentQty;
                document.getElementById('mintedCount').textContent = newMinted.toLocaleString();
                
                const progress = (newMinted / 10000) * 100;
                document.getElementById('progressBar').style.width = progress + '%';
            }, 3000);
        }
        
        // Random preview image rotation
        const previewImages = [1, 2, 3, 4];
        let currentImageIndex = 0;
        
        setInterval(() => {
            currentImageIndex = (currentImageIndex + 1) % previewImages.length;
            const imgSrc = `../assets/images/nft-${previewImages[currentImageIndex]}.jpg`;
            document.getElementById('previewImage').src = imgSrc;
        }, 5000);
    </script>
    
</body>
</html>