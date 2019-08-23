<?php

namespace App\Services\Parsers\Petrovich\Handlers;

use App\Services\Downloaders\DownloaderInterface;

interface InterfaceHandler
{
    public function run();
    public function setDownloader(DownloaderInterface $downloader);
    public function getData();
    public function saveData();
}
