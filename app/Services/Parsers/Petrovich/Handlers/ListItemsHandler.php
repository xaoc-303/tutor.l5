<?php

namespace App\Services\Parsers\Petrovich\Handlers;

use App\Jobs\Parsers\Petrovich\ItemHandlerJob;
use Symfony\Component\DomCrawler\Crawler;

class ListItemsHandler extends AbstractHandler implements InterfaceHandler
{
    public function run()
    {
        $this->crawler
            ->filter('#products_section .listing__product-item .lisiting__product-title-block a')
            ->each(function (Crawler $crawler) {
                $node = $crawler->getNode(0);
                $this->data[$node->nodeValue] = $node->getAttribute('href');
            });
    }

    protected function getHandlerDataJob(&$hash)
    {
        return new ItemHandlerJob($hash);
    }
}
