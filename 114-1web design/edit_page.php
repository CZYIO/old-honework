<?php
// edit_page.php
$target_id = $_GET['id'] ?? '';
$found_item = null;

// 從 Cookie 讀取目前所有的資料（包含新增的與原本的）
$added_items = isset($_COOKIE['added_items']) ? json_decode($_COOKIE['added_items'], true) : [];
$base_products = [
    ['id' => 33, 'name' => 'MSI GeForce RTX™ 5090', 'cat' => 'GPU', 'price' => 96000],
    ['id' => 32, 'name' => '聯力 Hydroshift LCD 360N', 'cat' => '風扇', 'price' => 4000]
];
$all_products = array_merge($added_items, $base_products);

// 尋找要編輯的那一筆
foreach ($all_products as $p) {
    if ($p['id'] == $target_id) {
        $found_item = $p;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>編輯零件 - SmartStock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container card shadow p-4" style="max-width: 500px;">
        <h3>編輯零件資料</h3>
        <hr>
        <?php if ($found_item): ?>
            <form action="save_action.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= $found_item['id'] ?>">
                
                <label class="form-label">零件名稱</label>
                <input type="text" name="name" class="form-control mb-3" value="<?= $found_item['name'] ?>">
                
                <label class="form-label">價格</label>
                <input type="number" name="price" class="form-control mb-3" value="<?= $found_item['price'] ?>">
                
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">取消</a>
                    <button type="submit" class="btn btn-primary">儲存修改</button>
                </div>
            </form>
        <?php else: ?>
            <p class="text-danger">找不到該零件資料</p>
            <a href="index.php">回首頁</a>
        <?php endif; ?>
    </div>
</body>
</html>