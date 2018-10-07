<?php
session_start();
if (!isset($_REQUEST['cmd']) || $_REQUEST['cmd'] != "checkLogin") {
    exit;
}
if (isset($_SESSION['USER'], $_SESSION['NAME']) && $_SESSION['USER'] != '') {
    echo '{"login":true,"name":"' . $_SESSION['NAME'] . '"}';
} else {
    echo '{"login":false}';
}
