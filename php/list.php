<?php
require_once 'config.php';
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'list') {
    $sql  = "SELECT `parent_id`,`title`,`readed` FROM `posts` LIMIT 0,10";
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

if (isset($_REQUEST['parent_id'])) {
    $id   = $_REQUEST['parent_id'];
    $sql  = "SELECT `readed` FROM `posts` WHERE `parent_id`='{$id}'";
    $req  = $pdo->query($sql);
    $data = $req->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        $readed   = $data['readed'] + 1;
        $sql      = "UPDATE `posts` SET `readed`='{$readed}' WHERE `parent_id`='{$id}'";
        $affected = $pdo->exec($sql);
        if ($affected) {
            $sql  = "SELECT * FROM `posts` WHERE `parent_id`='{$id}'";
            $req  = $pdo->query($sql);
            $data = $req->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        }
    }
}
