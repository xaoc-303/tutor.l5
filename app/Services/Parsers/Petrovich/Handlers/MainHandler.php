<?php

namespace App\Services\Parsers\Petrovich\Handlers;

use App\Jobs\Parsers\Petrovich\SubHandlerJob;
use Symfony\Component\DomCrawler\Crawler;

class MainHandler extends AbstractHandler implements InterfaceHandler
{
    public function run()
    {
        $this->crawler
            ->filter('.column_left_catalog li')
            ->each(function (Crawler $crawler) {
                foreach ($crawler->children() as $child) {
                    $this->data[$child->nodeValue] = $child->getAttribute('href');
                }
            });
    }

    protected function getHandlerDataJob(&$hash)
    {
        return new SubHandlerJob($hash);
    }
}
