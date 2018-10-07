<?php
require_once 'config.php';
if (!isset($_REQUEST['cmd'])) {
    exit;
} elseif ($_REQUEST['cmd'] == 'logout') {
    unset($_SESSION['USER']);
    unset($_SESSION['NAME']);
    exit('{"logout":true}');
} else {
    exit('{"logout":false}');
}
