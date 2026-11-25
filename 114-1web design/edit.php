<?php
// edit.php

// 1. 取得網址列傳過來的 ID
$id = $_GET['id'] ?? '';

// 2. 準備所有可能的資料來源
$base_products = [
    ['id' => 33, 'name' => 'MSI GeForce RTX™ 5090 32G', 'cat' => 'GPU', 'price' => 96000, 'stock' => 0, 'status' => '缺貨中'],
    ['id' => 32, 'name' => '聯力 Hydroshift LCD 360N 水冷', 'cat' => 'Cooling', 'price' => 4000, 'stock' => 3, 'status' => '有現貨'],
    ['id' => 30, 'name' => 'Trident Z Royal 32G(16*2)', 'cat' => 'RAM', 'price' => 5490, 'stock' => 2, 'status' => '有現貨'],
    ['id' => 29, 'name' => 'samsung 9100 pro 1TB', 'cat' => 'SSD', 'price' => 7000, 'stock' => 30, 'status' => '有現貨'],
    ['id' => 28, 'name' => 'Core ultra 9 285k', 'cat' => 'CPU', 'price' => 11000, 'stock' => 15, 'status' => '有現貨'],
    ['id' => 27, 'name' => 'H9 Flow', 'cat' => 'Case', 'price' => 4990, 'stock' => 15, 'status' => '有現貨'],
    ['id' => 26, 'name' => 'Torrent White TG', 'cat' => 'Case', 'price' => 6500, 'stock' => 8, 'status' => '有現貨']
];

$added_items = isset($_COOKIE['added_items']) ? json_decode($_COOKIE['added_items'], true) : [];

// 合併所有資料
$all_products = array_merge($added_items, $base_products);

// 3. 關鍵修正：定義 $item 為空，然後開始搜尋
$item = null; 

foreach ($all_products as $p) {
    if ($p['id'] == $id) {
        $item = $p; // 找到了，把資料存進 $item
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>修改零件資訊 - SmartStock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container card shadow p-4" style="max-width: 500px;">
        <h4 class="mb-4">🛠️ 修改零件資訊</h4>
        <hr>
        
        <?php if ($item): ?>
            <form action="save_action.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <input type="hidden" name="cat" value="<?= $item['cat'] ?>"> <div class="mb-3">
                    <label class="form-label text-muted">零件名稱 (不可修改)</label>
                    <input type="text" name="name" class="form-control bg-light" value="<?= $item['name'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">價格</label>
                    <input type="number" name="price" class="form-control" value="<?= $item['price'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">庫存數量</label>
                    <input type="number" name="stock" class="form-control" value="<?= $item['stock'] ?>" required>
                </div>

               
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <a href="index.php" class="btn btn-secondary">返回列表</a>
                    <button type="submit" class="btn btn-success px-4">儲存修改</button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                系統錯誤：找不到 ID 為 <?= htmlspecialchars($id) ?> 的零件資料。
            </div>
            <a href="index.php" class="btn btn-primary w-100">返回首頁</a>
        <?php endif; ?>
    </div>
</body>
</html>