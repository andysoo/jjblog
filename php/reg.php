<?php
$salt = 'JJ2018';

if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'reg') {
    if (isset($_REQUEST['user'], $_REQUEST['pass'], $_REQUEST['name'])) {
        $user = trim($_REQUEST['user']);
        $pass = trim($_REQUEST['pass']);
        $name = trim($_REQUEST['name']);
        $pass = md5(md5($pass) . $salt);
        $pdo  = new PDO('mysql:host=127.0.0.1;dbname=jjblog', 'root', 'root');
        $sql  = "INSERT INTO `users` (`user`,`pass`,`name`) VALUES ('{$user}','{$pass}','{$name}')";
        if ($pdo->exec($sql)) {
            echo '{"reg":true}';
        } else {
            echo '{"reg":false}';
        }
    }
}
