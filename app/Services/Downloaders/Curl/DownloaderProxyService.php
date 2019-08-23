<?php

namespace App\Services\Downloaders\Curl;

use App\Services\Downloaders\DownloaderProxyAbstract;

class DownloaderProxyService extends DownloaderProxyAbstract
{
    public function __construct($urls, $alias)
    {
        $this->downloader = new DownloaderService($urls, $alias);
    }
}
