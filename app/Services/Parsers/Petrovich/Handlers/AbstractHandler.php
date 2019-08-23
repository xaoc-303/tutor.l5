<?php

namespace App\Services\Parsers\Petrovich\Handlers;

use App\Services\Downloaders\DownloaderInterface;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractHandler
{
    /**
     * @var DownloaderInterface
     */
    protected $downloader;

    /**
     * @var Crawler
     */
    protected $crawler;

    protected $data;
    protected $alias = 'Petrovich';

    public function setDownloader(DownloaderInterface $downloader)
    {
        $this->downloader = $downloader;
        $this->crawler = new Crawler($this->downloader->getResponseContent());
        $this->data = [];
    }

    public function getData()
    {
        return $this->data;
    }

    public function saveData()
    {
        Log::info(__METHOD__);

        $this->saveDataLog();

        if (is_array($this->data)) {
            $i = 0;
            foreach ($this->data as $key => $value) {
                $this->createWorker($this->getDataHash([$key => $value]));
                if (++$i > 1) {
                    $i = 0;
                    break;
                }
            }
        } else {
            $this->createWorker($this->getDataHash($this->data));
        }
    }

    protected function getDataHash($data)
    {
        $redis = Redis::connection();
        $hash = md5(json_encode($data));
        $redis->hmset($hash, $data);
        $redis->expire($hash, 3600);

        return $hash;
    }

    protected function createWorker($hash)
    {
        Log::info(__METHOD__);
        dispatch($this->getHandlerDataJob($hash))->onQueue('petrovich')->delay(Carbon::now()->addSeconds(mt_rand(3, 9)));
    }

    public function saveDataLog()
    {
        Log::info(__METHOD__);

        $filename  = storage_path('app');
        $filename .= DIRECTORY_SEPARATOR . $this->alias;
        $filename .= '.' . microtime(true);
        $filename .= '.' . (new \ReflectionClass($this))->getShortName() .'.json';

        $data = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

        file_put_contents($filename, $data);
    }

//    private function getNextJob(&$hash)
//    {
//        switch (get_class($this)) {
//            case MainHandler::class:
//                return new SubHandlerJob($hash);
//            case SubHandler::class:
//                return new ListItemsHandlerJob($hash);
//            case ListItemsHandler::class:
//                return new ItemHandlerJob($hash);
//            case ItemHandler::class:
//                return new ItemSaveJob($hash);
//        }
//    }
}
