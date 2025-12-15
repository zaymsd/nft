<?php
$path = '../';
$page_title = 'Mint NFT Anda - NFT-VERSE';
$active_tab = 'mint';
$extra_css = '    <style>
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
        
        /* Hero Visual 3D */
        .hero-visual {
            position: relative;
            margin-bottom: 2rem;
        }

        .nft-showcase {
            perspective: 1000px;
        }

        .nft-card-3d {
            position: relative;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotateY(0deg); }
            25% { transform: translateY(-20px) rotateY(5deg); }
            75% { transform: translateY(20px) rotateY(-5deg); }
        }

        .nft-card-inner {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 245, 255, 0.3);
            border: 2px solid rgba(0, 245, 255, 0.3);
        }

        .nft-main-image {
            width: 100%;
            height: auto;
            display: block;
            transition: var(--transition);
        }

        .nft-card-3d:hover .nft-main-image {
            transform: scale(1.05);
        }

        .nft-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 245, 255, 0.2) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .preview-info {
            text-align: center;
            padding: 1.5rem;
            background: rgba(0, 245, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(0, 245, 255, 0.2);
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
            font-family: \'Orbitron\', sans-serif;
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
            font-family: \'Courier New\', monospace;
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
            font-family: \'Orbitron\', sans-serif;
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
    </style>';
include '../includes/header.php';
?>

<!-- Mint Page -->
<section class="mint-page">
    <div class="container mint-container">

        <!-- Page Header -->
        <div class="page-header text-center mb-5" data-aos="fade-up">
            <h1 class="gradient-text">Mint NFT Anda</h1>
            <p class="section-subtitle">Amankan tempat Anda dalam revolusi NFT-Verse</p>
        </div>

        <!-- Mint Status Bar -->
        <div class="mint-status" data-aos="fade-up" data-aos-delay="100">
            <div class="status-label">NFT yang Sudah Di-Mint</div>
            <div class="status-value">
                <span id="mintedCount">7.842</span> / 10.000
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill" id="progressBar" style="width: 78.42%"></div>
            </div>
        </div>

        <!-- Main Mint Interface -->
        <div class="mint-main">

            <!-- Preview Section -->
            <div class="mint-preview" data-aos="fade-right" data-aos-delay="200">
                <div class="hero-visual">
                    <div class="nft-showcase">
                        <div class="nft-card-3d">
                            <div class="nft-card-inner">
                                <img src="../assets/images/nft-1.png" alt="Featured NFT" class="nft-main-image"
                                    id="previewImage">
                                <div class="nft-glow"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="preview-info">
                    <h3 class="preview-title">Koleksi NFT Eksklusif</h3>
                    <p class="preview-text">
                        Setiap NFT memiliki karakteristik unik yang dihasilkan secara acak. NFT Anda akan
                        diungkapkan 48 jam setelah proses minting selesai. Tingkat kelangkaan meliputi:
                        Common (Umum), Rare (Langka), Epic (Epik), dan Legendary (Legendaris)!
                    </p>
                    <div class="mt-3">
                        <div class="d-flex justify-content-around text-center">
                            <div>
                                <div class="text-primary fw-bold fs-4">10.000</div>
                                <small class="text-muted">Total Koleksi</small>
                            </div>
                            <div>
                                <div class="text-primary fw-bold fs-4">150+</div>
                                <small class="text-muted">Trait Unik</small>
                            </div>
                            <div>
                                <div class="text-primary fw-bold fs-4">0.08 ETH</div>
                                <small class="text-muted">Harga Mint</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mint Interface -->
            <div class="mint-interface" data-aos="fade-left" data-aos-delay="200">

                <!-- Wallet Connection -->
                <div class="wallet-section">
                    <h3 class="section-title">
                        <i class="fas fa-wallet me-2"></i> 1. Hubungkan Wallet
                    </h3>
                    <button class="wallet-btn" id="connectWalletBtn" onclick="connectWallet()">
                        <span>
                            <i class="fab fa-ethereum me-2"></i>
                            <span id="walletStatus">Hubungkan MetaMask</span>
                        </span>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Mint Controls -->
                <div class="mint-controls">
                    <h3 class="section-title">
                        <i class="fas fa-sliders-h me-2"></i> 2. Pilih Jumlah
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
                        <small class="text-muted">Maksimal 10 NFT per transaksi</small>
                    </div>

                    <div class="price-info">
                        <div class="price-row">
                            <span class="price-label">Harga per NFT:</span>
                            <span class="price-value">0.08 ETH</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Jumlah:</span>
                            <span class="price-value" id="qtyDisplay">1</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Total Harga:</span>
                            <span class="price-value">
                                <i class="fab fa-ethereum me-1"></i>
                                <span id="totalPrice">0.08</span> ETH
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Mint Button -->
                <button class="mint-btn" id="mintBtn" onclick="mintNFT()" disabled>
                    <i class="fas fa-lock"></i> Hubungkan Wallet Terlebih Dahulu
                </button>

                <!-- FAQ Mini -->
                <div class="faq-section">
                    <h3 class="section-title">
                        <i class="fas fa-question-circle me-2"></i> FAQ Singkat
                    </h3>

                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-chevron-right me-2"></i>
                            Berapa harga mint?
                        </div>
                        <div class="faq-answer">
                            0.08 ETH per NFT. Maksimal 10 NFT per transaksi.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-chevron-right me-2"></i>
                            Kapan reveal-nya?
                        </div>
                        <div class="faq-answer">
                            NFT Anda akan diungkapkan 48 jam setelah mint selesai atau ketika semua 10.000 terjual
                            habis.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <i class="fas fa-chevron-right me-2"></i>
                            Wallet apa yang didukung?
                        </div>
                        <div class="faq-answer">
                            MetaMask, WalletConnect, Coinbase Wallet, dan Phantom semuanya didukung.
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
                    <h3 class="mt-3 mb-2">Selamat!</h3>
                    <p class="text-muted mb-4">NFT Anda berhasil di-mint!</p>
                    <p>Token ID: <strong class="text-primary">#<span id="tokenId">0000</span></strong></p>
                    <hr>
                    <div class="d-grid gap-2 mt-4">
                        <a href="gallery.php" class="btn btn-primary">
                            <i class="fas fa-images me-2"></i> Lihat di Galeri
                        </a>
                        <button class="btn btn-outline-light" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$extra_js = '<script>
    // Mint Configuration
    const MINT_PRICE = 0.08;
    const MAX_QUANTITY = 10;
    let currentQty = 1;
    let walletConnected = false;
    
    // Connect Wallet Function
    function connectWallet() {
        const btn = document.getElementById(\'connectWalletBtn\');
        const mintBtn = document.getElementById(\'mintBtn\');
        
        // Simulate wallet connection
        btn.innerHTML = \'<i class="fas fa-spinner fa-spin me-2"></i> Menghubungkan...\';
        
        setTimeout(() => {
            walletConnected = true;
            btn.classList.add(\'wallet-connected\');
            btn.innerHTML = `
                <span>
                    <i class="fas fa-check-circle me-2"></i>
                    <span class="wallet-address">0x742d...a3f9</span>
                </span>
                <i class="fas fa-power-off"></i>
            `;
            
            mintBtn.disabled = false;
            mintBtn.innerHTML = \'<i class="fas fa-fire me-2"></i> Mint Sekarang\';
            
            // Change onclick to disconnect
            btn.setAttribute(\'onclick\', \'disconnectWallet()\');
        }, 1500);
    }
    
    // Disconnect Wallet
    function disconnectWallet() {
        walletConnected = false;
        const btn = document.getElementById(\'connectWalletBtn\');
        const mintBtn = document.getElementById(\'mintBtn\');
        
        btn.classList.remove(\'wallet-connected\');
        btn.innerHTML = `
            <span>
                <i class="fab fa-ethereum me-2"></i>
                Hubungkan MetaMask
            </span>
            <i class="fas fa-chevron-right"></i>
        `;
        btn.setAttribute(\'onclick\', \'connectWallet()\');
        
        mintBtn.disabled = true;
        mintBtn.innerHTML = \'<i class="fas fa-lock"></i> Hubungkan Wallet Terlebih Dahulu\';
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
        document.getElementById(\'quantity\').textContent = currentQty;
        document.getElementById(\'qtyDisplay\').textContent = currentQty;
        
        const total = (MINT_PRICE * currentQty).toFixed(2);
        document.getElementById(\'totalPrice\').textContent = total;
        
        // Update buttons
        document.getElementById(\'decreaseBtn\').disabled = currentQty <= 1;
        document.getElementById(\'increaseBtn\').disabled = currentQty >= MAX_QUANTITY;
    }
    
    // Mint Function
    function mintNFT() {
        if(!walletConnected) {
            alert(\'Silakan hubungkan wallet Anda terlebih dahulu!\');
            return;
        }
        
        const mintBtn = document.getElementById(\'mintBtn\');
        mintBtn.disabled = true;
        mintBtn.innerHTML = \'<i class="fas fa-spinner fa-spin me-2"></i> Minting...\';
        
        // Simulate minting process
        setTimeout(() => {
            // Generate random token ID
            const tokenId = Math.floor(Math.random() * 10000);
            document.getElementById(\'tokenId\').textContent = String(tokenId).padStart(4, \'0\');
            
            // Show success modal
            const modal = new bootstrap.Modal(document.getElementById(\'successModal\'));
            modal.show();
            
            // Reset button
            mintBtn.disabled = false;
            mintBtn.innerHTML = \'<i class="fas fa-fire me-2"></i> Mint Sekarang\';
        }, 3000);
    }
</script>';
include '../includes/footer.php';
?>
mintBtn.innerHTML = '<i class="fas fa-fire me-2"></i> Mint Sekarang';

// Update minted count
const currentMinted = parseInt(document.getElementById('mintedCount').textContent.replace('.', ''));
const newMinted = currentMinted + currentQty;
document.getElementById('mintedCount').textContent = newMinted.toLocaleString('id-ID');

const progress = (newMinted / 10000) * 100;
document.getElementById('progressBar').style.width = progress + '%';
}, 3000);
}

// Random preview image rotation
const previewImages = [1, 2, 3, 4];
let currentImageIndex = 0;

setInterval(() => {
currentImageIndex = (currentImageIndex + 1) % previewImages.length;
const imgSrc = `../assets/images/nft-${previewImages[currentImageIndex]}.png`;
document.getElementById('previewImage').src = imgSrc;
}, 5000);
</script>

</body>

</html>