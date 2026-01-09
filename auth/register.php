<?php
/**
 * Register Page
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
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token tidak valid, silakan coba lagi.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $wallet_address = trim($_POST['wallet_address'] ?? '');

        // Validation
        if (empty($username)) {
            $errors['username'] = 'Username wajib diisi.';
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $errors['username'] = 'Username harus 3-50 karakter.';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors['username'] = 'Username hanya boleh huruf, angka, dan underscore.';
        } elseif (getUserByUsername($username)) {
            $errors['username'] = 'Username sudah digunakan.';
        }

        if (empty($email)) {
            $errors['email'] = 'Email wajib diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        } elseif (getUserByEmail($email)) {
            $errors['email'] = 'Email sudah terdaftar.';
        }

        if (empty($password)) {
            $errors['password'] = 'Password wajib diisi.';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password minimal 6 karakter.';
        }

        if ($password !== $password_confirm) {
            $errors['password_confirm'] = 'Konfirmasi password tidak cocok.';
        }

        // If no errors, create user
        if (empty($errors)) {
            global $pdo;

            try {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("
                    INSERT INTO users (username, email, password_hash, wallet_address) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$username, $email, $password_hash, $wallet_address ?: null]);

                setFlashMessage('success', 'Registrasi berhasil! Silakan login.');
                header('Location: login.php');
                exit;

            } catch (PDOException $e) {
                $error = 'Terjadi kesalahan, silakan coba lagi.';
            }
        }
    }
}

$path = '../';
$page_title = 'Daftar - NFT-Verse';
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
        max-width: 500px;
        width: 100%;
        background: var(--card-bg);
        border: 1px solid rgba(0, 245, 255, 0.2);
        border-radius: 30px;
        padding: 3rem;
        backdrop-filter: blur(10px);
        margin: 100px 0;
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
    
    .form-control.is-invalid {
        border-color: #ef4444;
    }
    
    .invalid-feedback {
        color: #fca5a5;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }
    
    .form-text {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin-top: 0.5rem;
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
    
    .password-requirements {
        background: rgba(0, 245, 255, 0.05);
        border: 1px solid rgba(0, 245, 255, 0.1);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .password-requirements h6 {
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .password-requirements ul {
        margin: 0;
        padding-left: 1.2rem;
        color: var(--text-secondary);
        font-size: 0.85rem;
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
                <i class="fas fa-user-plus me-2"></i>Daftar
            </h1>
            <p class="text-muted">Buat akun NFT-Verse baru</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo sanitize($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php echo csrfField(); ?>

            <div class="form-group">
                <label class="form-label">Username *</label>
                <input type="text" name="username"
                    class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>"
                    placeholder="Pilih username Anda" required
                    value="<?php echo sanitize($_POST['username'] ?? ''); ?>">
                <?php if (isset($errors['username'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['username']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email"
                    class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                    placeholder="Masukkan email Anda" required value="<?php echo sanitize($_POST['email'] ?? ''); ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['email']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Password *</label>
                <input type="password" name="password"
                    class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>"
                    placeholder="Buat password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['password']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password *</label>
                <input type="password" name="password_confirm"
                    class="form-control <?php echo isset($errors['password_confirm']) ? 'is-invalid' : ''; ?>"
                    placeholder="Ulangi password" required>
                <?php if (isset($errors['password_confirm'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['password_confirm']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Wallet Address (Opsional)</label>
                <input type="text" name="wallet_address" class="form-control" placeholder="0x..."
                    value="<?php echo sanitize($_POST['wallet_address'] ?? ''); ?>">
                <div class="form-text">Alamat wallet Ethereum Anda untuk minting NFT</div>
            </div>

            <div class="password-requirements">
                <h6><i class="fas fa-shield-alt me-1"></i> Persyaratan Password:</h6>
                <ul>
                    <li>Minimal 6 karakter</li>
                    <li>Disarankan menggunakan kombinasi huruf dan angka</li>
                </ul>
            </div>

            <button type="submit" class="btn-auth">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </button>
        </form>

        <div class="auth-footer">
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>