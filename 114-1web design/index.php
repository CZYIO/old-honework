<?php
// --- 1. 定義基礎資料 (原本 SQL 裡的資料，即便 MySQL 壞了也會顯示) ---
$base_products = [
    ['id' => 33, 'name' => 'MSI GeForce RTX™ 5090 32G', 'cat' => 'GPU', 'price' => 96000, 'stock' => 0],
    ['id' => 32, 'name' => '聯力 Hydroshift LCD 360N 水冷', 'cat' => 'Cooling', 'price' => 4000, 'stock' => 3],
    ['id' => 30, 'name' => 'Trident Z Royal 32G(16*2)', 'cat' => 'RAM', 'price' => 5490, 'stock' => 2],
    ['id' => 28, 'name' => 'Core ultra 9 285k', 'cat' => 'CPU', 'price' => 11000, 'stock' => 15]
];

// --- 2. 讀取 Cookie (取得新增或修改過的動態資料) ---
$added_items = isset($_COOKIE['added_items']) ? json_decode($_COOKIE['added_items'], true) : [];

// --- 3. 處理「更新」與「基礎資料」的優先順序 ---
// 如果基礎資料被修改過，它會存在 added_items 裡，我們要排除原本的
$final_list = $added_items;
foreach ($base_products as $base) {
    $is_modified = false;
    foreach ($added_items as $added) {
        if ($added['id'] == $base['id']) {
            $is_modified = true;
            break;
        }
    }
    if (!$is_modified) {
        $final_list[] = $base;
    }
}

// --- 4. 處理「刪除」標記 ---
$deleted_ids = [];
foreach ($_COOKIE as $key => $value) {
    if (strpos($key, 'del_') === 0) {
        $deleted_ids[] = (int)str_replace('del_', '', $key);
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>SmartStock | 管理系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; padding: 40px; }
        .main-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .deleted-row { display: none !important; }
    </style>
</head>
<body>

<div class="container main-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>🛒 零件庫存清單 </h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ 新增零件</button>
    </div>

    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th><th>名稱</th><th>分類</th><th>價格</th><th>庫存</th><th>狀態</th><th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($final_list as $p): ?>
                <?php if (in_array($p['id'], $deleted_ids)) continue; // 跳過已刪除的資料 ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><strong><?= $p['name'] ?></strong></td>
                    <td><span class="badge bg-info text-dark"><?= $p['cat'] ?? '零件' ?></span></td>
                    <td>$<?= number_format($p['price']) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td><?= ($p['stock'] > 0) ? '<span class="badge bg-success">有現貨</span>' : '<span class="badge bg-danger">缺貨中</span>' ?></td>
                    <td>
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-secondary">編輯</a>
                        
                        <form action="save_action.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="save_action.php" method="POST" class="modal-content">
            <input type="hidden" name="action" value="add">
            <div class="modal-header"><h5>新增零件</h5></div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-2" placeholder="零件名稱" required>
                
                <label class="form-label">零件分類</label>
                <select name="cat" class="form-select mb-2">
                    <option value="CPU">CPU (處理器)</option>
                    <option value="GPU">GPU (顯示卡)</option>
                    <option value="MB">主機板 (MB)</option> <option value="RAM">RAM (記憶體)</option>
                    <option value="SSD">SSD (硬碟)</option>
                    <option value="Case">機殼 (Case)</option> <option value="Cooling">風扇/散熱 (Cooling)</option> <option value="Monitor">螢幕 (Monitor)</option> </select>
                
                <input type="number" name="price" class="form-control mb-2" placeholder="價格" required>
                <input type="number" name="stock" class="form-control mb-2" placeholder="庫存數量" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">儲存資料</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>