<?php


namespace Zyan\Tests;


use PHPUnit\Framework\TestCase;
use think\facade\Db;
use Zyan\DedeCmsXlsxToData\Xlsx;

class DBTest extends TestCase
{
    public function test_xa(){
        print_r(basename(parse_url('http://zhidao.baidu.com/question/472795409.html?url=123ssd23')['path'],'.html'));
    }
    public function test_db(){


        $to = new Xlsx();

        foreach ($to->getFiles() as $file){
            $data = $to->getData($file);
            foreach ($data as $key=>$val){
                $url  = explode('?',trim($val['H']))[0] ?? '';
                $md5 = md5($url);

                $title  = trim($val['B']);
                $body  = trim($val['E']);
                $keywords  = trim($val['D']);
                $description  = trim($val['C']);
                $typeid  = trim($val['G']);
                $litpic  = '/'.trim($val['F']);

                if($key<=1 || empty($body) || empty($title)){
                    continue;
                }

                $temp = [
                    'typeid' => $typeid,
                    'title' => $title,
                    'keywords' => $keywords,
                    'description' => $description,
                    'shorttitle' => $md5,
                    'voteid' => '1',
                    'sortrank' => time(),
                    'pubdate' => time(),
                    'senddate' => time(),
                    'lastpost' => time(),
                    'flag' => 'p',
                    'litpic' => $litpic,
                ];

                if(!Db::name('archives')->field('shorttitle')
                    ->where("shorttitle='{$md5}'")
                    ->find()){
                    $aid = Db::name('archives')->insertGetId($temp);
                    Db::name('addonarticle')->insert([
                        'aid' => $aid,
                        'typeid' => $typeid,
                        'body' => $body
                    ]);
                }
            }
        }

        $this->assertTrue(true);
    }
}