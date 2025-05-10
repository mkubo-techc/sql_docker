<?php
// Include session manager to check login status
require_once 'session_manager.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教材ECサイト</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="site-title"><a href="index.php">教材ECサイト</a></h1>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">商品一覧</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="cart.php">カート</a></li>
                        <li class="user-info">
                            ようこそ、<?php echo htmlspecialchars(getCurrentUserName()); ?>さん
                            <a href="logout.php" class="logout-btn">ログアウト</a>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php">ログイン</a></li>
                        <li><a href="register.php">新規登録</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
        <!-- Page content will be inserted here -->
