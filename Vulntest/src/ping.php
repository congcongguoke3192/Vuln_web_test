<?php
include 'includes/auth.php';

if (!isLoggedIn()) {
    redirectToLogin();
}

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_POST['ip'];
    
    // 无过滤，直接执行shell命令（存在命令注入漏洞）
    // 适配不同操作系统的ping命令参数
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $command = "ping -n 4 $ip";
    } else {
        $command = "ping -c 4 $ip";
    }
    $output = shell_exec($command);
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ping测试</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .output {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            white-space: pre-wrap;
            font-family: monospace;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="home.html">返回首页</a>
        </div>
        <h1>Ping测试</h1>
        <form method="POST">
            <div class="form-group">
                <label for="ip">IP地址</label>
                <input type="text" id="ip" name="ip" placeholder="请输入IP地址" required>
            </div>
            <button type="submit">Ping</button>
        </form>
        <?php if ($output): ?>
            <div class="output">
                <?php echo htmlspecialchars($output); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>