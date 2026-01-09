<?php
/**
 * Logout Handler
 * NFT-Verse Dynamic Website
 */

require_once '../includes/session.php';

// Destroy session
destroyLoginSession();

// Redirect to homepage
header('Location: /nft/index.php');
exit;
