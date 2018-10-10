<?php
require_once 'config.php';
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'list') {
    $sql  = "SELECT `parent_id`,`title`,`readed` FROM `posts` ORDER BY parent_id DESC LIMIT 10";
    $req  = $pdo->query($sql);
    $data = $req->fetchALL(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        echo '<a href="#" class="list-group-item"><span style="display:none" id="parent_id">';
        echo $row['parent_id'];
        echo '</span>';
        echo $row['title'];
        echo '<span class="badge"><span class="glyphicon glyphicon-eye-open"></span> ';
        echo $row['readed'];
        echo '</span></a>';
    }
}

if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'mylist') {
    if (!isset($_SESSION['USER'])) {
        exit('请登录');
    }
    $user = $_SESSION['USER'];
    $sql  = "SELECT * FROM `posts` WHERE `user_id`='{$user}'";
    $req  = $pdo->query($sql);
    $data = $req->fetchALL(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        echo '<a href="#" class="list-group-item"><span style="display:none" id="parent_id">';
        echo $row['parent_id'];
        echo '</span>';
        echo $row['title'];
        echo '<span class="glyphicon glyphicon-remove-circle" style="float:right"></span></a>';
    }
}
