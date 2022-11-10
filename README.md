

# zyan/dedecms-querylist-baiduzhidao

织梦cms querylist采集百度知道 一健入库

## 要求

1. php >= 7.2
2. Composer 2.x

## 前提

需要手动把 `xxx_archives` 表 `shorttitle` `litpic` `description` 字段长度改为200以上

## 安装

```shell
composer require zyan/dedecms-querylist-baiduzhidao -vvv
```
## 用法

在 `dedecms` 根目录或子目录新建一个 `app.php`

```php
<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Zyan\DedeCmsQueryListBaiduzhidao\Commands\BaiduCommand;
use Zyan\DedeCmsQueryListBaiduzhidao\Config;

define('ROOT',__DIR__);

//配置mysql连接 传 dede中的配置路径 如果是根目录则是 `__DIR__.'/data/common.inc.php`
Config::initDB(__DIR__.'/../data/common.inc.php');

//需要问答的关健词
Config::setKeys([
    1=>'php官网是什么', // 栏目id => 百度关健词
]);

$app = new Application();

$app->add(new BaiduCommand());

$app->run();
```

## 运行

```shell
php app.php baidu-zhidao
```

> 注意: 一次关健词不要过多,否则百度会短时间内屏蔽ip

## 然后

将同级 `app.php` 中图片附件 `uploads` 目录 做软链或nginx资源重定向即可

进入dedecms后台 找到栏目  清除栏目缓存 重新生成静态页面即可




## 参与贡献

1. fork 当前库到你的名下
3. 在你的本地修改完成审阅过后提交到你的仓库
4. 提交 PR 并描述你的修改，等待合并

## License

[MIT license](https://opensource.org/licenses/MIT)
