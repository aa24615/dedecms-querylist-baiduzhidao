<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Zyan\DedeCmsQueryListBaiduzhidao\Commands\BaiduCommand;
use Zyan\DedeCmsQueryListBaiduzhidao\Config;

define('ROOT',__DIR__);

Config::initDB(__DIR__.'/../data/common.inc.php');

Config::setKeys([
    1=>'USB数据线',
    2=>'USB3.0数据线',
    3=>'USB3.2数据线',
    4=>'USB4数据线',
    5=>'雷电数据线',
    7=>'HDMI高清线',
    8=>'DP连接线',
    9=>'DVI/VGA线',
    11=>'HUB扩展坞',
    12=>'USB转接线',
    13=>'机箱扩展面板',
    14=>'视频转接线',
]);

$app = new Application();

$app->add(new BaiduCommand());

$app->run();