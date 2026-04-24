FROM php:8.1-apache

# 安装必要的扩展
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 启用Apache模块
RUN a2enmod rewrite

# 设置工作目录
WORKDIR /var/www/html

# 复制源代码
COPY src/ /var/www/html/

# 设置权限
RUN chown -R www-data:www-data /var/www/html/

# 暴露端口
EXPOSE 80