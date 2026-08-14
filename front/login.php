<?php require "../lib.php"; ?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 會員登入，登入後即可查看購物車並結帳。">
    <title>會員登入 | ZombieCoupleShop</title>
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
                    <h1>會員登入</h1>
                    <p class="hero-bar__tag">Member Login</p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="index.php">商品列表</a>
            <a href="buycart.php">購物車</a>
            <a href="login.php">會員登入</a>
        </nav>
    </header>

    <main class="main-section">
        <section class="product-list">

            <?php if (isset($_GET['reg'])): ?>
                <div class="alert-banner" role="status">註冊成功，請使用剛才設定的帳號密碼登入。</div>
            <?php endif; ?>

            <div class="auth-card">
                <h2 class="auth-title">會員登入</h2>
                <form action="../api/api.php?do=login" method="post" class="auth-form">
                    <div class="form-group">
                        <label for="acc">帳號</label>
                        <input type="text" id="acc" name="acc" placeholder="請輸入帳號" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="pwd">密碼</label>
                        <input type="password" id="pwd" name="pwd" placeholder="請輸入密碼" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn-next">登入</button>
                </form>
                <p class="auth-switch">第一次來嗎？<a href="reg.php">立即註冊會員</a></p>
                <p class="auth-switch"><a href="index.php">← 返回商品列表</a></p>
            </div>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>
</body>

</html>
