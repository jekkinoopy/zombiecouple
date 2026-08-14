<?php
/**
 * ZombieCoupleShop 全站唯一後端動作入口
 * 依 $_GET['do'] 分派：want / cartdel / checkuser / reg / login / logout
 *                     pay / adlogin / adlogout / odrdel
 */
require "../lib.php";

$do = isset($_GET['do']) ? $_GET['do'] : '';

switch ($do) {

    // ---- 加入購物車 ----
    case 'want':
        $id = intval($_GET['id']);
        $num = isset($_POST['num']) ? max(1, intval($_POST['num'])) : 1;
        $_SESSION['buy'][$id] = $num;
        if (empty($_SESSION['user'])) {
            plo("../front/login.php");
        } else {
            plo("../front/buycart.php");
        }
        break;

    // ---- 購物車刪除單品 ----
    case 'cartdel':
        $id = intval($_GET['id']);
        unset($_SESSION['buy'][$id]);
        plo("../front/buycart.php");
        break;

    // ---- 註冊表單 AJAX 帳號重複檢查 ----
    case 'checkuser':
        $acc = isset($_POST['acc']) ? trim($_POST['acc']) : '';
        if ($acc === '') {
            echo '請輸入帳號';
            break;
        }
        $re = select("q4t9_user", "acc='" . addslashes($acc) . "'");
        echo $re ? '帳號重複' : '可使用此帳號';
        break;

    // ---- 會員註冊 ----
    case 'reg':
        $acc = isset($_POST['acc']) ? trim($_POST['acc']) : '';
        // 伺服器端再檢查一次帳號是否重複，避免繞過前端 AJAX 檢測直接送出
        $dup = $acc !== '' ? select("q4t9_user", "acc='" . addslashes($acc) . "'") : [1];
        if ($acc === '' || $dup) {
            echo "<script>alert('帳號重複或未填寫，請返回重新輸入');" . jlo('../front/reg.php') . "</script>";
            break;
        }
        $post = [
            'name' => isset($_POST['name']) ? $_POST['name'] : '',
            'acc'  => $acc,
            'pwd'  => isset($_POST['pwd']) ? $_POST['pwd'] : '',
            'tel'  => isset($_POST['tel']) ? $_POST['tel'] : '',
            'addr' => isset($_POST['addr']) ? $_POST['addr'] : '',
            'mail' => isset($_POST['mail']) ? $_POST['mail'] : '',
            'date' => date('Y-m-d'),
        ];
        insert($post, "q4t9_user");
        plo("../front/login.php?reg=1");
        break;

    // ---- 會員登入 ----
    case 'login':
        $acc = isset($_POST['acc']) ? $_POST['acc'] : '';
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        $re = select("q4t9_user", "acc='" . addslashes($acc) . "' and pwd='" . addslashes($pwd) . "'");
        if ($re) {
            $_SESSION['user'] = $re[0]['acc'];
            $_SESSION['id'] = $re[0]['id'];
            $next = !empty($_SESSION['buy']) ? "../front/buycart.php" : "../front/index.php";
            plo($next);
        } else {
            echo "<script>alert('帳號或密碼錯誤');" . jlo('../front/login.php') . "</script>";
        }
        break;

    // ---- 會員登出 ----
    case 'logout':
        unset($_SESSION['user']);
        unset($_SESSION['id']);
        plo("../front/index.php");
        break;

    // ---- 送出訂單 ----
    case 'pay':
        if (empty($_SESSION['user']) || empty($_SESSION['buy'])) {
            plo("../front/buycart.php");
            break;
        }
        $re = select("q4t9_user", "id=" . intval($_SESSION['id']));
        if (!$re) {
            plo("../front/login.php");
            break;
        }
        $ro = $re[0];
        $post = [
            'acc'   => $ro['acc'],
            'name'  => $ro['name'],
            'tel'   => $ro['tel'],
            'addr'  => $ro['addr'],
            'mail'  => $ro['mail'],
            'total' => intval($_GET['total']),
            'date'  => date('Y-m-d'),
            'buy'   => serialize($_SESSION['buy']),
        ];
        insert($post, "q4t8_order");
        // 訂單成立後扣減對應商品庫存
        foreach ($_SESSION['buy'] as $pid => $pnum) {
            for ($i = 0; $i < intval($pnum); $i++) {
                update(['num-1' => intval($pid)], "q4t5_product");
            }
        }
        unset($_SESSION['buy']);
        echo "<script>alert('訂購成功，感謝您的參與！');" . jlo('../front/index.php') . "</script>";
        break;

    // ---- 管理者登入（訂單管理用） ----
    case 'adlogin':
        $acc = isset($_POST['acc']) ? $_POST['acc'] : '';
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        $ans = isset($_POST['ans']) ? intval($_POST['ans']) : null;
        $correctAns = isset($_SESSION['captcha']) ? intval($_SESSION['captcha']) : null;
        if ($correctAns === null || $ans !== $correctAns) {
            echo "<script>alert('驗證碼錯誤，請重新輸入');" . jlo('../back/adlogin.php') . "</script>";
            break;
        }
        unset($_SESSION['captcha']); // 驗證碼一次性使用
        $re = select("q4t10_admin", "acc='" . addslashes($acc) . "' and pwd='" . addslashes($pwd) . "'");
        if ($re) {
            $_SESSION['admin'] = $re[0]['acc'];
            plo("../back/order.php");
        } else {
            echo "<script>alert('管理者帳號或密碼錯誤');" . jlo('../back/adlogin.php') . "</script>";
        }
        break;

    // ---- 管理者登出 ----
    case 'adlogout':
        unset($_SESSION['admin']);
        plo("../front/index.php");
        break;

    // ---- 刪除訂單 ----
    case 'odrdel':
        if (empty($_SESSION['admin'])) {
            plo("../back/adlogin.php");
            break;
        }
        $post = ['del' => [intval($_GET['id'])]];
        delete($post, "q4t8_order");
        plo("../back/order.php");
        break;

    default:
        plo("../front/index.php");
        break;
}
