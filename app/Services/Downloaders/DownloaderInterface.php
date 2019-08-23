<?php

namespace App\Services\Downloaders;

interface DownloaderInterface
{
    public function download();
    public function getAlias();
    public function getResponses();
    public function getServiceName();
    public function getResponseHeaders();
    public function getResponseContent();
    public function getResponseCode();
}
