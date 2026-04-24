<?php
include 'includes/auth.php';

// 文件包含功能
$file = $_GET['file'] ?? 'readme.html';
$content = file_get_contents($file);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文件读取</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-top: 0;
        }
        .content {
            margin-top: 20px;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            margin-right: 10px;
        }
        .login-link {
            margin-top: 20px;
            text-align: center;
        }
        .login-link a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <?php if (isLoggedIn()): ?>
                <a href="home.html">返回首页</a>
            <?php else: ?>
                <a href="login.php">登录</a>
                <a href="register.php">注册</a>
            <?php endif; ?>
        </div>
        <h1>文件内容</h1>
        <div class="content">
            <?php echo $content; ?>
        </div>
        <?php if (!isLoggedIn()): ?>
            <div class="login-link">
                登录后查看更多功能
            </div>
        <?php endif; ?>
    </div>
</body>
</html>