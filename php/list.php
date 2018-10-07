<?php
require_once 'config.php';
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'list') {
    $sql  = "SELECT `parent_id`,`title`,`content` FROM `posts` LIMIT 0,10";
    $req  = $pdo->query($sql);
    $data = $req->fetchALL(PDO::FETCH_ASSOC);
    foreach ($data as $row) {
        echo '<div class="panel panel-default"><div class="panel-heading" role="tab" id="heading';
        echo $row['parent_id'];
        echo '"><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse';
        echo $row['parent_id'];
        echo '" aria-expanded="true" aria-controls="collapse';
        echo $row['parent_id'];
        echo '">';
        echo $row['title'];
        echo '</a></h4></div><div id="collapse';
        echo $row['parent_id'];
        echo '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading';
        echo $row['parent_id'];
        echo '"><div class="panel-body">';
        echo $row['content'];
        echo '</div></div></div>';
    }
}
