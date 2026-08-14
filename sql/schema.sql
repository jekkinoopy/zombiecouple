-- ZombieCoupleShop 題組四（購物功能 + 訂單管理）資料庫結構
-- 使用方式：先建立資料庫，再匯入本檔
--   CREATE DATABASE zombiecouple_q4 DEFAULT CHARACTER SET utf8mb4;
--   USE zombiecouple_q4;
--   SOURCE schema.sql;

CREATE TABLE IF NOT EXISTS q4t5_product (
    id     INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    seq    INT NOT NULL COMMENT '對外顯示的商品編號 = 100000 + id',
    title  VARCHAR(100) NOT NULL COMMENT '商品名稱',
    price  INT NOT NULL COMMENT '單價',
    spec   VARCHAR(255) NOT NULL COMMENT '規格',
    num    INT NOT NULL DEFAULT 0 COMMENT '庫存量',
    img    VARCHAR(255) NOT NULL COMMENT '圖片路徑',
    text   TEXT NOT NULL COMMENT '商品介紹',
    dpy    TINYINT NOT NULL DEFAULT 1 COMMENT '1=販售中 0=已下架'
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS q4t9_user (
    id    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(50) NOT NULL,
    acc   VARCHAR(50) NOT NULL,
    pwd   VARCHAR(50) NOT NULL,
    tel   VARCHAR(30) NOT NULL,
    addr  VARCHAR(255) NOT NULL,
    mail  VARCHAR(100) NOT NULL,
    date  DATE NOT NULL,
    UNIQUE KEY uk_acc (acc)
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS q4t8_order (
    id    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    acc   VARCHAR(50) NOT NULL,
    name  VARCHAR(50) NOT NULL,
    tel   VARCHAR(30) NOT NULL,
    addr  VARCHAR(255) NOT NULL,
    mail  VARCHAR(100) NOT NULL,
    total INT NOT NULL,
    date  DATE NOT NULL,
    buy   TEXT NOT NULL COMMENT 'serialize() 後的購物車內容：[商品id => 數量]'
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS q4t10_admin (
    id   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    acc  VARCHAR(50) NOT NULL,
    pwd  VARCHAR(50) NOT NULL
) DEFAULT CHARSET=utf8mb4;

-- 預設管理者帳號（正式使用請務必修改密碼）
INSERT INTO q4t10_admin (acc, pwd) VALUES ('admin', 'admin1234');

-- 商品種子資料，對應 yarn/yarn001.jpg ~ yarn010.jpg
-- img 路徑為 ../yarn/...，因為顯示這些圖片的頁面都在 front/ 或 back/ 資料夾內，比根目錄深一層
INSERT INTO q4t5_product (seq, title, price, spec, num, img, text, dpy) VALUES
(100001, '貓頭鷹',       390, '尺寸約 8cm，含金屬扣環', 12, '../yarn/yarn001.jpg', '手工鉤織貓頭鷹吊飾，圓滾滾的造型十分討喜。', 1),
(100002, '寶可夢球',     390, '尺寸約 8cm，含金屬扣環',  8, '../yarn/yarn002.jpg', '手工鉤織寶可夢球吊飾，紅白配色經典還原。', 1),
(100003, '小鈴鐺項圈',   390, '尺寸約 8cm，含金屬扣環', 15, '../yarn/yarn003.jpg', '手工鉤織小鈴鐺項圈，適合寵物或包包吊飾。', 1),
(100004, '嘟嘴小鴨',     390, '尺寸約 8cm，含金屬扣環', 10, '../yarn/yarn004.jpg', '手工鉤織嘟嘴小鴨吊飾，表情逗趣可愛。', 1),
(100005, '小鴨置物籃',   390, '尺寸約 8cm，含金屬扣環',  6, '../yarn/yarn005.jpg', '手工鉤織小鴨造型置物籃，桌面收納好夥伴。', 1),
(100006, '小小兵鑰匙圈', 390, '尺寸約 8cm，含金屬扣環',  9, '../yarn/yarn006.jpg', '手工鉤織小小兵鑰匙圈，經典黃色造型。', 1),
(100007, '毛怪大眼怪',   390, '尺寸約 8cm，含金屬扣環',  7, '../yarn/yarn007.jpg', '手工鉤織毛怪與大眼怪雙人組吊飾。', 1),
(100008, '皮卡丘',       390, '尺寸約 8cm，含金屬扣環', 11, '../yarn/yarn008.jpg', '手工鉤織皮卡丘吊飾，人氣經典角色。', 1),
(100009, '無臉男鑰匙圈', 390, '尺寸約 8cm，含金屬扣環',  5, '../yarn/yarn009.jpg', '手工鉤織無臉男鑰匙圈，神秘又療癒。', 1),
(100010, '龍貓鑰匙圈',   880, '尺寸約 8cm，含金屬扣環',  4, '../yarn/yarn010.jpg', '手工鉤織龍貓鑰匙圈，森林系人氣角色。', 1);
