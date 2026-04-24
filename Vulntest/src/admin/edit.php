<?php
include '../includes/auth.php';

// 检查管理员权限
checkAdmin();

$file = $_GET['file'] ?? 'readme.html';
$content = file_get_contents('../' . $file);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_content = $_POST['content'];
    file_put_contents('../' . $file, $new_content);
    $content = $new_content;
    $success = '文件修改成功';
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员编辑</title>
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
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 400px;
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
        .success {
            color: green;
            margin-bottom: 15px;
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
            <a href="../home.html">返回首页</a>
        </div>
        <h1>管理员编辑</h1>
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="file">文件路径</label>
                <input type="text" id="file" name="file" value="<?php echo $file; ?>" required>
            </div>
            <div class="form-group">
                <label for="content">文件内容</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>
            </div>
            <button type="submit">保存修改</button>
        </form>
    </div>
</body>
</html>