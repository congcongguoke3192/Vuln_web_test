<?php
// 数据库配置
$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME') ?: 'vulntest';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'password';

// 连接数据库
$conn = new mysqli($host, $user, $pass, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
?>