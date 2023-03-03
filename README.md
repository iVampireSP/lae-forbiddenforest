# 莱云 模块

## 这是 莱云 的集成模块

您可以克隆此仓库，然后再次基础上开发出适用于 莱云 的集成模块，以拓展功能。

## 初始化模块

1. 安装依赖
2. 配置 .env 文件
3. 运行 yarn dev
4. 开始编写您的业务代码

## 安装依赖

执行 composer install

```bash
composer install
```

执行 yarn

```bash
yarn
```

## 配置 .env 文件

```bash
cp .env.example .env
```

## 发布视图

```bash
php artisan vendor:publish --provider="ivampiresp\Cocoa\CocoaServiceProvider"
```

## 执行迁移

```bash
php artisan migrate
```

## 运行 yarn dev

```bash
yarn dev
```

## 开始编写您的业务代码

这里是您的业务代码主要编写的地方。

```text
app/Actions/HostAction.php
```

## 创建第一个管理员

```bash
php artisan admin:create
```

## 修改管理员密码

```bash
php artisan admin:change-password
```
