<?php
/**
 * Login page
 */

// Include header
require_once 'header.php';

// Initialize variables
$email = '';
$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validate form data
    if (empty($email) || empty($password)) {
        $error = 'メールアドレスとパスワードを入力してください。';
    } else {
        // Attempt to authenticate user
        if (authenticateUser($email, $password)) {
            // Redirect to index page on successful login
            // header('Location: index.php');
            exit;
        } else {
            $error = 'メールアドレスまたはパスワードが正しくありません。';
        }
    }
}
?>

<div class="form-container">
    <h2 class="form-title">ログイン</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="post" action="login.php">
        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">ログイン</button>
        </div>
    </form>
    
    <p class="text-center">アカウントをお持ちでない方は <a href="register.php">新規登録</a> してください。</p>
</div>

<?php
// Include footer
require_once 'footer.php';
?>
