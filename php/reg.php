<?php
require_once 'config.php';
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'reg') {
    if (isset($_REQUEST['user'], $_REQUEST['pass'], $_REQUEST['name'])) {
        $user = trim($_REQUEST['user']);
        $pass = trim($_REQUEST['pass']);
        $name = trim($_REQUEST['name']);
        $pass = md5(md5($pass) . $salt);
        $sql  = "INSERT INTO `users` (`user`,`pass`,`name`) VALUES ('{$user}','{$pass}','{$name}')";
        if ($pdo->exec($sql)) {
            echo '{"reg":true}';
        } else {
            echo '{"reg":false}';
        }
    }
}
