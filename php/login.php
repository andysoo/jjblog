<?php
require_once 'config.php';
$res = [
    'err'  => true,
    'txt'  => '表单参数错误！',
    'info' => [
        'user' => '',
        'pass' => '',
    ],
];
if (isset($_REQUEST['user'], $_REQUEST['pass'])) {
    if (isset($_REQUEST['cmd'], $_REQUEST['code'], $_SESSION['code']) && $_REQUEST['cmd'] == 'login' && $_REQUEST['code'] != '') {
        if ($_REQUEST['code'] != $_SESSION['code']) {
            $res['txt'] = '错误的验证码!';
            exit(json_encode($res));
        }
    }
    $user = trim($_REQUEST['user']);
    $pass = trim($_REQUEST['pass']);
    if (strlen($pass) != 32) {
        $pass = md5(md5($pass) . $salt);
    }
    $sql  = "SELECT `name` FROM `users` WHERE user='{$user}' AND pass='{$pass}'";
    $req  = $pdo->query($sql);
    $data = $req->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        $_SESSION['USER']    = $user;
        $_SESSION['NAME']    = $data['name'];
        $res['err']          = false;
        $res['txt']          = '登陆成功';
        $res['info']['user'] = $user;
        $res['info']['pass'] = $pass;
        $res['info']['name'] = $data['name'];
    } else {
        $res['txt'] = '错误的用户名或密码!';
    }
}
echo json_encode($res);
