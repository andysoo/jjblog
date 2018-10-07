<?php
session_start();
$a                = rand(10, 99);
$b                = rand(10, 99);
$c                = $a + $b;
$_SESSION['code'] = $c;
echo "$a+$b = ?";
