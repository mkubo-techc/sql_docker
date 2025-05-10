<?php
/**
 * Logout page
 */

// Include session manager
require_once 'session_manager.php';

// Log out the user
logoutUser();

// Redirect to the login page
header('Location: login.php');
exit;
?>
