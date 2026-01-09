<?php
/**
 * Common Functions
 * NFT-Verse Dynamic Website
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Sanitize input
 * @param string $input Input string
 * @return string
 */
function sanitize($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Get setting value from database
 * @param string $key Setting key
 * @param mixed $default Default value if not found
 * @return mixed
 */
function getSetting($key, $default = null)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT setting_value, setting_type FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();

        if ($result) {
            $value = $result['setting_value'];
            switch ($result['setting_type']) {
                case 'number':
                    return is_numeric($value) ? (strpos($value, '.') !== false ? (float) $value : (int) $value) : $default;
                case 'boolean':
                    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
                case 'json':
                    return json_decode($value, true);
                default:
                    return $value;
            }
        }
        return $default;
    } catch (PDOException $e) {
        return $default;
    }
}

/**
 * Update setting value
 * @param string $key Setting key
 * @param mixed $value New value
 * @return bool
 */
function updateSetting($key, $value)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        return $stmt->execute([$value, $key]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Get all NFTs with optional filters
 * @param array $filters Filter options
 * @param int $limit Limit
 * @param int $offset Offset
 * @return array
 */
function getNFTs($filters = [], $limit = 24, $offset = 0)
{
    global $pdo;

    $where = [];
    $params = [];

    if (!empty($filters['rarity'])) {
        $where[] = "rarity = ?";
        $params[] = $filters['rarity'];
    }

    if (!empty($filters['is_featured'])) {
        $where[] = "is_featured = 1";
    }

    if (!empty($filters['is_minted'])) {
        $where[] = "is_minted = ?";
        $params[] = $filters['is_minted'];
    }

    if (!empty($filters['search'])) {
        $where[] = "(name LIKE ? OR token_id LIKE ?)";
        $searchTerm = '%' . $filters['search'] . '%';
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql = "SELECT * FROM nfts {$whereClause} ORDER BY id DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

/**
 * Get featured NFTs
 * @param int $limit Limit
 * @return array
 */
function getFeaturedNFTs($limit = 4)
{
    return getNFTs(['is_featured' => true], $limit);
}

/**
 * Get NFT by ID
 * @param int $id NFT ID
 * @return array|null
 */
function getNFTById($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM nfts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

/**
 * Get NFT traits
 * @param int $nftId NFT ID
 * @return array
 */
function getNFTTraits($nftId)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM nft_traits WHERE nft_id = ? ORDER BY display_order");
    $stmt->execute([$nftId]);
    return $stmt->fetchAll();
}

/**
 * Get all team members
 * @param bool $activeOnly Get only active members
 * @return array
 */
function getTeamMembers($activeOnly = true)
{
    global $pdo;

    $where = $activeOnly ? "WHERE is_active = 1" : "";
    $stmt = $pdo->query("SELECT * FROM team_members {$where} ORDER BY display_order");
    return $stmt->fetchAll();
}

/**
 * Get team member by ID
 * @param int $id Member ID
 * @return array|null
 */
function getTeamMemberById($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM team_members WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

/**
 * Get roadmap with milestones
 * @return array
 */
function getRoadmap()
{
    global $pdo;

    $phases = $pdo->query("SELECT * FROM roadmap_phases ORDER BY display_order")->fetchAll();

    foreach ($phases as &$phase) {
        $stmt = $pdo->prepare("SELECT * FROM roadmap_milestones WHERE phase_id = ? ORDER BY display_order");
        $stmt->execute([$phase['id']]);
        $phase['milestones'] = $stmt->fetchAll();
    }

    return $phases;
}

/**
 * Get roadmap phase by ID
 * @param int $id Phase ID
 * @return array|null
 */
function getRoadmapPhaseById($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM roadmap_phases WHERE id = ?");
    $stmt->execute([$id]);
    $phase = $stmt->fetch();

    if ($phase) {
        $stmt = $pdo->prepare("SELECT * FROM roadmap_milestones WHERE phase_id = ? ORDER BY display_order");
        $stmt->execute([$id]);
        $phase['milestones'] = $stmt->fetchAll();
    }

    return $phase ?: null;
}

/**
 * Get user by ID
 * @param int $id User ID
 * @return array|null
 */
function getUserById($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT id, username, email, role, wallet_address, avatar_url, is_active, created_at FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

/**
 * Get user by email
 * @param string $email User email
 * @return array|null
 */
function getUserByEmail($email)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch() ?: null;
}

/**
 * Get user by username
 * @param string $username Username
 * @return array|null
 */
function getUserByUsername($username)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch() ?: null;
}

/**
 * Count total NFTs
 * @param bool $mintedOnly Count only minted
 * @return int
 */
function countNFTs($mintedOnly = false)
{
    global $pdo;

    $where = $mintedOnly ? "WHERE is_minted = 1" : "";
    $stmt = $pdo->query("SELECT COUNT(*) FROM nfts {$where}");
    return (int) $stmt->fetchColumn();
}

/**
 * Count total users
 * @return int
 */
function countUsers()
{
    global $pdo;

    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    return (int) $stmt->fetchColumn();
}

/**
 * Format ETH price
 * @param float $price Price in ETH
 * @return string
 */
function formatETH($price)
{
    return number_format($price, 2) . ' ETH';
}

/**
 * Format date to Indonesian
 * @param string $date Date string
 * @param string $format Format
 * @return string
 */
function formatDate($date, $format = 'd M Y')
{
    $months = [
        'Jan' => 'Jan',
        'Feb' => 'Feb',
        'Mar' => 'Mar',
        'Apr' => 'Apr',
        'May' => 'Mei',
        'Jun' => 'Jun',
        'Jul' => 'Jul',
        'Aug' => 'Agu',
        'Sep' => 'Sep',
        'Oct' => 'Okt',
        'Nov' => 'Nov',
        'Dec' => 'Des'
    ];

    $formatted = date($format, strtotime($date));
    return strtr($formatted, $months);
}

/**
 * Add newsletter subscriber
 * @param string $email Email address
 * @return bool|string True on success, error message on failure
 */
function subscribeNewsletter($email)
{
    global $pdo;

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        return 'Email tidak valid';
    }

    try {
        // Check if already exists
        $stmt = $pdo->prepare("SELECT id, is_subscribed FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        $existing = $stmt->fetch();

        if ($existing) {
            if ($existing['is_subscribed']) {
                return 'Email sudah terdaftar';
            }
            // Resubscribe
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET is_subscribed = 1, unsubscribed_at = NULL WHERE id = ?");
            $stmt->execute([$existing['id']]);
            return true;
        }

        // New subscriber
        $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
        $stmt->execute([$email]);
        return true;

    } catch (PDOException $e) {
        return 'Terjadi kesalahan, coba lagi';
    }
}

/**
 * Record mint transaction
 * @param array $data Transaction data
 * @return int|false Transaction ID or false on failure
 */
function recordMintTransaction($data)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("
            INSERT INTO mint_transactions (user_id, nft_id, wallet_address, eth_amount, quantity, transaction_hash, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['user_id'] ?? null,
            $data['nft_id'] ?? null,
            $data['wallet_address'],
            $data['eth_amount'],
            $data['quantity'] ?? 1,
            $data['transaction_hash'] ?? null,
            $data['status'] ?? 'pending'
        ]);

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Create a URL-friendly slug
 * @param string $string Input string
 * @return string
 */
function slugify($string)
{
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}
