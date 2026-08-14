<?php
require "../lib.php";

// 未登入者導去登入頁（登入成功後 api.php 會自動導回這裡）
if (empty($_SESSION['user'])) {
    plo("login.php");
    exit;
}

$cart = isset($_SESSION['buy']) ? $_SESSION['buy'] : [];
$rows = [];
$total = 0;

foreach ($cart as $id => $num) {
    $re = select("q4t5_product", "id=" . intval($id));
    if (!$re) {
        continue; // 商品已被下架或刪除，略過顯示
    }
    $ro = $re[0];
    $num = max(0, intval($num));
    $sub = $ro['price'] * $num;
    $total += $sub;
    $rows[] = [
        'id' => intval($id),
        'seq' => $ro['seq'],
        'title' => $ro['title'],
        'img' => $ro['img'],
        'price' => $ro['price'],
        'num' => $num,
        'stock' => intval($ro['num']),
        'sub' => $sub,
    ];
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 購物車，確認您選購的手作鉤織玩偶與鑰匙圈。">
    <title>購物車 | ZombieCoupleShop</title>
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
                    <h1>購物車</h1>
                    <p class="hero-bar__tag">Your Cart</p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="index.php">商品列表</a>
            <a href="buycart.php">購物車<?php if (count($rows)): ?><span class="cart-count"><?= count($rows) ?></span><?php endif; ?></a>
            <a href="../api/api.php?do=logout">登出（<?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>）</a>
        </nav>
    </header>

    <main class="main-section">
        <section class="product-list">

            <nav class="checkout-steps" aria-label="結帳流程">
                <div class="step is-active">
                    <span class="step-circle">1</span>
                    <span class="step-label">確認訂單</span>
                </div>
                <span class="step-line" aria-hidden="true"></span>
                <div class="step">
                    <span class="step-circle">2</span>
                    <span class="step-label">填寫付款資料</span>
                </div>
                <span class="step-line" aria-hidden="true"></span>
                <div class="step">
                    <span class="step-circle">3</span>
                    <span class="step-label">完成訂購</span>
                </div>
            </nav>

            <?php if (empty($rows)): ?>

                <div class="empty-cart-note">購物車目前是空的，快去挑選喜歡的手作小物吧！</div>
                <a class="btn-next" href="index.php" style="display:block;text-align:center;text-decoration:none;">回商品列表</a>

            <?php else: ?>

                <div class="table-scroll" role="region" aria-label="購物車商品清單">
                    <table class="product-table cart-table">
                        <thead>
                            <tr>
                                <th class="title">圖片</th>
                                <th class="title">編號</th>
                                <th class="title">商品名稱</th>
                                <th class="title">數量</th>
                                <th class="title">庫存量</th>
                                <th class="title">單價</th>
                                <th class="title">小計</th>
                                <th class="title">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td class="img"><img src="<?= htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>"></td>
                                    <td><?= htmlspecialchars($row['seq'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="product-info"><?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="qty-static"><?= $row['num'] ?></td>
                                    <td class="qty-static">
                                        <?= $row['stock'] ?>
                                        <?php if ($row['num'] > $row['stock']): ?>
                                            <span class="stock-note is-low">庫存不足</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="product-price">NT$ <?= number_format($row['price']) ?></td>
                                    <td class="line-total">$ <?= number_format($row['sub']) ?></td>
                                    <td class="remove"><a class="remove-btn" href="../api/api.php?do=cartdel&amp;id=<?= $row['id'] ?>">移除</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="order-summary">
                    <div class="summary-row summary-row--total">
                        <span class="summary-label">總計</span>
                        <span class="summary-value grand-total">$ <?= number_format($total) ?></span>
                    </div>
                    <a class="btn-next" href="pay.php" style="display:block;text-align:center;text-decoration:none;">前往結帳</a>
                </div>

            <?php endif; ?>

            <div class="notice-section">
                <h2 class="notice-title"><span class="notice-title__en" lang="en">Checkout Notice</span><span class="notice-title__sep" aria-hidden="true"> / </span><span class="notice-title__zh" lang="zh-Hant">結帳須知</span></h2>
                <ul class="notice-list">
                    <li>所有商品均為手工編織，工作天約 <span class="highlight-text">7-14 天</span>，不收急單。</li>
                    <li>下單後將依付款順序安排製作，若需調整規格請於下單前私訊確認。</li>
                    <li>商品一經拆封使用或客製化商品，恕不接受退換貨。</li>
                    <li>若購買數量超過目前庫存，仍可送出訂單，賣家將另行與您確認到貨時間。</li>
                </ul>
            </div>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>
</body>

</html>
