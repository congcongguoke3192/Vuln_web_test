# PHP漏洞靶场

一个基于Docker的PHP漏洞靶场，用于测试防火墙的漏洞防护能力。

## 功能模块

- **SQL注入**：登录/注册页面使用原始SQL拼接，无过滤
- **命令注入**：Ping功能使用shell执行命令，无过滤
- **XSS**：留言板无过滤直接显示内容
- **文件包含**：使用file\_get\_contents包含文件，无过滤
- **权限控制**：管理员可访问编辑功能，普通用户只能删除自己的留言

## 技术栈

- PHP 8.1
- MySQL 8.0
- Docker & Docker Compose
- Apache

## 构建步骤

### 1. 克隆项目

```bash
git clone <repository-url>
cd Vulntest
```

### 2. 构建并启动容器

```bash
docker-compose up -d
```

服务将运行在 `http://localhost:3009`

### 3. 初始账号

- **管理员账号**：admin
- **密码**：guardrails

## 测试说明

### SQL注入测试

1. 访问登录页面：`http://localhost:3009/login.php`
2. 在用户名输入框中输入SQL注入payload，例如：
   - `' OR 1=1#`
   - `' OR 'a'='a`
3. 密码任意输入，点击登录

### 命令注入测试

1. 登录后访问Ping测试页面：`http://localhost:3009/ping.php`
2. 在IP地址输入框中输入命令注入payload，例如：
   - `127.0.0.1; ls -la`
   - `127.0.0.1 && dir`
3. 点击Ping按钮

### XSS测试

1. 登录后访问留言板：`http://localhost:3009/report.php`
2. 在留言内容中输入XSS payload，例如：
   - `<script>alert('XSS')</script>`
   - `<img src='x' onerror='alert(1)'>`
3. 提交留言，查看留言列表

### 文件包含测试

1. 访问文件读取页面：`http://localhost:3009/read.php`
2. 在URL中添加file参数，例如：
   - `http://localhost:3009/read.php?file=/etc/passwd`
   - `http://localhost:3009/read.php?file=php://filter/read=convert.base64-encode/resource=./admin/edit.php`

### 权限控制测试

1. 使用普通用户登录，尝试删除其他用户的留言（应该失败）
2. 使用管理员账号登录，尝试删除所有用户的留言（应该成功）
3. 尝试访问管理员编辑页面：`http://localhost:3009/admin/edit.php`（普通用户应该被拒绝）

## 目录结构

```
├── docker-compose.yml    # Docker Compose配置文件
├── Dockerfile            # Docker构建文件
├── init.sql              # 数据库初始化脚本
├── README.md             # 项目说明
└── src/                  # 源代码目录
    ├── login.php         # 登录页面（SQL注入漏洞）
    ├── register.php      # 注册页面（SQL注入漏洞）
    ├── home.html         # 网络测速面板
    ├── ping.php          # Ping功能（命令注入漏洞）
    ├── report.php        # 留言板（XSS漏洞）
    ├── read.php          # 文件包含功能
    ├── readme.html       # 使用说明
    ├── admin/
    │   └── edit.php      # 管理员编辑功能
    └── includes/
        ├── config.php    # 数据库配置
        └── auth.php      # 认证功能
```

## 安全注意事项

- 本靶场仅用于测试目的，请勿在生产环境部署
- 包含多个已知漏洞，用于测试防火墙防护能力
- 测试完成后请及时停止并删除容器

## 停止服务

```bash
docker-compose down
```

## 许可证

MIT
