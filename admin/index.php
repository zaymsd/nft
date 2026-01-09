<?php
/**
 * Admin Dashboard
 * NFT-Verse Dynamic Website
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$page_title = 'Dashboard';
$admin_page = 'dashboard';

$totalNFTs = countNFTs();
$mintedNFTs = countNFTs(true);
$totalUsers = countUsers();
$mintPrice = getSetting('mint_price', 0.08);

try {
    $stmt = $pdo->query("SELECT t.*, u.username FROM mint_transactions t LEFT JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT 5");
    $recentTransactions = $stmt->fetchAll();
} catch (PDOException $e) {
    $recentTransactions = [];
}

try {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
    $recentUsers = $stmt->fetchAll();
} catch (PDOException $e) {
    $recentUsers = [];
}

require_once 'includes/admin_header.php';
$flash = getFlashMessage();
?>

<?php if ($flash): ?>
    <div class="alert alert-<?php echo $flash['type']; ?>">
        <i class="fas fa-<?php echo $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
        <?php echo htmlspecialchars($flash['message']); ?>
    </div>
<?php endif; ?>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-images"></i></div>
            <div class="stat-value"><?php echo number_format($totalNFTs); ?></div>
            <div class="stat-label">Total NFT</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-fire"></i></div>
            <div class="stat-value"><?php echo number_format($mintedNFTs); ?></div>
            <div class="stat-label">NFT Terjual</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-value"><?php echo number_format($totalUsers); ?></div>
            <div class="stat-label">Total Pengguna</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fab fa-ethereum"></i></div>
            <div class="stat-value"><?php echo $mintPrice; ?></div>
            <div class="stat-label">Harga Mint (ETH)</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-exchange-alt me-2"></i>Transaksi Terbaru</h3>
            </div>
            <?php if (empty($recentTransactions)): ?>
                <p class="text-muted text-center py-4">Belum ada transaksi</p>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransactions as $tx): ?>
                            <tr>
                                <td>#<?php echo $tx['id']; ?></td>
                                <td><?php echo htmlspecialchars($tx['username'] ?? 'Guest'); ?></td>
                                <td><?php echo $tx['eth_amount']; ?> ETH</td>
                                <td><span
                                        class="badge badge-<?php echo $tx['status'] === 'success' ? 'success' : ($tx['status'] === 'pending' ? 'warning' : 'danger'); ?>"><?php echo ucfirst($tx['status']); ?></span>
                                </td>
                                <td><?php echo formatDate($tx['created_at'], 'd M Y H:i'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-user-plus me-2"></i>Pengguna Baru</h3>
                <a href="users.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <?php if (empty($recentUsers)): ?>
                <p class="text-muted text-center py-4">Belum ada pengguna</p>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $user): ?>
                            <tr>
                                <td><i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($user['username']); ?>
                                </td>
                                <td><span
                                        class="badge badge-<?php echo $user['role'] === 'admin' ? 'info' : 'success'; ?>"><?php echo ucfirst($user['role']); ?></span>
                                </td>
                                <td><?php echo formatDate($user['created_at'], 'd M Y'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h3>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <a href="nfts.php?action=create" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah NFT</a>
                <a href="team.php?action=create" class="btn btn-outline-primary"><i
                        class="fas fa-user-plus me-2"></i>Tambah Tim</a>
                <a href="roadmap.php?action=create" class="btn btn-outline-primary"><i
                        class="fas fa-plus-circle me-2"></i>Tambah Roadmap</a>
                <a href="settings.php" class="btn btn-outline-primary"><i class="fas fa-cog me-2"></i>Pengaturan</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/admin_footer.php'; ?>