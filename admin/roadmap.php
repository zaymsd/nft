<?php
/**
 * Admin Roadmap Management
 * NFT-Verse Dynamic Website
 */

// Include dependencies BEFORE any output
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

// Require admin access
requireAdmin();

$page_title = 'Kelola Roadmap';
$admin_page = 'roadmap';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';
$success = '';

// Handle form submissions BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token tidak valid.';
    } else {
        $post_action = $_POST['action'] ?? '';

        if ($post_action === 'create' || $post_action === 'update') {
            $phase_name = trim($_POST['phase_name'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $status = $_POST['status'] ?? 'upcoming';
            $status_text = trim($_POST['status_text'] ?? '');
            $display_order = (int) ($_POST['display_order'] ?? 0);
            $milestones = array_filter(array_map('trim', $_POST['milestones'] ?? []));

            if (empty($phase_name) || empty($title) || empty($status_text)) {
                $error = 'Phase Name, Title, dan Status Text wajib diisi.';
            } else {
                try {
                    $pdo->beginTransaction();

                    if ($post_action === 'create') {
                        $stmt = $pdo->prepare("
                            INSERT INTO roadmap_phases (phase_name, title, status, status_text, display_order)
                            VALUES (?, ?, ?, ?, ?)
                        ");
                        $stmt->execute([$phase_name, $title, $status, $status_text, $display_order]);
                        $phase_id = $pdo->lastInsertId();
                    } else {
                        $phase_id = (int) $_POST['id'];
                        $stmt = $pdo->prepare("
                            UPDATE roadmap_phases SET phase_name = ?, title = ?, status = ?, status_text = ?, display_order = ?
                            WHERE id = ?
                        ");
                        $stmt->execute([$phase_name, $title, $status, $status_text, $display_order, $phase_id]);

                        // Delete existing milestones
                        $stmt = $pdo->prepare("DELETE FROM roadmap_milestones WHERE phase_id = ?");
                        $stmt->execute([$phase_id]);
                    }

                    // Insert milestones
                    if (!empty($milestones)) {
                        $stmt = $pdo->prepare("INSERT INTO roadmap_milestones (phase_id, milestone_text, display_order) VALUES (?, ?, ?)");
                        foreach ($milestones as $i => $milestone) {
                            if (!empty($milestone)) {
                                $stmt->execute([$phase_id, $milestone, $i + 1]);
                            }
                        }
                    }

                    $pdo->commit();
                    setFlashMessage('success', 'Fase roadmap berhasil ' . ($post_action === 'create' ? 'ditambahkan' : 'diperbarui') . '!');
                    header('Location: roadmap.php');
                    exit;

                } catch (PDOException $e) {
                    $pdo->rollBack();
                    $error = 'Terjadi kesalahan: ' . $e->getMessage();
                }
            }
        } elseif ($post_action === 'delete') {
            $phase_id = (int) $_POST['id'];
            try {
                $stmt = $pdo->prepare("DELETE FROM roadmap_phases WHERE id = ?");
                $stmt->execute([$phase_id]);
                setFlashMessage('success', 'Fase roadmap berhasil dihapus!');
                header('Location: roadmap.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Gagal menghapus fase roadmap.';
            }
        }
    }
}

// Get phase for editing
$phase = null;
if ($action === 'edit' && $id > 0) {
    $phase = getRoadmapPhaseById($id);
    if (!$phase) {
        header('Location: roadmap.php');
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
    <!-- Roadmap List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-road me-2"></i>Daftar Fase Roadmap
            </h3>
            <a href="?action=create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Fase
            </a>
        </div>

        <?php $phases = getRoadmap(); ?>

        <?php if (empty($phases)): ?>
            <p class="text-muted text-center py-4">Belum ada fase roadmap</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Phase</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Milestones</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($phases as $p): ?>
                            <tr>
                                <td><?php echo $p['display_order']; ?></td>
                                <td><?php echo htmlspecialchars($p['phase_name']); ?></td>
                                <td><?php echo htmlspecialchars($p['title']); ?></td>
                                <td>
                                    <span class="badge badge-<?php
                                    echo $p['status'] === 'completed' ? 'success' :
                                        ($p['status'] === 'progress' ? 'warning' : 'info');
                                    ?>">
                                        <?php echo htmlspecialchars($p['status_text']); ?>
                                    </span>
                                </td>
                                <td><?php echo count($p['milestones']); ?> items</td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete(<?php echo $p['id']; ?>, '<?php echo htmlspecialchars($p['phase_name']); ?>')">
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
                    <p>Apakah Anda yakin ingin menghapus fase <strong id="deleteName"></strong>? Semua milestone akan ikut
                        terhapus.</p>
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
                <?php echo $action === 'create' ? 'Tambah Fase Roadmap' : 'Edit Fase Roadmap'; ?>
            </h3>
            <a href="roadmap.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <form method="POST" action="">
            <?php echo csrfField(); ?>
            <input type="hidden" name="action" value="<?php echo $action === 'create' ? 'create' : 'update'; ?>">
            <?php if ($phase): ?>
                <input type="hidden" name="id" value="<?php echo $phase['id']; ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phase Name *</label>
                    <input type="text" name="phase_name" class="form-control" required
                        value="<?php echo htmlspecialchars($phase['phase_name'] ?? ''); ?>" placeholder="e.g. Q1 2024">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control" required
                        value="<?php echo htmlspecialchars($phase['title'] ?? ''); ?>"
                        placeholder="e.g. Genesis - Peluncuran & Komunitas">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="upcoming" <?php echo ($phase['status'] ?? '') === 'upcoming' ? 'selected' : ''; ?>>
                            Upcoming</option>
                        <option value="progress" <?php echo ($phase['status'] ?? '') === 'progress' ? 'selected' : ''; ?>>In
                            Progress</option>
                        <option value="completed" <?php echo ($phase['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>
                            Completed</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status Text *</label>
                    <input type="text" name="status_text" class="form-control" required
                        value="<?php echo htmlspecialchars($phase['status_text'] ?? ''); ?>" placeholder="e.g. Selesai">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="display_order" class="form-control" min="0"
                        value="<?php echo $phase['display_order'] ?? 0; ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Milestones</label>
                <div id="milestonesContainer">
                    <?php
                    $milestones = $phase['milestones'] ?? [];
                    if (empty($milestones))
                        $milestones = [['milestone_text' => '']];
                    foreach ($milestones as $i => $m):
                        ?>
                        <div class="input-group mb-2">
                            <input type="text" name="milestones[]" class="form-control"
                                value="<?php echo htmlspecialchars($m['milestone_text']); ?>" placeholder="Milestone text...">
                            <button type="button" class="btn btn-outline-danger" onclick="removeMilestone(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMilestone()">
                    <i class="fas fa-plus me-2"></i>Tambah Milestone
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?php echo $action === 'create' ? 'Simpan' : 'Update'; ?>
                </button>
                <a href="roadmap.php" class="btn btn-secondary">Batal</a>
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
    
    function addMilestone() {
        const container = document.getElementById("milestonesContainer");
        const html = `
            <div class="input-group mb-2">
                <input type="text" name="milestones[]" class="form-control" placeholder="Milestone text...">
                <button type="button" class="btn btn-outline-danger" onclick="removeMilestone(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML("beforeend", html);
    }
    
    function removeMilestone(btn) {
        btn.closest(".input-group").remove();
    }
</script>';
require_once 'includes/admin_footer.php';
?>