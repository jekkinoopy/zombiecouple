<?php
$showCenter = isset($_GET['center']) && $_GET['center'] === '1';
$pageTitle = $showCenter ? '小小兵會員中心' : '會員註冊';
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="簡易註冊系統：會員帳號、密碼與個人資料表單。">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> - 努比的全端筆記</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Creepster&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&family=Noto+Sans+TC:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css.css">
</head>

<body>
    <header class="shop-header">
        <div class="hero-card">
            <div class="hero-art">
                <p class="hero-art__fallback" aria-hidden="true">Member Register</p>
            </div>
            <div class="hero-bar">
                <div class="hero-bar__mark" aria-hidden="true">ZC</div>
                <div class="hero-bar__copy">
                    <p class="hero-bar__brand">Nubby Notes</p>
                    <h1><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                    <p class="hero-bar__tag">Sign Up</p>
                </div>
            </div>
        </div>
    </header>

    <main class="main-section">
        <section class="product-list">
            <div class="table-scroll" role="region" aria-label="註冊表單">
                <section class="register-form" aria-label="會員註冊">
                    <div class="form-header">
                        <h2>會員註冊</h2>
                        <p>歡迎加入我們的社區</p>
                    </div>

                    <div class="success-message" id="successMessage" role="status">
                        表單已成功提交！
                    </div>

                    <form id="registerForm" action="api_register.php" method="post">
                        <div class="form-group">
                            <label for="account">帳號 *</label>
                            <input type="text" id="account" name="account" placeholder="請輸入帳號" required
                                autocomplete="username">
                        </div>
                        <div class="form-group">
                            <label for="password">密碼 *</label>
                            <input type="password" id="password" name="password" placeholder="請輸入密碼" required
                                autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="email">電郵 *</label>
                            <input type="email" id="email" name="email" placeholder="請輸入電郵" required
                                autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="tel">電話 *</label>
                            <input type="tel" id="tel" name="tel" placeholder="請輸入電話號碼" required autocomplete="tel">
                        </div>
                        <div class="form-group">
                            <label for="birthday">生日 *</label>
                            <input type="date" id="birthday" name="birthday" required>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-submit">註冊</button>
                            <button type="reset" class="btn-reset">清空</button>
                        </div>
                    </form>

                    <p class="info-text">* 表示必填項目</p>
                </section>
            </div>

            <section class="notice-section" aria-label="題目說明">
                <h2 class="notice-title"><span class="notice-title__en" lang="en">Exercise Brief</span><span
                        class="notice-title__sep" aria-hidden="true"> / </span><span class="notice-title__zh"
                        lang="zh-Hant">簡易註冊系統</span></h2>
                <ul class="notice-list">
                    <li>建立資料表存放使用者的帳號、密碼及個人資料。</li>
                    <li>建立網頁表單讓使用者輸入帳號、密碼及個人資料。</li>
                    <li>送出表單後將資料存入資料表。</li>
                </ul>
                <div class="spec-block">
                    <h3>資料表 members</h3>
                    <ul>
                        <li>id、account、password、tel、birthday、email</li>
                    </ul>
                </div>
                <div class="spec-block">
                    <h3>表單設計</h3>
                    <ul>
                        <li>清新簡約風；整體底色淺綠色。</li>
                        <li>文字以黃色或橘色搭配。</li>
                        <li>輸入欄位皆為圓角。</li>
                    </ul>
                </div>
            </section>
        </section>
    </main>

    <footer class="site-footer">
        <p>努比的全端筆記</p>
        <p class="site-footer__rights">All rights reserved.</p>
    </footer>
</body>

</html>
