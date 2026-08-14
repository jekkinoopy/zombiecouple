<?php
require "../lib.php";
$a1 = rand(1, 9);
$a2 = rand(1, 9);
$_SESSION['captcha'] = $a1 + $a2; // 伺服器端保存正確答案，供 api.php 比對
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 管理者登入，登入後可管理訂單。">
    <title>管理者登入 | ZombieCoupleShop</title>
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
                    <h1>管理者登入</h1>
                    <p class="hero-bar__tag">Admin Login</p>
                </div>
            </div>
        </div>
        <nav class="site-nav" aria-label="站內導覽">
            <a href="../front/index.php">商品列表</a>
        </nav>
    </header>

    <main class="main-section">
        <section class="product-list">

            <div class="auth-card">
                <h2 class="auth-title">訂單管理登入</h2>
                <form action="../api/api.php?do=adlogin" method="post" class="auth-form" onsubmit="return checkAns()">
                    <div class="form-group">
                        <label for="acc">管理者帳號</label>
                        <input type="text" id="acc" name="acc" placeholder="請輸入管理者帳號" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="pwd">密碼</label>
                        <input type="password" id="pwd" name="pwd" placeholder="請輸入密碼" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label for="ans">驗證碼</label>
                        <div class="captcha-row">
                            <span><?= $a1 ?> + <?= $a2 ?> = </span>
                            <input type="number" id="ans" name="ans" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-next">登入</button>
                </form>
                <p class="auth-switch"><a href="../front/index.php">← 返回商品列表</a></p>
            </div>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>

    <script>
        function checkAns() {
            const ans = parseInt(document.getElementById('ans').value, 10);
            if (ans !== <?= (int)($a1 + $a2) ?>) {
                alert('驗證碼錯誤，請重新輸入');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
