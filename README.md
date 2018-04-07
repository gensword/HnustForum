# HunstForum
## 项目概述
HnustForum 是一个基于 laravel 5.5 版本开发的社区。
项目演示地址 [HunstForum](http://www.51zixuea.cn/index)
后台演示地址 [后台管理](http://www.51zixuea.cn/admin)
## 项目运行环境
* php 7.1
* apache 2.4
* redis 3.0
* mysql 5.7
* nodejs 8.9

## 项目运行步骤
1. >git clone https://github.com/xzywdywjm/HnustForum.git
2. >composer install
3. >把 .env.example 重命名为 .env 并进行数据库和 redis 以及mail 相关配置，将 * QUEUE_DRIVER * 设置为 *redis*
4. >php artisan key:generate
5. >php artisan migrate
6. >php artisan admin:install 生成后台管理用户 admin，密码也为 admin
7. >php artisan queue：work
8. >node server.js
9. >配置你的 apache 或者 nginx 的服务器根目录至项目的 *public* 目录下即刻访问网站了

## 注意事项
请打开你的 PHP *gd* 扩展和 *fileinfo* 扩展，因为用到了 *mews/captcha* 这个验证码扩展包，如果不打开的话验证码图片将刷不出来