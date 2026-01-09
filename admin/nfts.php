<?php
/**
 * Admin NFT Management
 * NFT-Verse Dynamic Website
 */

// Include dependencies BEFORE any output
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Require admin access
requireAdmin();

$page_title = 'Kelola NFT';
$admin_page = 'nfts';

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
            $token_id = trim($_POST['token_id'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $rarity = $_POST['rarity'] ?? 'common';
            $price = floatval($_POST['price'] ?? 0.08);
            $rarity_score = floatval($_POST['rarity_score'] ?? 0);
            $image_path = trim($_POST['image_path'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_minted = isset($_POST['is_minted']) ? 1 : 0;
            
            if (empty($token_id) || empty($name) || empty($image_path)) {
                $error = 'Token ID, Nama, dan Image Path wajib diisi.';
            } else {
                try {
                    if ($post_action === 'create') {
                        $stmt = $pdo->prepare("
                            INSERT INTO nfts (token_id, name, rarity, price, rarity_score, image_path, description, is_featured, is_minted)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmt->execute([$token_id, $name, $rarity, $price, $rarity_score, $image_path, $description, $is_featured, $is_minted]);
                        setFlashMessage('success', 'NFT berhasil ditambahkan!');
                        header('Location: nfts.php');
                        exit;
                    } else {
                        $nft_id = (int)$_POST['id'];
                        $stmt = $pdo->prepare("
                            UPDATE nfts SET token_id = ?, name = ?, rarity = ?, price = ?, rarity_score = ?, 
                                image_path = ?, description = ?, is_featured = ?, is_minted = ?
                            WHERE id = ?
                        ");
                        $stmt->execute([$token_id, $name, $rarity, $price, $rarity_score, $image_path, $description, $is_featured, $is_minted, $nft_id]);
                        setFlashMessage('success', 'NFT berhasil diperbarui!');
                        header('Location: nfts.php');
                        exit;
                    }
                } catch (PDOException $e) {
                    $error = 'Token ID sudah digunakan atau terjadi kesalahan.';
                }
            }
        } elseif ($post_action === 'delete') {
            $nft_id = (int)$_POST['id'];
            try {
                $stmt = $pdo->prepare("DELETE FROM nfts WHERE id = ?");
                $stmt->execute([$nft_id]);
                setFlashMessage('success', 'NFT berhasil dihapus!');
                header('Location: nfts.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Gagal menghapus NFT.';
            }
        }
    }
}

// Get NFT for editing
$nft = null;
if ($action === 'edit' && $id > 0) {
    $nft = getNFTById($id);
    if (!$nft) {
        header('Location: nfts.php');
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
    <!-- NFT List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-images me-2"></i>Daftar NFT
            </h3>
            <a href="?action=create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah NFT
            </a>
        </div>
        
        <?php
        $nfts = getNFTs([], 50, 0);
        ?>
        
        <?php if (empty($nfts)): ?>
            <p class="text-muted text-center py-4">Belum ada NFT</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Token ID</th>
                            <th>Nama</th>
                            <th>Rarity</th>
                            <th>Harga</th>
                            <th>Featured</th>
                            <th>Minted</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nfts as $nft): ?>
                            <tr>
                                <td>
                                    <img src="/nft/<?php echo htmlspecialchars($nft['image_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($nft['name']); ?>"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td>#<?php echo htmlspecialchars($nft['token_id']); ?></td>
                                <td><?php echo htmlspecialchars($nft['name']); ?></td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $nft['rarity'] === 'legendary' ? 'warning' : 
                                            ($nft['rarity'] === 'epic' ? 'info' : 
                                            ($nft['rarity'] === 'rare' ? 'success' : 'secondary')); 
                                    ?>">
                                        <?php echo ucfirst($nft['rarity']); ?>
                                    </span>
                                </td>
                                <td><?php echo $nft['price']; ?> ETH</td>
                                <td>
                                    <?php if ($nft['is_featured']): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="fas fa-star text-muted"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($nft['is_minted']): ?>
                                        <span class="badge badge-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $nft['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete(<?php echo $nft['id']; ?>, '<?php echo htmlspecialchars($nft['name']); ?>')">
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
                    <p>Apakah Anda yakin ingin menghapus NFT <strong id="deleteNftName"></strong>?</p>
                </div>
                <div class="modal-footer" style="border-color: rgba(0, 245, 255, 0.1);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="" id="deleteForm" style="display: inline;">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" id="deleteNftId">
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
                <?php echo $action === 'create' ? 'Tambah NFT Baru' : 'Edit NFT'; ?>
            </h3>
            <a href="nfts.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <form method="POST" action="">
            <?php echo csrfField(); ?>
            <input type="hidden" name="action" value="<?php echo $action === 'create' ? 'create' : 'update'; ?>">
            <?php if ($nft): ?>
                <input type="hidden" name="id" value="<?php echo $nft['id']; ?>">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Token ID *</label>
                    <input type="text" name="token_id" class="form-control" required
                           value="<?php echo htmlspecialchars($nft['token_id'] ?? ''); ?>"
                           placeholder="e.g. 0001">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama *</label>
                    <input type="text" name="name" class="form-control" required
                           value="<?php echo htmlspecialchars($nft['name'] ?? ''); ?>"
                           placeholder="e.g. Cyber Samurai">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Rarity</label>
                    <select name="rarity" class="form-select">
                        <option value="common" <?php echo ($nft['rarity'] ?? '') === 'common' ? 'selected' : ''; ?>>Common</option>
                        <option value="rare" <?php echo ($nft['rarity'] ?? '') === 'rare' ? 'selected' : ''; ?>>Rare</option>
                        <option value="epic" <?php echo ($nft['rarity'] ?? '') === 'epic' ? 'selected' : ''; ?>>Epic</option>
                        <option value="legendary" <?php echo ($nft['rarity'] ?? '') === 'legendary' ? 'selected' : ''; ?>>Legendary</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga (ETH)</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0"
                           value="<?php echo $nft['price'] ?? 0.08; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Rarity Score</label>
                    <input type="number" name="rarity_score" class="form-control" step="0.1" min="0" max="100"
                           value="<?php echo $nft['rarity_score'] ?? 0; ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Image Path *</label>
                <input type="text" name="image_path" class="form-control" required
                       value="<?php echo htmlspecialchars($nft['image_path'] ?? 'assets/images/'); ?>"
                       placeholder="e.g. assets/images/nft-1.png">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Deskripsi NFT (opsional)"><?php echo htmlspecialchars($nft['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured"
                               <?php echo ($nft['is_featured'] ?? false) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_featured">Featured (Tampilkan di Homepage)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="is_minted" class="form-check-input" id="is_minted"
                               <?php echo ($nft['is_minted'] ?? false) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_minted">Sudah Di-mint</label>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?php echo $action === 'create' ? 'Simpan' : 'Update'; ?>
                </button>
                <a href="nfts.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php 
$extra_js = '
<script>
    function confirmDelete(id, name) {
        document.getElementById("deleteNftId").value = id;
        document.getElementById("deleteNftName").textContent = name;
        new bootstrap.Modal(document.getElementById("deleteModal")).show();
    }
</script>';
require_once 'includes/admin_footer.php'; 
?>
