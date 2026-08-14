<?php
require "../lib.php";

if (empty($_SESSION['admin'])) {
    plo("adlogin.php");
    exit;
}

$orders = select("q4t8_order", "1 order by id desc");
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 訂單管理（後台）。">
    <title>訂單管理 | ZombieCoupleShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Creepster&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/css.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <header class="shop-header">
        <div class="hero-card">
            <div class="hero-art">
                <img src="../banner.jpg" alt="Zombie Couple Shop 主視覺：手作鉤織殭屍玩偶" class="hero-art__img" fetchpriority="high">
            </div>
            <div class="hero-bar">
                <div class="hero-bar__mark">
                    <img src="../logo.jpg" alt="Zombie Couple Shop 標誌" class="hero-bar__logo">
                </div>
                <div class="hero-bar__copy">
                    <p class="hero-bar__brand">Zombie Couple Shop</p>
                    <h1>訂單管理</h1>
                    <p class="hero-bar__tag">Admin / Orders</p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="../front/index.php">商品列表</a>
            <a href="../api/api.php?do=adlogout">管理者登出</a>
        </nav>
    </header>

    <main class="main-section">
        <section class="product-list">

            <?php if (empty($orders)): ?>

                <div class="empty-cart-note">目前尚無任何訂單。</div>

            <?php else: ?>

                <div class="table-scroll" role="region" aria-label="訂單列表">
                    <table class="product-table admin-table">
                        <thead>
                            <tr>
                                <th class="title">訂單編號</th>
                                <th class="title">會員帳號</th>
                                <th class="title">姓名</th>
                                <th class="title">金額</th>
                                <th class="title">下單時間</th>
                                <th class="title">明細</th>
                                <th class="title">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $ro):
                                $seq = date("Ymd000000", strtotime($ro['date'])) + $ro['id'];
                            ?>
                                <tr>
                                    <td><a href="orderdetail.php?id=<?= (int)$ro['id'] ?>"><?= htmlspecialchars($seq, ENT_QUOTES, 'UTF-8') ?></a></td>
                                    <td><?= htmlspecialchars($ro['acc'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($ro['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>$ <?= number_format($ro['total']) ?></td>
                                    <td><?= htmlspecialchars($ro['date'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><a class="coupon-btn" href="orderdetail.php?id=<?= (int)$ro['id'] ?>">查看明細</a></td>
                                    <td class="remove"><a class="remove-btn" href="../api/api.php?do=odrdel&amp;id=<?= (int)$ro['id'] ?>" onclick="return confirm('確定要刪除此筆訂單？')">刪除</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>
</body>

</html>
