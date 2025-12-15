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
                    <li><a href="<?php echo $path; ?>index.php">Beranda</a></li>
                    <li><a href="<?php echo $path; ?>pages/roadmap.php">Peta Jalan</a></li>
                    <li><a href="<?php echo $path; ?>pages/gallery.php">Galeri</a></li>
                    <li><a href="<?php echo $path; ?>pages/team.php">Tim</a></li>
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
<script src="<?php echo $path; ?>assets/js/main.js"></script>

<?php if (isset($extra_js))
    echo $extra_js; ?>

</body>

</html>