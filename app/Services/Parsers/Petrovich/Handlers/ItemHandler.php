<?php

namespace App\Services\Parsers\Petrovich\Handlers;

use App\Jobs\Parsers\Petrovich\ItemSaveJob;

class ItemHandler extends AbstractHandler implements InterfaceHandler
{
    public function run()
    {
        $page = $this->crawler->filter('.product_page');

        $title = $page
            ->filter('.product--title')
            ->getNode(0)
            ->nodeValue;

        $info = $page
            ->filter('.text--common')
            ->getNode(0)
            ->nodeValue;

        $price = $page
            ->filter('.retailPrice')
            ->getNode(0)
            ->nodeValue;

        $this->data[$title] = "(цена = $price р.)".PHP_EOL.$info;
    }

    protected function getHandlerDataJob(&$hash)
    {
        return new ItemSaveJob($hash);
    }
}
