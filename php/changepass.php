<?php
require_once 'config.php';
$res = [
    'changepass' => false,
    'info'       => [
        'user' => '',
        'pass' => '',
        'name' => '',
    ],
];
if (isset($_REQUEST['newpass'], $_SESSION['USER'])) {
    $newPass  = $_REQUEST['newpass'];
    $newPass  = md5(md5($newPass) . $salt);
    $user     = $_SESSION['USER'];
    $sql      = "UPDATE `users` SET `pass`='{$newPass}' WHERE `user`='{$user}'";
    $affected = $pdo->exec($sql);
    if ($affected) {
        $sql  = "SELECT * FROM `users` WHERE `user`='{$user}'";
        $req  = $pdo->query($sql);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $res['changepass']   = true;
            $res['info']['user'] = $data['user'];
            $res['info']['pass'] = $data['pass'];
            $res['info']['name'] = $data['name'];
        }
    }
}
echo json_encode($res);
