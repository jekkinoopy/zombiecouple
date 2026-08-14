<?php
require "../lib.php";

if (empty($_SESSION['user']) || empty($_SESSION['buy'])) {
    plo("buycart.php");
    exit;
}

$ure = select("q4t9_user", "id=" . intval($_SESSION['id']));
if (!$ure) {
    plo("login.php");
    exit;
}
$uro = $ure[0];

$rows = [];
$total = 0;
foreach ($_SESSION['buy'] as $id => $num) {
    $re = select("q4t5_product", "id=" . intval($id));
    if (!$re) {
        continue;
    }
    $ro = $re[0];
    $num = max(0, intval($num));
    $sub = $ro['price'] * $num;
    $total += $sub;
    $rows[] = [
        'title' => $ro['title'],
        'img' => $ro['img'],
        'price' => $ro['price'],
        'num' => $num,
        'sub' => $sub,
    ];
}

if (empty($rows)) {
    plo("buycart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 結帳確認，確認收件資料與訂單內容後送出訂單。">
    <title>結帳確認 | ZombieCoupleShop</title>
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
                    <h1>結帳確認</h1>
                    <p class="hero-bar__tag">Confirm Order</p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="index.php">商品列表</a>
            <a href="buycart.php">購物車</a>
            <a href="../api/api.php?do=logout">登出（<?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>）</a>
        </nav>
    </header>

    <main class="main-section">
        <section class="product-list">

            <nav class="checkout-steps" aria-label="結帳流程">
                <div class="step">
                    <span class="step-circle">1</span>
                    <span class="step-label">確認訂單</span>
                </div>
                <span class="step-line" aria-hidden="true"></span>
                <div class="step is-active">
                    <span class="step-circle">2</span>
                    <span class="step-label">填寫付款資料</span>
                </div>
                <span class="step-line" aria-hidden="true"></span>
                <div class="step">
                    <span class="step-circle">3</span>
                    <span class="step-label">完成訂購</span>
                </div>
            </nav>

            <div class="order-detail-block">
                <dl>
                    <dt>收件姓名</dt>
                    <dd><?= htmlspecialchars($uro['name'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>聯絡電話</dt>
                    <dd><?= htmlspecialchars($uro['tel'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>收件地址</dt>
                    <dd><?= htmlspecialchars($uro['addr'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>電子信箱</dt>
                    <dd><?= htmlspecialchars($uro['mail'], ENT_QUOTES, 'UTF-8') ?></dd>
                </dl>
            </div>

            <div class="table-scroll" role="region" aria-label="訂單商品明細">
                <table class="product-table cart-table">
                    <thead>
                        <tr>
                            <th class="title">圖片</th>
                            <th class="title">商品名稱</th>
                            <th class="title">數量</th>
                            <th class="title">單價</th>
                            <th class="title">小計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td class="img"><img src="<?= htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>"></td>
                                <td class="product-info"><?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="qty-static"><?= $row['num'] ?></td>
                                <td class="product-price">NT$ <?= number_format($row['price']) ?></td>
                                <td class="line-total">$ <?= number_format($row['sub']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="order-summary">
                <div class="summary-row summary-row--total">
                    <span class="summary-label">應付總額</span>
                    <span class="summary-value grand-total">$ <?= number_format($total) ?></span>
                </div>
                <button type="button" class="btn-next" onclick="<?= htmlspecialchars(jlo('../api/api.php?do=pay&total=' . intval($total)), ENT_QUOTES, 'UTF-8') ?>">確定送出訂單</button>
                <button type="button" class="btn-reset" onclick="window.history.back()">返回修改訂單</button>
            </div>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>
</body>

</html>
