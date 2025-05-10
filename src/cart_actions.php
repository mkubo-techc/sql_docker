<?php
/**
 * Cart actions handler
 * Handles adding, updating, and removing items from the cart
 */

// Include session manager
require_once 'session_manager.php';

// Require user to be logged in
requireLogin();

// Get the action
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Handle different actions
switch ($action) {
    case 'add':
        addToCart();
        break;
    case 'update':
        updateCart();
        break;
    case 'remove':
        removeFromCart();
        break;
    default:
        // Invalid action, redirect to cart page
        header('Location: cart.php');
        exit;
}

/**
 * Add a product to the cart
 */
function addToCart() {
    // Check if product_id is provided
    if (!isset($_POST['product_id'])) {
        header('Location: index.php');
        exit;
    }
    
    $product_id = (int)$_POST['product_id'];
    $user_id = getCurrentUserId();
    
    // Check if the product exists in the database
    $product = executeQuery(
        "SELECT id FROM products WHERE id = ?",
        [$product_id]
    )->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header('Location: index.php');
        exit;
    }
    
    // Check if the product is already in the cart
    $cart_item = executeQuery(
        "SELECT id, quantity FROM carts WHERE user_id = ? AND product_id = ?",
        [$user_id, $product_id]
    )->fetch(PDO::FETCH_ASSOC);
    
    if ($cart_item) {
        // Update quantity if already in cart
        executeQuery(
            "UPDATE carts SET quantity = quantity + 1 WHERE id = ?",
            [$cart_item['id']]
        );
    } else {
        // Add new item to cart
        executeQuery(
            "INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, 1)",
            [$user_id, $product_id]
        );
    }
    
    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
}

/**
 * Update cart item quantity
 */
function updateCart() {
    // Check if cart_id and quantity are provided
    if (!isset($_POST['cart_id']) || !isset($_POST['quantity'])) {
        header('Location: cart.php');
        exit;
    }
    
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];
    $user_id = getCurrentUserId();
    
    // Ensure quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Update the cart item
    executeQuery(
        "UPDATE carts SET quantity = ? WHERE id = ? AND user_id = ?",
        [$quantity, $cart_id, $user_id]
    );
    
    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
}

/**
 * Remove an item from the cart
 */
function removeFromCart() {
    // Check if cart_id is provided
    if (!isset($_POST['cart_id'])) {
        header('Location: cart.php');
        exit;
    }
    
    $cart_id = (int)$_POST['cart_id'];
    $user_id = getCurrentUserId();
    
    // Remove the cart item
    executeQuery(
        "DELETE FROM carts WHERE id = ? AND user_id = ?",
        [$cart_id, $user_id]
    );
    
    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
}
?>
