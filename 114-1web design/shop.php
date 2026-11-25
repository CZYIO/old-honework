<?php
require_once 'db_config.php';
// 只抓取庫存大於 0 且狀態為有現貨的零件
$stmt = $pdo->query("SELECT * FROM products WHERE stock > 0 AND status = '有現貨'");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SmartStock | 零件商城</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="text-center mb-4">電腦零件商城</h1>
    <div class="row">
        <?php foreach ($products as $p): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($p['part_name']) ?></h5>
                    <p class="text-muted">分類：<?= $p['category'] ?></p>
                    <h4 class="text-primary">$<?= number_format($p['price']) ?></h4>
                    <p>剩餘庫存：<span id="stock-<?= $p['id'] ?>"><?= $p['stock'] ?></span></p>
                    <button class="btn btn-success buy-btn" data-id="<?= $p['id'] ?>">立即購買</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.buy-btn', function() {
    const id = $(this).data('id');
    const btn = $(this);
    
    if(confirm('確定要購買此零件嗎？')) {
        $.post('api.php', { action: 'buy', id: id }, function(res) {
            if(res.trim() === 'success') {
                alert('購買成功！庫存已更新。');
                location.reload(); // 重新整理看到庫存減少
            } else {
                alert('購買失敗：' + res);
            }
        });
    }
});
</script>
</body>
</html>