<?php

namespace App\Services\Downloaders\Curl;

use Curl\Curl;
use App\Services\Downloaders\DownloaderAbstractService;
use Illuminate\Support\Facades\Log;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'Curl';

    public function download()
    {
        $headers = [
            'Content-Type' => 'text/plain',
            'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
        ];

        $client = new Curl();
        $client->setHeaders($headers);
        $client->get($this->requestUrls);

        $this->responseCode = $client->getHttpStatusCode();
        $this->responseHeaders = $client->getResponseHeaders();
        $this->responseContent = $client->getResponse();

        Log::info(__METHOD__ . ':'.$this->responseCode.':'.$this->requestUrls);

        file_put_contents(storage_path('app') . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', $client->getResponse());

        $client->close();
    }
}
