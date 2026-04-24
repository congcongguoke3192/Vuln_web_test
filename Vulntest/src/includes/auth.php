<?php
// 认证功能

// 检查用户是否登录
function isLoggedIn() {
    return isset($_COOKIE['user']);
}

// 检查是否为管理员
function isAdmin() {
    return isset($_COOKIE['user']) && $_COOKIE['user'] === 'admin';
}

// 重定向到登录页面
function redirectToLogin() {
    header('Location: login.php');
    exit;
}

// 重定向到首页
function redirectToHome() {
    header('Location: home.html');
    exit;
}

// 检查管理员权限
function checkAdmin() {
    if (!isAdmin()) {
        die('无权限访问');
    }
}
?>