<?php
require_once 'config.php';
if (isset($_SESSION['USER'], $_REQUEST['cmd'], $_REQUEST['rid'], $_REQUEST['tid']) && $_REQUEST['cmd'] == 'delreply') {
    $rid = $_REQUEST['rid'];
    $tid = $_REQUEST['tid'];
    if ($_REQUEST['user'] == $_SESSION['USER']) {
        $sql = "DELETE FROM `replies` WHERE `id` = '{$rid}'";
        if ($pdo->exec($sql)) {
            $sql  = "SELECT * FROM `replies` WHERE `parent_id`='{$tid}'";
            $req  = $pdo->query($sql);
            $data = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                echo '<li class="list-group-item"><div class="panel-body"><span>';
                echo $row['user_id'];
                echo '</span> <span>';
                echo $row['post_date'];
                echo '</span>';
                echo '<p>';
                echo $row['content'];
                echo '</p><span style="display:none">';
                echo $row['id'];
                echo '</span><button class="btn btn-danger btn-xs" style="float:right">删除回帖</button></div></li>';
            }
        }
    } else {
        echo '你不是楼主，不能删除回贴';
    }
} else {
    echo '请登录！';
}
