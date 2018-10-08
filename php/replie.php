<?php
require_once 'config.php';
if (isset($_REQUEST['parent_id'])) {
    $id   = $_REQUEST['parent_id'];
    $sql  = "SELECT * FROM `replies` WHERE `parent_id`='{$id}'";
    $req  = $pdo->query($sql);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        echo '<li class="list-group-item"><div class="panel-body"><span>';
        echo $row['user_id'];
        echo '</span><span>';
        echo $row['post_date'];
        echo '</span><p>';
        echo $row['content'];
        echo '</p></div></li>';
    }
}
