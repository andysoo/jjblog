<?php
require_once 'config.php';
if (isset($_SESSION['USER'], $_REQUEST['cmd'], $_REQUEST['parent_id']) && $_REQUEST['cmd'] == 'delete') {
    $id  = $_REQUEST['parent_id'];
    $sql = "DELETE FROM `posts` WHERE parent_id = '{$id}'";
    if ($pdo->exec($sql)) {
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
}
