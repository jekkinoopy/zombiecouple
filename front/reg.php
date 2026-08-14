<?php require "../lib.php"; ?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZombieCoupleShop 會員註冊，加入會員即可購買手作鉤織玩偶與鑰匙圈。">
    <title>會員註冊 | ZombieCoupleShop</title>
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
                    <h1>會員註冊</h1>
                    <p class="hero-bar__tag">Join Us</p>
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

            <div class="auth-card">
                <h2 class="auth-title">會員註冊</h2>
                <form id="regForm" action="../api/api.php?do=reg" method="post" class="auth-form" onsubmit="return checkFlag()">
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="text" id="name" name="name" placeholder="請輸入姓名" required>
                    </div>
                    <div class="form-group">
                        <label for="acc">帳號</label>
                        <div class="field-inline">
                            <input type="text" id="acc" name="acc" placeholder="請輸入帳號" required autocomplete="username" oninput="resetFlag()">
                            <button type="button" class="btn-check" onclick="checkAcc()">檢測帳號</button>
                        </div>
                        <span class="field-msg" id="accMsg"></span>
                    </div>
                    <div class="form-group">
                        <label for="pwd">密碼</label>
                        <input type="password" id="pwd" name="pwd" placeholder="請輸入密碼" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="tel">電話</label>
                        <input type="tel" id="tel" name="tel" placeholder="請輸入電話號碼" required autocomplete="tel">
                    </div>
                    <div class="form-group">
                        <label for="addr">地址</label>
                        <input type="text" id="addr" name="addr" placeholder="請輸入收件地址" required autocomplete="street-address">
                    </div>
                    <div class="form-group">
                        <label for="mail">電郵</label>
                        <input type="email" id="mail" name="mail" placeholder="請輸入電郵" required autocomplete="email">
                    </div>
                    <button type="submit" class="btn-next">送出註冊</button>
                    <button type="reset" class="btn-reset" onclick="resetFlag()">清空表單</button>
                </form>
                <p class="auth-switch">已經是會員？<a href="login.php">前往登入</a></p>
                <p class="auth-switch"><a href="index.php">← 返回商品列表</a></p>
            </div>

        </section>
    </main>

    <footer class="site-footer">
        <p>Zombie Couple Shop</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>

    <script>
        // 送出前必須先按過「檢測帳號」且結果為可使用，flag 才會是 1
        let flag = 0;

        function resetFlag() {
            flag = 0;
            document.getElementById('accMsg').textContent = '';
            document.getElementById('accMsg').className = 'field-msg';
        }

        function checkAcc() {
            const acc = document.getElementById('acc').value.trim();
            const msg = document.getElementById('accMsg');
            if (!acc) {
                msg.textContent = '請先輸入帳號';
                msg.className = 'field-msg is-bad';
                flag = 0;
                return;
            }
            fetch('../api/api.php?do=checkuser', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'acc=' + encodeURIComponent(acc)
            })
                .then(function (r) { return r.text(); })
                .then(function (txt) {
                    msg.textContent = txt;
                    if (txt === '可使用此帳號') {
                        msg.className = 'field-msg is-ok';
                        flag = 1;
                    } else {
                        msg.className = 'field-msg is-bad';
                        flag = 0;
                    }
                })
                .catch(function () {
                    msg.textContent = '檢測失敗，請稍後再試';
                    msg.className = 'field-msg is-bad';
                    flag = 0;
                });
        }

        function checkFlag() {
            if (flag !== 1) {
                alert('請先按下「檢測帳號」並確認帳號可以使用，才能送出註冊');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
