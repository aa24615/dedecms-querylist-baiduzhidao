<?php


namespace Zyan\DedeCmsQueryListBaiduzhidao\Services;

use GuzzleHttp\Client;
use Symfony\Component\Filesystem\Filesystem;
use Zyan\QLPlugin\Baiduzhidao;
use QL\QueryList;
use liliuwei\pscws4\PSCWS4API;

class BaiduService
{
    public function logs($str){
        echo $str.PHP_EOL;
    }
    public function get(){

        $ql = QueryList::getInstance();
        $ql->use(Baiduzhidao::class);

        $keys = [
//            1=>'USB数据线',
//            2=>'USB3.0数据线',
//            3=>'USB3.2数据线',
//            4=>'USB4数据线',
//            5=>'雷电数据线',
//            7=>'HDMI高清线',
//            8=>'DP连接线',
//            9=>'DVI/VGA线',
//            11=>'HUB扩展坞',
//            12=>'USB转接线',
            13=>'机箱扩展面板',
            14=>'视频转接线',
        ];


        $baidu = $ql->baiduzhidao();
        $pscws4 = new PSCWS4API();
        $article = new ArticleService();


        foreach ($keys as $typeid=>$key){
            $p=1;
            while ($p<9){
                $this->logs('key:'.$key);
                $list =  $baidu->search($key)->getList($p);
                sleep(5);
                $p++;
                foreach ($list as $data){

                    $this->logs('===============================================');

                    $title = $data['title'];
                    $url = explode('?',$data['link'])[0] ?? '';
                    $description = $data['best_answer'];

                    if(empty($url) || substr($url,0,4)!=='http'){
                        continue;
                    }
                    $this->logs('url:'.$url);

                    if($article->is($url)){
                        $this->logs($title.':已存在');
                        continue;
                    }

                    $body = $baidu->getBody($url);
                    $body = join('',$body);

                    sleep(1);

                    if(!$title || !$body){
                        continue;
                    }

                    $list = $ql->setHtml($body)->find('img')->attrs('src');

                    $http = new Client();

                    $file = new Filesystem();
                    $path = '/uploads/'.date('Ym/d/');
                    $file->mkdir(ROOT.$path);

                    $pic = [];
                    foreach ($list as $picUrl){
                        $this->logs('picUrl:'.$picUrl);
                        try {
                            $res = $http->get($picUrl);
                            $data = $res->getBody()->getContents();
                            sleep(1);
                            $filename = $path.uniqid(date('His')).'.jpg';
                            $pic[] = $filename;
                            file_put_contents(ROOT.$filename,$data);
                            $body = str_replace($picUrl,$filename,$body);
                        }catch (\Exception $exception){

                        }
                    }

                    $keywords = $pscws4->PSCWS4_TOP($body);
                    $keywords = join(',',$keywords);
                    $article->add($typeid,$title,$keywords,$description,$pic[0] ?? '',$url,$body);

                    $this->logs($title.':成功');
                }

            }
        }

    }
}