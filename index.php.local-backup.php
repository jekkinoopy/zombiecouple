<?php
require "lib.php";
$products = select("q4t5_product", "dpy=1 order by id asc");
$cartCount = isset($_SESSION['buy']) ? count($_SESSION['buy']) : 0;
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 手作鉤織玩偶與鑰匙圈，溫暖毛線小物與客製服務。">
    <title>手作毛線系列 | ZombieCoupleShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Creepster&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <header class="shop-header">
        <div class="hero-card">
            <div class="hero-art">
                <img src="./banner.jpg" alt="Zombie Couple Shop 主視覺：手作鉤織殭屍玩偶" class="hero-art__img" fetchpriority="high">
            </div>
            <div class="hero-bar">
                <div class="hero-bar__mark">
                    <img src="./logo.jpg" alt="Zombie Couple Shop 標誌" class="hero-bar__logo">
                </div>
                <div class="hero-bar__copy">
                    <p class="hero-bar__brand">Zombie Couple Shop</p>
                    <h1>手作毛線系列</h1>
                    <p class="hero-bar__tag">Crochet Dolls</p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="index.php">商品列表</a>
            <a href="buycart.php">購物車<?php if ($cartCount): ?><span class="cart-count"><?= $cartCount ?></span><?php endif; ?></a>
            <?php if (!empty($_SESSION['user'])): ?>
                <a href="api.php?do=logout">登出（<?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>）</a>
            <?php else: ?>
                <a href="login.php">會員登入</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="main-section">
        <section class="product-list">
            <div class="table-scroll" role="region" aria-label="商品清單">
            <table class="product-table">
                <thead>
                    <tr>
                        <th class="title">圖片</th>
                        <th class="title">品名</th>
                        <th class="title">售價</th>
                        <th class="title">規格</th>
                        <th class="title">庫存</th>
                        <th class="title">數量</th>
                        <th class="title">加入購物車</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $p):
                        $soldOut = intval($p['num']) <= 0;
                        $formId = 'cartform-' . (int)$p['id'];
                    ?>
                    <tr>
                        <td class="img<?= $i % 2 === 1 ? ' sc' : '' ?>"><img src="<?= htmlspecialchars($p['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?>"></td>
                        <td class="product-info"><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="product-price"><?= (int)$p['price'] ?></td>
                        <td class="spec"><?= htmlspecialchars($p['spec'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="qty-static">
                            <?= (int)$p['num'] ?>
                            <?php if ($soldOut): ?><span class="stock-note is-low">已售完</span><?php endif; ?>
                        </td>
                        <?php if ($soldOut): ?>
                            <td class="qty">—</td>
                            <td class="remove">已售完</td>
                        <?php else: ?>
                            <!-- 使用 HTML5 form 屬性讓 input/button 關聯到表格外的空 form，避免 <form> 跨欄破壞 table 結構 -->
                            <td class="qty"><input type="number" form="<?= $formId ?>" name="num" min="1" max="<?= (int)$p['num'] ?>" value="1" aria-label="<?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?> 數量"></td>
                            <td class="remove"><button type="submit" form="<?= $formId ?>" class="coupon-btn">加入購物車</button></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php foreach ($products as $p): if (intval($p['num']) <= 0) continue; ?>
                <form id="cartform-<?= (int)$p['id'] ?>" action="api.php?do=want&amp;id=<?= (int)$p['id'] ?>" method="post" hidden></form>
            <?php endforeach; ?>
            <div class="notice-section">
                <h2 class="notice-title"><span class="notice-title__en" lang="en">Purchase Notice</span><span class="notice-title__sep" aria-hidden="true"> / </span><span class="notice-title__zh" lang="zh-Hant">購買須知</span></h2>
                <ul class="notice-list">
                    <li>所有商品均為手工編織，工作天約 <span class="highlight-text">7-14 天</span>，不收急單。</li>
                    <li>手工製品難免有微小線頭或尺寸誤差，這正是手作的溫度。</li>
                    <li>螢幕色彩與實品可能有些許色差，請以實物為準。</li>
                    <li>提供客製化服務，歡迎私訊討論細節。</li>
                    <li>點選「加入購物車」後，未登入的訪客會先導向登入頁，登入或註冊後會自動回到購物車。</li>
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
