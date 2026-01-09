<?php
/**
 * Admin Settings
 * NFT-Verse Dynamic Website
 */

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$page_title = 'Pengaturan';
$admin_page = 'settings';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token tidak valid.';
    } else {
        try {
            $settings = [
                'mint_price' => $_POST['mint_price'] ?? '0.08',
                'total_supply' => $_POST['total_supply'] ?? '10000',
                'minted_count' => $_POST['minted_count'] ?? '0',
                'max_per_transaction' => $_POST['max_per_transaction'] ?? '10',
                'countdown_date' => $_POST['countdown_date'] ?? '',
                'discord_url' => $_POST['discord_url'] ?? '',
                'twitter_url' => $_POST['twitter_url'] ?? '',
                'instagram_url' => $_POST['instagram_url'] ?? '',
                'site_name' => $_POST['site_name'] ?? 'NFT-Verse',
                'site_description' => $_POST['site_description'] ?? '',
            ];
            $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
            foreach ($settings as $key => $value) {
                $stmt->execute([$value, $key]);
            }
            setFlashMessage('success', 'Pengaturan berhasil disimpan!');
            header('Location: settings.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan.';
        }
    }
}

$settings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (PDOException $e) {
}

$flash = getFlashMessage();
if ($flash)
    $success = $flash['type'] === 'success' ? $flash['message'] : '';

require_once 'includes/admin_header.php';
?>

<?php if ($error): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?php echo $success; ?></div>
<?php endif; ?>

<form method="POST">
    <?php echo csrfField(); ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-fire me-2"></i>Pengaturan Mint</h3>
                </div>
                <div class="mb-3"><label class="form-label">Harga Mint (ETH)</label><input type="number"
                        name="mint_price" class="form-control" step="0.001"
                        value="<?php echo htmlspecialchars($settings['mint_price'] ?? '0.08'); ?>"></div>
                <div class="mb-3"><label class="form-label">Total Supply</label><input type="number" name="total_supply"
                        class="form-control"
                        value="<?php echo htmlspecialchars($settings['total_supply'] ?? '10000'); ?>"></div>
                <div class="mb-3"><label class="form-label">Sudah Di-mint</label><input type="number"
                        name="minted_count" class="form-control"
                        value="<?php echo htmlspecialchars($settings['minted_count'] ?? '0'); ?>"></div>
                <div class="mb-3"><label class="form-label">Max per Transaksi</label><input type="number"
                        name="max_per_transaction" class="form-control"
                        value="<?php echo htmlspecialchars($settings['max_per_transaction'] ?? '10'); ?>"></div>
                <div class="mb-3"><label class="form-label">Countdown Date</label><input type="datetime-local"
                        name="countdown_date" class="form-control"
                        value="<?php echo !empty($settings['countdown_date']) ? date('Y-m-d\TH:i', strtotime($settings['countdown_date'])) : ''; ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-globe me-2"></i>Website</h3>
                </div>
                <div class="mb-3"><label class="form-label">Nama Website</label><input type="text" name="site_name"
                        class="form-control"
                        value="<?php echo htmlspecialchars($settings['site_name'] ?? 'NFT-Verse'); ?>"></div>
                <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="site_description"
                        class="form-control"
                        rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea></div>
            </div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title"><i class="fas fa-share-alt me-2"></i>Social Media</h3>
                </div>
                <div class="mb-3"><label class="form-label"><i class="fab fa-discord me-2"></i>Discord</label><input
                        type="url" name="discord_url" class="form-control"
                        value="<?php echo htmlspecialchars($settings['discord_url'] ?? ''); ?>"></div>
                <div class="mb-3"><label class="form-label"><i class="fab fa-twitter me-2"></i>Twitter</label><input
                        type="url" name="twitter_url" class="form-control"
                        value="<?php echo htmlspecialchars($settings['twitter_url'] ?? ''); ?>"></div>
                <div class="mb-3"><label class="form-label"><i class="fab fa-instagram me-2"></i>Instagram</label><input
                        type="url" name="instagram_url" class="form-control"
                        value="<?php echo htmlspecialchars($settings['instagram_url'] ?? ''); ?>"></div>
            </div>
        </div>
    </div>
    <div class="mt-4"><button type="submit" class="btn btn-primary btn-lg"><i
                class="fas fa-save me-2"></i>Simpan</button></div>
</form>
<?php require_once 'includes/admin_footer.php'; ?>