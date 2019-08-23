<?php

namespace App\Services\Parsers\Petrovich;

use App\Jobs\Parsers\MainHandlerJob;
use App\Services\Downloaders\DownloaderInterface;
use App\Services\Downloaders\Curl\DownloaderProxyService;
use App\Services\Parsers\Petrovich\Handlers\InterfaceHandler;
use App\Services\Parsers\Petrovich\Handlers\MainHandler;
use Illuminate\Support\Facades\Redis;

class PetrovichParser
{
    /**
     * @var DownloaderInterface
     */
    private $downloader;

    protected $alias = 'Petrovich';

    public function run($items, $handler)
    {
        if (MainHandler::class == $handler) {
            $items = ['main' => ''];
        }

        if (!is_array($items)) {
            $redis = Redis::connection();
            $items = $redis->hgetall($items);
        }

        $this->parse($items, $handler);
    }

    public function parse($items, $handler)
    {
        foreach ($items as $item => $url) {

            $this->downloader = new DownloaderProxyService('https://petrovich.ru'.$url, $this->alias);
            $this->downloader->download();

            if ($this->downloader->getResponseCode() !== 200) {
                echo $this->downloader->getResponseCode().PHP_EOL;
                return;
            }

            echo $item . PHP_EOL;

            $handler = new $handler();
            /** @var $handler InterfaceHandler */
            $handler->setDownloader($this->downloader);
            $handler->run();
            $handler->saveData();
        }
    }
}
