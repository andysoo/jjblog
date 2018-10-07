<?php
session_start();
$salt = 'JJ2018';
$c    = [
    'host' => '127.0.0.1',
    'name' => 'jjblog',
    'user' => 'root',
    'pass' => 'root',
];
try {
    $pdo = new PDO("mysql:host={$c['host']};dbname={$c['name']}", $c['user'], $c['pass']);
    // po('数据库连接成功！');
    return $pdo;
} catch (Exception $e) {
    // po('连接失败：' . $e->getMessage());
    return $e->getMessage();
}
