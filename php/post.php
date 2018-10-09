<?php
require_once 'config.php';
$res = [
    'login' => false,
    'add'   => false,
];
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'post') {
    if (!isset($_SESSION['USER'])) {
        exit('{"login":false}');
    }
    $user    = $_SESSION['USER'];
    $title   = $_REQUEST['title'];
    $content = $_REQUEST['content'];
    $time    = date("Y-m-d H:i:s", time());
    $sql     = "INSERT INTO `posts` (`user_id`,`title`,`content`,`post_date`)
                  VALUES ('{$user}','{$title}','{$content}','{$time}')";
    if ($pdo->exec($sql)) {
        $res['login'] = true;
        $res['add']   = true;
        echo json_encode($res);
    } else {
        echo json_encode($res);
    }
}
