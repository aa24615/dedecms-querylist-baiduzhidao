<?php


namespace Zyan\DedeCmsQueryListBaiduzhidao\Services;


use think\facade\Db;

class ArticleService
{
    public function add($typeid,$title,$keywords,$description,$litpic,$url,$body){
        $id = basename(parse_url($url)['path'],'.html');;
        $temp = [
            'typeid' => $typeid,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'shorttitle' => ($url),
            'voteid' => '1',
            'sortrank' => time(),
            'pubdate' => time(),
            'senddate' => time(),
            'lastpost' => time(),
            'flag' => 'p',
            'litpic' => $litpic,
        ];

        if(!Db::name('archives')->field('shorttitle')->where("tackid={$id}")->find()){
            $aid = Db::name('archives')->insertGetId($temp);
            $this->addBody($aid,$typeid,$body);
        }

    }

    public function is($url){
        $id = basename(parse_url($url)['path'],'.html');;
        return Db::name('archives')->field('shorttitle')->where("tackid={$id}")->find();
    }

    public function addBody($aid,$typeid,$body){

            Db::name('addonarticle')->insert([
                'aid' => $aid,
                'typeid' => $typeid,
                'body' => $body
            ]);

    }
}