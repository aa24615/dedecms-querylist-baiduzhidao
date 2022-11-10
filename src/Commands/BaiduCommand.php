<?php

namespace Zyan\DedeCmsQueryListBaiduzhidao\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zyan\DedeCmsQueryListBaiduzhidao\Services\BaiduService;

/**
 * Class BaiduCommand.
 *
 * @package Zyan\DedeCmsQueryListBaiduzhidao\Commands
 *
 * @author 读心印 <aa24615@qq.com>
 */

class BaiduCommand extends Command
{


    protected static $defaultName = 'baidu-zhidao';


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $baidu = new BaiduService();
        $baidu->get();

        return 0;
    }
}