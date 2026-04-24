<?php
include 'includes/auth.php';
include 'includes/config.php';

if (!isLoggedIn()) {
    redirectToLogin();
}

$user = $_COOKIE['user'];

// 处理删除留言
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // 检查权限
    $check_sql = "SELECT user FROM messages WHERE id='$id'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        if ($user === $row['user'] || isAdmin()) {
            $delete_sql = "DELETE FROM messages WHERE id='$id'";
            $conn->query($delete_sql);
        }
    }
    header('Location: report.php');
    exit;
}

// 处理添加留言
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    
    // 无过滤，直接插入数据库（存在XSS漏洞）
    $sql = "INSERT INTO messages (user, content) VALUES ('$user', '$content')";
    $conn->query($sql);
    header('Location: report.php');
    exit;
}

// 读取所有留言
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
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
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 100px;
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
        .messages {
            margin-top: 30px;
        }
        .message {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .message-user {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .message-content {
            margin-bottom: 10px;
        }
        .message-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .message-time {
            font-size: 12px;
            color: #666;
        }
        .delete-btn {
            color: #f44336;
            text-decoration: none;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 3px;
            background-color: #ffebee;
        }
        .delete-btn:hover {
            background-color: #ffcdd2;
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
        <h1>留言板</h1>
        <form method="POST">
            <div class="form-group">
                <label for="content">留言内容</label>
                <textarea id="content" name="content" placeholder="请输入留言" required></textarea>
            </div>
            <button type="submit">提交留言</button>
        </form>
        <div class="messages">
            <h2>留言列表</h2>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="message">
                    <div class="message-user">作者: <?php echo $row['user']; ?></div>
                    <div class="message-content"><?php echo $row['content']; ?></div>
                    <div class="message-footer">
                        <span class="message-time"><?php echo $row['created_at']; ?></span>
                        <?php if ($user === $row['user'] || isAdmin()): ?>
                            <a href="report.php?delete=<?php echo $row['id']; ?>" class="delete-btn">删除</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>