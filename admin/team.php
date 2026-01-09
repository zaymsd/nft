<?php
/**
 * Admin Team Management
 * NFT-Verse Dynamic Website
 */

// Include dependencies BEFORE any output
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Require admin access
requireAdmin();

$page_title = 'Kelola Tim';
$admin_page = 'team';

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
        
        if ($post_action === 'create' || $post_action === 'update') {
            $name = trim($_POST['name'] ?? '');
            $nickname = trim($_POST['nickname'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            $avatar_url = trim($_POST['avatar_url'] ?? '');
            $twitter_url = trim($_POST['twitter_url'] ?? '');
            $linkedin_url = trim($_POST['linkedin_url'] ?? '');
            $github_url = trim($_POST['github_url'] ?? '');
            $instagram_url = trim($_POST['instagram_url'] ?? '');
            $discord_url = trim($_POST['discord_url'] ?? '');
            $display_order = (int)($_POST['display_order'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            if (empty($name) || empty($role)) {
                $error = 'Nama dan Role wajib diisi.';
            } else {
                try {
                    if ($post_action === 'create') {
                        $stmt = $pdo->prepare("
                            INSERT INTO team_members (name, nickname, role, bio, avatar_url, twitter_url, linkedin_url, github_url, instagram_url, discord_url, display_order, is_active)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmt->execute([$name, $nickname, $role, $bio, $avatar_url, $twitter_url, $linkedin_url, $github_url, $instagram_url, $discord_url, $display_order, $is_active]);
                        setFlashMessage('success', 'Anggota tim berhasil ditambahkan!');
                        header('Location: team.php');
                        exit;
                    } else {
                        $member_id = (int)$_POST['id'];
                        $stmt = $pdo->prepare("
                            UPDATE team_members SET name = ?, nickname = ?, role = ?, bio = ?, avatar_url = ?, 
                                twitter_url = ?, linkedin_url = ?, github_url = ?, instagram_url = ?, discord_url = ?, 
                                display_order = ?, is_active = ?
                            WHERE id = ?
                        ");
                        $stmt->execute([$name, $nickname, $role, $bio, $avatar_url, $twitter_url, $linkedin_url, $github_url, $instagram_url, $discord_url, $display_order, $is_active, $member_id]);
                        setFlashMessage('success', 'Anggota tim berhasil diperbarui!');
                        header('Location: team.php');
                        exit;
                    }
                } catch (PDOException $e) {
                    $error = 'Terjadi kesalahan: ' . $e->getMessage();
                }
            }
        } elseif ($post_action === 'delete') {
            $member_id = (int)$_POST['id'];
            try {
                $stmt = $pdo->prepare("DELETE FROM team_members WHERE id = ?");
                $stmt->execute([$member_id]);
                setFlashMessage('success', 'Anggota tim berhasil dihapus!');
                header('Location: team.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Gagal menghapus anggota tim.';
            }
        }
    }
}

// Get member for editing
$member = null;
if ($action === 'edit' && $id > 0) {
    $member = getTeamMemberById($id);
    if (!$member) {
        header('Location: team.php');
        exit;
    }
}

// Flash message
$flash = getFlashMessage();
if ($flash && !$success) {
    $success = $flash['message'];
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
    <!-- Team List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-users me-2"></i>Daftar Anggota Tim
            </h3>
            <a href="?action=create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Anggota
            </a>
        </div>
        
        <?php $members = getTeamMembers(false); ?>
        
        <?php if (empty($members)): ?>
            <p class="text-muted text-center py-4">Belum ada anggota tim</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $m): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($m['avatar_url'] ?: 'https://i.pravatar.cc/100'); ?>" 
                                         alt="<?php echo htmlspecialchars($m['name']); ?>"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($m['name']); ?>
                                    <?php if ($m['nickname']): ?>
                                        <small class="text-muted d-block">"<?php echo htmlspecialchars($m['nickname']); ?>"</small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($m['role']); ?></td>
                                <td><?php echo $m['display_order']; ?></td>
                                <td>
                                    <?php if ($m['is_active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete(<?php echo $m['id']; ?>, '<?php echo htmlspecialchars($m['name']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
                    <p>Apakah Anda yakin ingin menghapus <strong id="deleteName"></strong>?</p>
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

<?php elseif ($action === 'create' || $action === 'edit'): ?>
    <!-- Create/Edit Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-<?php echo $action === 'create' ? 'plus' : 'edit'; ?> me-2"></i>
                <?php echo $action === 'create' ? 'Tambah Anggota Tim' : 'Edit Anggota Tim'; ?>
            </h3>
            <a href="team.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <form method="POST" action="">
            <?php echo csrfField(); ?>
            <input type="hidden" name="action" value="<?php echo $action === 'create' ? 'create' : 'update'; ?>">
            <?php if ($member): ?>
                <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" required
                           value="<?php echo htmlspecialchars($member['name'] ?? ''); ?>"
                           placeholder="e.g. John Doe">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nickname</label>
                    <input type="text" name="nickname" class="form-control"
                           value="<?php echo htmlspecialchars($member['nickname'] ?? ''); ?>"
                           placeholder="e.g. CryptoKing">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role *</label>
                    <input type="text" name="role" class="form-control" required
                           value="<?php echo htmlspecialchars($member['role'] ?? ''); ?>"
                           placeholder="e.g. Lead Developer">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Avatar URL</label>
                    <input type="url" name="avatar_url" class="form-control"
                           value="<?php echo htmlspecialchars($member['avatar_url'] ?? ''); ?>"
                           placeholder="https://...">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3"
                          placeholder="Biografi singkat..."><?php echo htmlspecialchars($member['bio'] ?? ''); ?></textarea>
            </div>
            
            <h5 class="mb-3">Social Links</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fab fa-twitter me-2"></i>Twitter</label>
                    <input type="url" name="twitter_url" class="form-control"
                           value="<?php echo htmlspecialchars($member['twitter_url'] ?? ''); ?>"
                           placeholder="https://twitter.com/...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fab fa-linkedin me-2"></i>LinkedIn</label>
                    <input type="url" name="linkedin_url" class="form-control"
                           value="<?php echo htmlspecialchars($member['linkedin_url'] ?? ''); ?>"
                           placeholder="https://linkedin.com/in/...">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fab fa-github me-2"></i>GitHub</label>
                    <input type="url" name="github_url" class="form-control"
                           value="<?php echo htmlspecialchars($member['github_url'] ?? ''); ?>"
                           placeholder="https://github.com/...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fab fa-instagram me-2"></i>Instagram</label>
                    <input type="url" name="instagram_url" class="form-control"
                           value="<?php echo htmlspecialchars($member['instagram_url'] ?? ''); ?>"
                           placeholder="https://instagram.com/...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fab fa-discord me-2"></i>Discord</label>
                    <input type="url" name="discord_url" class="form-control"
                           value="<?php echo htmlspecialchars($member['discord_url'] ?? ''); ?>"
                           placeholder="https://discord.gg/...">
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="display_order" class="form-control" min="0"
                           value="<?php echo $member['display_order'] ?? 0; ?>">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                               <?php echo ($member['is_active'] ?? true) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?php echo $action === 'create' ? 'Simpan' : 'Update'; ?>
                </button>
                <a href="team.php" class="btn btn-secondary">Batal</a>
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
