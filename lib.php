<?php
/**
 * ZombieCoupleShop 共用函式庫
 * 比照網頁設計乙級技術士技能檢定「題組四」規範撰寫：
 * select() / insert() / update() / delete() / plo() / jlo()
 *
 * 使用前請先：
 * 1. 匯入 sql/schema.sql 建立資料庫與資料表
 * 2. 依實際環境修改下方 DB_HOST / DB_NAME / DB_USER / DB_PASS
 */

session_start();
date_default_timezone_set('Asia/Taipei');

// ---- 資料庫連線設定：請依實際環境調整 ----
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'zombiecouple_q4');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('資料庫連線失敗，請確認 lib.php 內的連線設定與 sql/schema.sql 是否已匯入：' . $e->getMessage());
}

/** 查詢：$tb 資料表名稱，$wh WHERE 條件字串（不含 WHERE） */
function select($tb, $wh) {
    global $db;
    return $db->query("SELECT * FROM " . $tb . " WHERE " . $wh)->fetchAll(PDO::FETCH_ASSOC);
}

/** 新增一筆資料，回傳新增的 id */
function insert($ary, $tb) {
    global $db;
    $field = "id";
    $data = "null";
    foreach ($ary as $key => $value) {
        $field .= "," . $key;
        $data .= ",'" . addslashes($value) . "'";
    }
    $db->query("INSERT INTO " . $tb . "(" . $field . ") VALUES (" . $data . ")");
    return $db->lastInsertId();
}

/** 更新資料：num+1 / num-1 做單筆數值增減；其餘 key 視為批次更新單一欄位 */
function update($ary, $tb) {
    global $db;
    foreach ($ary as $do => $data) {
        switch ($do) {
            case 'num+1':
                $db->query("UPDATE " . $tb . " SET num=num+1 WHERE id=" . intval($data));
                break;
            case 'num-1':
                $db->query("UPDATE " . $tb . " SET num=num-1 WHERE id=" . intval($data));
                break;
            default:
                foreach ($data as $key => $value) {
                    $db->query("UPDATE " . $tb . " SET " . $do . "='" . addslashes($value) . "' WHERE id=" . intval($key));
                }
                break;
        }
    }
}

/** 刪除：del 為多筆 id 陣列；delwh 為條件字串 */
function delete($ary, $tb) {
    global $db;
    foreach ($ary as $do => $data) {
        switch ($do) {
            case 'del':
                foreach ($data as $value) {
                    $db->query("DELETE FROM " . $tb . " WHERE id=" . intval($value));
                }
                break;
            case 'delwh':
                $db->query("DELETE FROM " . $tb . " WHERE " . $data);
                break;
        }
    }
}

/** PHP 轉址 */
function plo($link) {
    return header("location:" . $link);
}

/** JS 轉址（給 onclick 使用，可搭配 alert 一起輸出） */
function jlo($link) {
    return "location.href='" . $link . "'";
}
