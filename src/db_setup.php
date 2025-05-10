<?php
/**
 * Database connection setup
 * Using SQLite for simplicity and portability
 */

require_once('./db_connect.php');

// Create/connect to the SQLite database
try {
    $pdo = db_connect();
    
    // Set error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Display error message if connection fails
    die('Database connection failed: ' . $e->getMessage());
}

/**
 * Helper function to execute SQL queries
 * 
 * @param string $sql SQL query to execute
 * @param array $params Parameters to bind to the query
 * @return PDOStatement The statement after execution
 */
function executeQuery($sql, $params = []) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die('Query execution failed: ' . $e->getMessage());
    }
}
?>
