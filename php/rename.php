<?php
require_once 'config.php';
$res = [
    'rename' => false,
    'info'   => [
        'user' => '',
        'pass' => '',
        'name' => '',
    ],
];
if (isset($_REQUEST['newName'], $_SESSION['NAME'])) {
    $newName  = $_REQUEST['newName'];
    $oldName  = $_SESSION['NAME'];
    $sql      = "UPDATE `users` SET `name`='{$newName}' WHERE `name`='{$oldName}'";
    $affected = $pdo->exec($sql);
    if ($affected) {
        $_SESSION['NAME'] = $newName;
        $sql              = "SELECT * FROM `users` WHERE `name`='{$newName}'";
        $req              = $pdo->query($sql);
        $data             = $req->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $res['rename']       = true;
            $res['info']['user'] = $data['user'];
            $res['info']['pass'] = $data['pass'];
            $res['info']['name'] = $data['name'];
        }
    }
}
echo json_encode($res);
