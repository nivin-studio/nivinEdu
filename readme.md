![nivinEdu](https://socialify.git.ci/nivin-studio/nivinEdu/image?description=1&font=Inter&forks=1&logo=https%3A%2F%2Fwww.nivin.cn%2Fimages%2Flogo.png&pattern=Signal&stargazers=1&theme=Light)
# 关于nivinEdu
高校教务爬虫，可查询学生个人信息，成绩，课表等。已支持正方教务，青果教务。

体验地址: [edu.nivin.cn](http://edu.nivin.cn/)

## 环境要求
- php >= 7.0.0
- laravel 5.5.*

## 支持院校

### 正方教务

- :white_check_mark: 池州学院
- :white_check_mark: 四川大学锦江学院

### 青果教务

- :white_check_mark: 西南科技大学
- :white_check_mark: 吕梁学院

## 安装使用

- 安装依赖

```bash
composer install
```

- 创建配置，在.env中添加数据库配置

```bash
composer run-script create-config
```

- 运行Migrate，创建数据表

```bash
php artisan migrate
```

- 运行Seeders，导入初始数据

```bash
php artisan db:seed
```

- 添加Laravel计划任务至Cron中(注：php和项目都需要绝对路径，可通过命令"which php"来查看的绝对路径)

```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

- 运行访问

```text
前台地址：http://127.0.0.1/

后台地址：http://127.0.0.1/admin  账号：admin 密码：admin
```

## 鸣谢
+ [Laravel](https://laravel.com/)
+ [Dact Admin](http://www.dcatadmin.com/)
