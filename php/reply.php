<?php
require_once 'config.php';
$id = $_REQUEST['parent_id'];
if (isset($_REQUEST['cmd'], $_REQUEST['parent_id']) && $_REQUEST['cmd'] == 'replies') {
    $sql  = "SELECT * FROM `replies` WHERE `parent_id`='{$id}'";
    $req  = $pdo->query($sql);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        echo '<li class="list-group-item"><div class="panel-body"><span>';
        echo $row['user_id'];
        echo '</span> <span>';
        echo $row['post_date'];
        echo '</span><span style="display:none">';
        echo $row['id'];
        echo '</span><p>';
        echo $row['content'];
        echo '</p></div></li>';
    }
}
if (isset($_REQUEST['cmd'], $_REQUEST['parent_id']) && $_REQUEST['cmd'] == 'reply') {
    if (!isset($_SESSION['USER'])) {
        exit('不是注册用户');
    }
    if (isset($_REQUEST['content'])) {
        $content = $_REQUEST['content'];
        $user    = $_SESSION['USER'];
        $time    = date("Y-m-d H:i:s", time());
        $sql     = "INSERT INTO `replies` (`parent_id`,`user_id`,`content`,`post_date`) VALUES
                ('{$id}','{$user}','{$content}','{$time}')";
        if ($pdo->exec($sql)) {
            $sql  = "SELECT * FROM `replies` WHERE `parent_id`='{$id}'";
            $req  = $pdo->query($sql);
            $data = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                echo '<li class="list-group-item"><div class="panel-body"><span>';
                echo $row['user_id'];
                echo '</span> <span>';
                echo $row['post_date'];
                echo '</span><span style="display:none" id="rtid">';
                echo $row['id'];
                echo '</span><p>';
                echo $row['content'];
                echo '</p></div></li>';
            }
        }
    }
}
