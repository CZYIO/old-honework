<?php
// save_action.php
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';

// --- 新增 ---
if ($action === 'add') {
    $current_added = isset($_COOKIE['added_items']) ? json_decode($_COOKIE['added_items'], true) : [];
    $new_item = [
        'id' => rand(1000, 9999),
        'name' => $_POST['name'],
        'cat' => $_POST['cat'],
        'price' => (int)$_POST['price'],
        'stock' => (int)$_POST['stock'],
        'status' => ((int)$_POST['stock'] > 0) ? '有現貨' : '缺貨中'
    ];
    array_unshift($current_added, $new_item);
    setcookie("added_items", json_encode($current_added), time() + 3600, "/");
}

// --- 更新 (增加 status 處理) ---
if ($action === 'update') {
    $current_added = isset($_COOKIE['added_items']) ? json_decode($_COOKIE['added_items'], true) : [];
    
    // 將修改後的資訊打包，並確保 ID 一致
    $updated_item = [
        'id' => (int)$id,
        'name' => $_POST['name'],
        'cat' => $_POST['cat'],
        'price' => (int)$_POST['price'],
        'stock' => (int)$_POST['stock'],
        'status' => $_POST['status'] // 接收來自 edit.php 的手動選取狀態
    ];

    // 如果 ID 已經存在 Cookie 裡，就取代它；如果不存在，就新增進去 (達成覆蓋 base_products 的效果)
    $found = false;
    foreach ($current_added as &$p) {
        if ($p['id'] == $id) {
            $p = $updated_item;
            $found = true;
            break;
        }
    }
    if (!$found) { $current_added[] = $updated_item; }

    setcookie("added_items", json_encode($current_added), time() + 3600, "/");
}

// --- 刪除 ---
if ($action === 'delete') {
    setcookie("del_" . $id, "true", time() + 3600, "/");
}

header("Location: index.php");
exit();
?>