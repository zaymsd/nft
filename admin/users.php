<?php
/**
 * Admin User Management
 * NFT-Verse Dynamic Website
 */

// Include dependencies BEFORE any output
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Require admin access
requireAdmin();

$page_title = 'Kelola Pengguna';
$admin_page = 'users';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';

// Handle form submissions BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token tidak valid.';
    } else {
        $post_action = $_POST['action'] ?? '';
        
        if ($post_action === 'update') {
            $user_id = (int)$_POST['id'];
            $role = $_POST['role'] ?? 'user';
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            // Prevent self-demotion
            if ($user_id === getCurrentUserId() && $role !== 'admin') {
                $error = 'Anda tidak dapat mengubah role Anda sendiri.';
            } else {
                try {
                    $stmt = $pdo->prepare("UPDATE users SET role = ?, is_active = ? WHERE id = ?");
                    $stmt->execute([$role, $is_active, $user_id]);
                    setFlashMessage('success', 'Pengguna berhasil diperbarui!');
                    header('Location: users.php');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Terjadi kesalahan.';
                }
            }
        } elseif ($post_action === 'delete') {
            $user_id = (int)$_POST['id'];
            
            // Prevent self-deletion
            if ($user_id === getCurrentUserId()) {
                $error = 'Anda tidak dapat menghapus akun Anda sendiri.';
            } else {
                try {
                    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                    $stmt->execute([$user_id]);
                    setFlashMessage('success', 'Pengguna berhasil dihapus!');
                    header('Location: users.php');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Gagal menghapus pengguna.';
                }
            }
        }
    }
}

// Get user for editing
$user = null;
if ($action === 'edit' && $id > 0) {
    $user = getUserById($id);
    if (!$user) {
        header('Location: users.php');
        exit;
    }
}

// Flash message
$flash = getFlashMessage();
if ($flash && !$success) {
    $success = $flash['message'];
}

// Get all users
$users = [];
try {
    $stmt = $pdo->query("SELECT id, username, email, role, wallet_address, is_active, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Gagal mengambil data pengguna.';
}

// NOW include the header (after all redirects are done)
require_once 'includes/admin_header.php';
?>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <!-- User List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-users me-2"></i>Daftar Pengguna
            </h3>
            <span class="badge badge-info"><?php echo count($users); ?> pengguna</span>
        </div>
        
        <?php if (empty($users)): ?>
            <p class="text-muted text-center py-4">Belum ada pengguna</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Wallet</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td>#<?php echo $u['id']; ?></td>
                                <td>
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?php echo htmlspecialchars($u['username']); ?>
                                    <?php if ($u['id'] === getCurrentUserId()): ?>
                                        <span class="badge badge-info">Anda</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $u['role'] === 'admin' ? 'warning' : 'success'; ?>">
                                        <?php echo ucfirst($u['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($u['wallet_address']): ?>
                                        <code><?php echo substr($u['wallet_address'], 0, 8); ?>...</code>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($u['is_active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo formatDate($u['created_at'], 'd M Y'); ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($u['id'] !== getCurrentUserId()): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: var(--card-bg); border: 1px solid rgba(0, 245, 255, 0.2);">
                <div class="modal-header" style="border-color: rgba(0, 245, 255, 0.1);">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus pengguna <strong id="deleteName"></strong>?</p>
                    <p class="text-danger"><small>Semua data terkait pengguna ini akan dihapus.</small></p>
                </div>
                <div class="modal-footer" style="border-color: rgba(0, 245, 255, 0.1);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="" id="deleteForm" style="display: inline;">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" id="deleteId">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($action === 'edit' && $user): ?>
    <!-- Edit Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-edit me-2"></i>Edit Pengguna
            </h3>
            <a href="users.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <form method="POST" action="">
            <?php echo csrfField(); ?>
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" <?php echo $user['id'] === getCurrentUserId() ? 'disabled' : ''; ?>>
                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                    <?php if ($user['id'] === getCurrentUserId()): ?>
                        <small class="text-muted">Anda tidak dapat mengubah role sendiri</small>
                        <input type="hidden" name="role" value="<?php echo $user['role']; ?>">
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Wallet Address</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['wallet_address'] ?? ''); ?>" disabled>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                           <?php echo $user['is_active'] ? 'checked' : ''; ?>
                           <?php echo $user['id'] === getCurrentUserId() ? 'disabled' : ''; ?>>
                    <label class="form-check-label" for="is_active">Akun Aktif</label>
                </div>
                <?php if ($user['id'] === getCurrentUserId()): ?>
                    <input type="hidden" name="is_active" value="1">
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Terdaftar Pada</label>
                <p class="text-muted"><?php echo formatDate($user['created_at'], 'd F Y, H:i'); ?></p>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update
                </button>
                <a href="users.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php 
$extra_js = '
<script>
    function confirmDelete(id, name) {
        document.getElementById("deleteId").value = id;
        document.getElementById("deleteName").textContent = name;
        new bootstrap.Modal(document.getElementById("deleteModal")).show();
    }
</script>';
require_once 'includes/admin_footer.php'; 
?>
