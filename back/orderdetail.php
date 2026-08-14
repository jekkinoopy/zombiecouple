<?php
require "../lib.php";

if (empty($_SESSION['admin'])) {
    plo("adlogin.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$re = select("q4t8_order", "id=" . $id);
if (!$re) {
    plo("order.php");
    exit;
}
$ro = $re[0];
$seq = date("Ymd000000", strtotime($ro['date'])) + $ro['id'];
$buy = @unserialize($ro['buy']);
$buy = is_array($buy) ? $buy : [];

$rows = [];
foreach ($buy as $pid => $num) {
    $pre = select("q4t5_product", "id=" . intval($pid));
    $title = $pre ? $pre[0]['title'] : '（商品已下架）';
    $price = $pre ? $pre[0]['price'] : 0;
    $img = $pre ? $pre[0]['img'] : '';
    $num = intval($num);
    $rows[] = [
        'title' => $title,
        'img' => $img,
        'price' => $price,
        'num' => $num,
        'sub' => $price * $num,
    ];
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 訂單明細（後台）。">
    <!-- 原檔名 item.php，因內容實為「訂單明細」而非商品，改名 orderdetail.php -->
    <title>訂單明細 | ZombieCoupleShop</title>
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
                    <h1>訂單明細</h1>
                    <p class="hero-bar__tag">Order #<?= htmlspecialchars($seq, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="order.php">← 返回訂單列表</a>
            <a href="../api/api.php?do=adlogout">管理者登出</a>
        </nav>
    </header>

    <main class="main-section">
        <section class="product-list">

            <div class="order-detail-block">
                <dl>
                    <dt>訂單編號</dt>
                    <dd><?= htmlspecialchars($seq, ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>會員帳號</dt>
                    <dd><?= htmlspecialchars($ro['acc'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>收件姓名</dt>
                    <dd><?= htmlspecialchars($ro['name'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>聯絡電話</dt>
                    <dd><?= htmlspecialchars($ro['tel'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>收件地址</dt>
                    <dd><?= htmlspecialchars($ro['addr'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>電子信箱</dt>
                    <dd><?= htmlspecialchars($ro['mail'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt>下單時間</dt>
                    <dd><?= htmlspecialchars($ro['date'], ENT_QUOTES, 'UTF-8') ?></dd>
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
                                <td class="img"><?php if ($row['img']): ?><img src="<?= htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>"><?php endif; ?></td>
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
                    <span class="summary-label">訂單總額</span>
                    <span class="summary-value grand-total">$ <?= number_format($ro['total']) ?></span>
                </div>
                <a class="btn-reset" href="order.php" style="display:block;text-align:center;text-decoration:none;">返回訂單列表</a>
            </div>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>
</body>

</html>
