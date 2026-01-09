<?php
/**
 * Login Page
 * NFT-Verse Dynamic Website
 */

require_once '../includes/session.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: /nft/index.php');
    exit;
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token tidak valid, silakan coba lagi.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = 'Email dan password wajib diisi.';
        } else {
            $user = getUserByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                if (!$user['is_active']) {
                    $error = 'Akun Anda telah dinonaktifkan.';
                } else {
                    // Login success
                    setLoginSession($user);
                    setFlashMessage('success', 'Selamat datang kembali, ' . $user['username'] . '!');

                    // Redirect to intended URL or homepage
                    $redirect = $_SESSION['redirect_url'] ?? '/nft/index.php';
                    unset($_SESSION['redirect_url']);
                    header('Location: ' . $redirect);
                    exit;
                }
            } else {
                $error = 'Email atau password salah.';
            }
        }
    }
}

// Check for flash message from registration
$flash = getFlashMessage();
if ($flash && $flash['type'] === 'success') {
    $success = $flash['message'];
}

$path = '../';
$page_title = 'Login - NFT-Verse';
$active_tab = '';
$extra_css = '
<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .auth-container {
        max-width: 450px;
        width: 100%;
        background: var(--card-bg);
        border: 1px solid rgba(0, 245, 255, 0.2);
        border-radius: 30px;
        padding: 3rem;
        backdrop-filter: blur(10px);
    }
    
    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .auth-header h1 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        width: 100%;
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.3);
        border: 2px solid rgba(0, 245, 255, 0.2);
        border-radius: 15px;
        color: var(--text-primary);
        font-size: 1rem;
        transition: var(--transition);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 20px rgba(0, 245, 255, 0.2);
    }
    
    .btn-auth {
        width: 100%;
        padding: 1rem;
        background: var(--gradient-1);
        border: none;
        border-radius: 15px;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .btn-auth:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        color: var(--text-secondary);
    }
    
    .auth-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.5);
        color: #fca5a5;
    }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.2);
        border: 1px solid rgba(16, 185, 129, 0.5);
        color: #6ee7b7;
    }
    
    .back-home {
        position: absolute;
        top: 2rem;
        left: 2rem;
        color: var(--text-secondary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
    }
    
    .back-home:hover {
        color: var(--primary-color);
    }
</style>';

include '../includes/header.php';
?>

<section class="auth-page">
    <a href="../index.php" class="back-home">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="auth-container" data-aos="zoom-in">
        <div class="auth-header">
            <h1 class="gradient-text">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </h1>
            <p class="text-muted">Masuk ke akun NFT-Verse Anda</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo sanitize($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo sanitize($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php echo csrfField(); ?>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required
                    value="<?php echo sanitize($_POST['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-auth">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>

        <div class="auth-footer">
            <p>Belum punya akun? <a href="register.php">Daftar Sekarang</a></p>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>