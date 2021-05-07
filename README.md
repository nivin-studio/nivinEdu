![nivinEdu](https://socialify.git.ci/nivin-studio/nivinEdu/image?description=1&forks=1&logo=https%3A%2F%2Fnivin.cn%2Fimages%2Flogos.png&pattern=Brick%20Wall&stargazers=1)
# 关于nivinEdu
拟物校园，一个开源的高校教务移动化解决方案。可快速对接正方，青果，URP等教务，方便学生在移动端查询个人信息，成绩，课表等。

体验地址: [edu.nivin.cn](http://edu.nivin.cn/)

## 环境要求
- PHP >= 7.3.0
- BCMath PHP 拓展
- Ctype PHP 拓展
- JSON PHP 拓展
- Mbstring PHP 拓展
- OpenSSL PHP 拓展
- PDO PHP 拓展
- Tokenizer PHP 拓展
- XML PHP 拓展

## 安装使用

- 获取代码

```bash
git clone https://github.com/nivin-studio/nivinEdu.git
git checkout 1.0
```

- 安装依赖

> Laravel 使用 Composer 来管理项目依赖。因此，在使用 Laravel 之前，请确保你的机器已经安装了 Composer。
```bash
composer install
```

- 创建配置，在.env中添加数据库配置

```bash
composer run-script init-project
```

- 添加必要目录权限

```bash
chmod -R 777 storage bootstrap/cache
```

- 修改配置文件.env


- 运行Migrate，创建数据表

```bash
php artisan migrate
```

- 运行Seeders，导入初始数据

```bash
php artisan db:seed
```

- 运行访问

```text
首页地址：http://127.0.0.1/

移动地址：http://127.0.0.1/mobile

后台地址：http://127.0.0.1/admin  账号：admin@nivin.cn 密码：123456
```

## 支持院校

### 正方教务

- :white_check_mark: 池州学院
- :white_check_mark: 四川大学锦江学院

### 青果教务

- :white_check_mark: 西南科技大学
- :white_check_mark: 吕梁学院
- :white_check_mark: 河南开封科技传媒学院
- :white_check_mark: 郑州经贸学院

### URP教务

- :white_check_mark: 华北理工大学
- :white_check_mark: 湛江幼儿师范专科学校

## API文档
+ [API文档](https://edu-nivin.doc.coding.io)

## 鸣谢
+ [Laravel](https://laravel.com/)
+ [Dact Admin](http://www.dcatadmin.com/)
