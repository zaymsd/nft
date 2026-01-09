<?php
/**
 * Session Handler
 * NFT-Verse Dynamic Website
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user is admin
 * @return bool
 */
function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Get current user ID
 * @return int|null
 */
function getCurrentUserId()
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current username
 * @return string|null
 */
function getCurrentUsername()
{
    return $_SESSION['username'] ?? null;
}

/**
 * Get current user email
 * @return string|null
 */
function getCurrentUserEmail()
{
    return $_SESSION['email'] ?? null;
}

/**
 * Require user to be logged in
 * Redirects to login page if not authenticated
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: /nft/auth/login.php');
        exit;
    }
}

/**
 * Require user to be admin
 * Redirects to homepage if not admin
 */
function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini.';
        header('Location: /nft/index.php');
        exit;
    }
}

/**
 * Set login session
 * @param array $user User data from database
 */
function setLoginSession($user)
{
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['wallet_address'] = $user['wallet_address'] ?? null;
    $_SESSION['logged_in_at'] = time();
}

/**
 * Destroy login session
 */
function destroyLoginSession()
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

/**
 * Set flash message
 * @param string $type Message type (success, error, warning, info)
 * @param string $message Message content
 */
function setFlashMessage($type, $message)
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 * @return array|null
 */
function getFlashMessage()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Generate CSRF token
 * @return string
 */
function generateCSRFToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token Token to verify
 * @return bool
 */
function verifyCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF input field HTML
 * @return string
 */
function csrfField()
{
    return '<input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">';
}
