<!DOCTYPE html>
<html lang="zh-Hant"> <!-- 修改語系為繁體中文 -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>銷售儀表板 | ZombieCouple Shop</title>
    <link rel="stylesheet" href="../css/css.css">
    <link rel="stylesheet" href="../css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

</head>

<body>


    <iframe name="back" style="display:none;"></iframe>
    <div id="main">
        <div id="top">
            <a href="?">
                <header class="shop-header">
                    <div class="banner-area">
                        <img src="../banner.png" alt="ZombieCouple橫幅" class="banner">
                        <!-- <h1>手作毛線系列</h1> -->
                        <p class="subtitle">CROCHET DOLLS</p>
                    </div>
                </header>
            </a>
            <div style="margin: auto;text-align: center;margin-bottom: 50px;">
                <a href="?do=index">回首頁</a> |
                <a href="?do=news">最新消息</a> |
                <a href="?do=look">購物流程</a> |
                <a href="?do=buycart">購物車</a> |
                <a href="?do=login">會員登入</a> |
                <a href="?do=admin">管理登入</a>
            </div>
            <!-- <marguee    >情人節特惠活動 &nbsp; 為了慶祝七夕情人節，將舉辦情人兩人到現場有七七折之特惠活動~</p> -->
        </div>
        <div id="left" class="ct">

            <div style="min-height:400px;">
                <div class="b active">全部商品</div>
                <!-- 大分類:手作毛線類、IP商品類、美妝保養類 -->

                <div class="b">手作毛線類
                    <div class="m">吊飾類、鑰匙圈類、置物籃類</div>
                </div>

                <div class="b">IP商品類
                    <div class="m">公仔類、周邊小物</div>
                </div>

                <div class="b">美妝保養類
                    <div class="m">保養品、美妝小物</div>
                </div>
            </div>
            <div class="stat-card visit-widget">
                <div class="stat-icon icon-mint">👣</div>
                <div class="stat-body">
                    <div class="stat-value">00005</div>
                    <div class="stat-label">進站總人數</div>
                </div>
            </div>
        </div>


        <!-- 大分類:手作毛線類、IP商品類、美妝保養類

                手作毛線類中分類:吊飾類、鑰匙圈類、置物籃類
                IP商品類中分類:公仔類、周邊小物
                美妝保養類中分類:保養品、美妝小物 -->

        <div id="right">
            <div class="dashboard">

                <!-- 統計卡片 -->
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon icon-mint">🧾</div>
                        <div class="stat-body">
                            <div class="stat-value">128</div>
                            <div class="stat-label">總訂單數</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-peach">👤</div>
                        <div class="stat-body">
                            <div class="stat-value">56</div>
                            <div class="stat-label">總會員數</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-pink">🧶</div>
                        <div class="stat-body">
                            <div class="stat-value">10</div>
                            <div class="stat-label">上架商品數</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-sage">💰</div>
                        <div class="stat-body">
                            <div class="stat-value">NT$ 42,900</div>
                            <div class="stat-label">總營收</div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <!-- 銷售趨勢：區間切換 + Chart.js 折線圖 -->
                    <div class="dashboard-card dashboard-main">
                        <div class="dashboard-card-head">
                            <h3>銷售趨勢</h3>
                            <div class="pill-toggle" id="trendRange">
                                <button type="button" class="pill active" data-range="7">近 7 天</button>
                                <button type="button" class="pill" data-range="30">近 30 天</button>
                                <button type="button" class="pill" data-range="180">近半年</button>
                            </div>
                        </div>
                        <div class="chart-box">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>

                    <!-- 商品類別佔比：圓環圖 + 置中百分比 -->
                    <div class="dashboard-card dashboard-side">
                        <div class="dashboard-card-head">
                            <h3>商品類別佔比</h3>
                        </div>
                        <div class="ring-wrap">
                            <div class="chart-box chart-box-ring">
                                <canvas id="categoryChart"></canvas>
                                <div class="ring-center">
                                    <span class="ring-value">60%</span>
                                    <span class="ring-label">吊飾類</span>
                                </div>
                            </div>
                        </div>
                        <ul class="legend-list">
                            <li><span class="dot dot-1"></span>吊飾類 60%</li>
                            <li><span class="dot dot-2"></span>鑰匙圈類 30%</li>
                            <li><span class="dot dot-3"></span>置物籃類 10%</li>
                        </ul>
                    </div>
                </div>

                <!-- 熱銷商品排行：三種圖表切換 + 排行榜 -->
                <div class="dashboard-card">
                    <div class="dashboard-card-head">
                        <h3>熱銷商品排行</h3>
                        <div class="chart-tabs">
                            <button type="button" class="chart-tab active" data-type="bar">長條圖</button>
                            <button type="button" class="chart-tab" data-type="pie">圓餅圖</button>
                            <button type="button" class="chart-tab" data-type="line">折線圖</button>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-box">
                            <canvas id="rankChart"></canvas>
                        </div>
                        <ol class="rank-list">
                            <li><span class="rank-no">1</span><span class="rank-name">龍貓鑰匙圈</span><span class="rank-num">NT$ 7,040</span></li>
                            <li><span class="rank-no">2</span><span class="rank-name">貓頭鷹</span><span class="rank-num">NT$ 4,680</span></li>
                            <li><span class="rank-no">3</span><span class="rank-name">皮卡丘</span><span class="rank-num">NT$ 4,290</span></li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <div id="bottom" style="line-height:70px;background:url(icon/bot.png); color:#FFF;" class="ct">
        頁尾版權 : </div>
    </div>


    <footer>
        © 2026 ZOMBIE COUPLE SHOP. MISSION ACCOMPLISHED.
    </footer>

    <script>
        // 以下皆為版面示意用的範例假資料，之後可換成串接資料庫的真實統計
        const trendData = {
            7: { labels: ['09/11', '09/12', '09/13', '09/14', '09/15', '09/16', '09/17'], values: [3, 5, 2, 6, 4, 7, 5] },
            30: { labels: ['第1週', '第2週', '第3週', '第4週'], values: [18, 22, 15, 27] },
            180: { labels: ['4月', '5月', '6月', '7月', '8月', '9月'], values: [60, 75, 50, 90, 82, 70] }
        };

        const rankLabels = ['龍貓鑰匙圈', '貓頭鷹', '皮卡丘'];
        const rankValues = [7040, 4680, 4290];

        const categoryLabels = ['吊飾類', '鑰匙圈類', '置物籃類'];
        const categoryValues = [60, 30, 10];
        const categoryColors = ['#5f8f81', '#ff9478', '#ffbfd2'];

        let trendChart, rankChart, categoryChart;

        function renderTrendChart(range) {
            const data = trendData[range];
            if (trendChart) trendChart.destroy();
            trendChart = new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: '訂單數',
                        data: data.values,
                        borderColor: '#5f8f81',
                        backgroundColor: 'rgba(95, 143, 129, 0.25)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        function renderRankChart(type) {
            if (rankChart) rankChart.destroy();
            rankChart = new Chart(document.getElementById('rankChart'), {
                type: type,
                data: {
                    labels: rankLabels,
                    datasets: [{
                        label: '營收',
                        data: rankValues,
                        backgroundColor: ['#5f8f81', '#ff9478', '#ffbfd2']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: type !== 'bar' } }
                }
            });
        }

        renderTrendChart(7);
        renderRankChart('bar');

        categoryChart = new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryValues,
                    backgroundColor: categoryColors,
                    borderColor: '#ffffff',
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: { legend: { display: false } }
            }
        });

        document.querySelectorAll('#trendRange .pill').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#trendRange .pill').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                renderTrendChart(this.dataset.range);
            });
        });

        document.querySelectorAll('.chart-tab').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.chart-tab').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                renderRankChart(this.dataset.type);
            });
        });
    </script>
</body>

</html>