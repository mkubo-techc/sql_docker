<?php
/**
 * Index page - Product listing
 */

// Include header
require_once 'header.php';

// Get all products from the database
$sql = "SELECT * FROM products ORDER BY id DESC";
$products = executeQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>商品一覧</h2>

<?php if (empty($products)): ?>
    <p>商品がありません。</p>
<?php else: ?>
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="product-price">¥<?php echo number_format($product['price']); ?></p>
                    <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <?php if (isLoggedIn()): ?>
                        <form action="cart_actions.php" method="post">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-primary">カートに追加</button>
                        </form>
                    <?php else: ?>
                        <p><a href="login.php">ログイン</a>するとカートに追加できます</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
// Include footer
require_once 'footer.php';
?>
