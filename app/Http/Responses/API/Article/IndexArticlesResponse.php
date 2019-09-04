<?php

namespace App\Http\Responses\API\Article;

use App\Http\Resources\ArticleCollection;
use App\Http\Responses\API\Response;

class IndexArticlesResponse extends Response
{
    public $articles;

    public function __construct($articles)
    {
        $this->articles = $articles;
    }

    public function toResponse($request)
    {
        return (new ArticleCollection($this->articles))->toResponse($request);
    }
}
