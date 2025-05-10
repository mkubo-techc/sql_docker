<?php
/**
 * Cart page
 * Displays the user's cart and allows them to update quantities or remove items
 */

// Include header
require_once 'header.php';

// Require user to be logged in
requireLogin();

// Get user's cart items with product details using JOIN
$sql = "
    SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.description
    FROM carts c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
    ORDER BY c.created_at DESC
";

$cart_items = executeQuery($sql, [getCurrentUserId()])->fetchAll(PDO::FETCH_ASSOC);

// Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<h2>ショッピングカート</h2>

<?php if (empty($cart_items)): ?>
    <p>カートに商品がありません。</p>
    <p><a href="index.php" class="btn btn-primary">商品一覧に戻る</a></p>
<?php else: ?>
    <div class="cart-container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>数量</th>
                    <th>小計</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td data-label="商品名"><?php echo htmlspecialchars($item['name']); ?></td>
                        <td data-label="価格">¥<?php echo number_format($item['price']); ?></td>
                        <td data-label="数量">
                            <form action="cart_actions.php" method="post" class="quantity-form">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="cart-quantity">
                                <button type="submit" class="btn btn-sm">更新</button>
                            </form>
                        </td>
                        <td data-label="小計">¥<?php echo number_format($item['price'] * $item['quantity']); ?></td>
                        <td data-label="操作">
                            <form action="cart_actions.php" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <button type="submit" class="btn btn-sm">削除</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="cart-total">
            合計金額: ¥<?php echo number_format($total_price); ?>
        </div>
        
        <div class="cart-actions">
            <a href="index.php" class="btn">買い物を続ける</a>
            
            <!-- In a real e-commerce site, this would link to a checkout page -->
            <button class="btn btn-primary" onclick="alert('この教材用ECサイトでは、実際の決済処理は実装されていません。')">
                注文手続きへ
            </button>
        </div>
    </div>
    
    <!-- Educational notes section -->
    <div class="educational-notes" style="margin-top: 3rem; padding: 1rem; background-color: #f8f9fa; border-radius: 8px;">
        <h3>学習ポイント</h3>
        <ul>
            <li>カートページでは、JOINを使用して複数のテーブル（carts と products）からデータを取得しています。</li>
            <li>数量の更新と商品の削除には、それぞれ別のフォームとPOSTリクエストを使用しています。</li>
            <li>小計と合計金額は、サーバーサイド（PHP）で計算しています。</li>
            <li>実際のECサイトでは、この後に決済処理や注文確定のプロセスが続きます。</li>
        </ul>
        
        <h4>実装されているSQL例:</h4>
        <pre style="background-color: #f1f1f1; padding: 1rem; overflow-x: auto;">
SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.description
FROM carts c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = ?
ORDER BY c.created_at DESC</pre>
    </div>
<?php endif; ?>

<?php
// Include footer
require_once 'footer.php';
?>
