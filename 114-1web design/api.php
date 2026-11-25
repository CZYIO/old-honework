<?php

require_once 'db_config.php';


$action = $_POST['action'] ?? '';

try {
        if ($action == 'create') {
        $sql = "INSERT INTO products (part_name, category_id, brand, price, stock, description) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
    
        // 這裡要注意：接收的是 category_id
        $stmt->execute([
        $_POST['part_name'],
        $_POST['category_id'], // 這裡要對應 HTML 的 name="category_id"
        $_POST['brand'],
        $_POST['price'],
        $_POST['stock'],
        $_POST['description']
        ]);
        echo "success";
        
    }

    elseif ($action == 'update') {
        $id = $_POST['id'];
        $sql = "UPDATE products SET price = ?, stock = ?, status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([
            $_POST['price'],
            $_POST['stock'],
            $_POST['status'],
            $id
        ])) {
            echo "success";
        }
    }

    elseif ($action == 'delete') {
        $id = $_POST['id'];
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$id])) {
            echo "success";
        }
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "資料庫錯誤：" . $e->getMessage();
}
elseif ($action == 'buy') {
        $id = $_POST['id'];
        
        // 先檢查庫存是否足夠
        $check = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
        $check->execute([$id]);
        $current_stock = $check->fetchColumn();
        
        if ($current_stock > 0) {
            // 執行扣除庫存 (庫存 - 1)
            $sql = "UPDATE products SET stock = stock - 1 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])) {
                // 如果扣完變 0，自動改狀態為缺貨中 (選配功能)
                if ($current_stock == 1) {
                    $pdo->prepare("UPDATE products SET status = '缺貨中' WHERE id = ?")->execute([$id]);
                }
                echo "success";
            }
        } else {
            echo "庫存不足，無法購買";
        }
    }
?>