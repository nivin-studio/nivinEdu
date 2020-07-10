# nivinEdu
高校教务爬虫，可查询学生个人信息，成绩，课表等。已支持正方教务，青果教务。

体验地址: [edu.nivin.cn](http://edu.nivin.cn/)

## 环境要求

	php: ^7.0

	--php扩展--
	redis
	phalcon: ~3.4.4

## 支持院校

### 正方教务

- :white_check_mark: 池州学院
- :white_check_mark: 四川大学锦江学院

### 青果教务

- :white_check_mark: 西南科技大学

## 安装使用

- 配置修改

```bash
app/config/config.php
```

- 依赖安装

```bash
composer install
```

[Nginx服务器配置参考](https://www.kancloud.cn/jaya1992/phalcon_doc_zh/753243#Nginx_46)

[Apache服务器配置参考](https://www.kancloud.cn/jaya1992/phalcon_doc_zh/753243#Apache_148)

本系统使用[Phalcon](https://phalcon.io/zh-cn)框架，[中文开发文档](https://www.kancloud.cn/jaya1992/phalcon_doc_zh)
