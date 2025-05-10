<?php
/**
 * Registration page
 */

// Include header
require_once 'header.php';

// Initialize variables
$name = '';
$email = '';
$error = '';
$success = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = '全ての項目を入力してください。';
    } elseif ($password !== $confirm_password) {
        $error = 'パスワードが一致しません。';
    } elseif (strlen($password) < 6) {
        $error = 'パスワードは6文字以上で入力してください。';
    } else {
        // Attempt to register user
        $result = registerUser($name, $email, $password);
        
        if ($result === true) {
            // Registration successful
            $success = '登録が完了しました。ログインしてください。';
            // Clear form data
            $name = '';
            $email = '';
        } else {
            // Registration failed
            $error = $result; // Error message from registerUser function
        }
    }
}
?>

<div class="form-container">
    <h2 class="form-title">新規登録</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <p class="text-center"><a href="login.php" class="btn btn-primary">ログインページへ</a></p>
    <?php else: ?>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="name" class="form-label">名前</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <small class="form-text text-muted">6文字以上で入力してください</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password" class="form-label">パスワード（確認）</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">登録する</button>
            </div>
        </form>
        
        <p class="text-center">すでにアカウントをお持ちの方は <a href="login.php">ログイン</a> してください。</p>
    <?php endif; ?>
</div>

<?php
// Include footer
require_once 'footer.php';
?>
