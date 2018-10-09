<?php
require_once 'config.php';
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
