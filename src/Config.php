<?php


namespace Zyan\DedeCmsQueryListBaiduzhidao;

use think\facade\Db as Tdb;

class Config
{
    protected static $keys = [];

    public static function initDB($dbPath = __DIR__.'/../../data/common.inc.php'){

        require $dbPath;

        Tdb::setConfig([
            // 默认数据连接标识
            'default'     => 'mysql',
            // 数据库连接信息
            'connections' => [
                'mysql' => [
                    // 数据库类型
                    'type'     => 'mysql',
                    // 主机地址
                    'hostname' => $cfg_dbhost,
                    // 用户名
                    'username' => $cfg_dbuser,

                    'password' => $cfg_dbpwd,
                    // 数据库名
                    'database' => $cfg_dbname,
                    // 数据库编码默认采用utf8
                    'charset'  => $cfg_db_language,
                    // 数据库表前缀
                    'prefix'   => $cfg_dbprefix,
                    // 数据库调试模式
                    'debug'    => true,
                ],
            ],
        ]);

    }

    public static function getKeys(){
        return self::$keys;
    }

    public static function setKeys(array $keys){
        self::$keys = $keys;
    }
}