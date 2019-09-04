<?php

namespace App\Http\Responses\API\Article;

use App\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Responses\API\Response;

class ShowArticleResponse extends Response
{
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function toResponse($request)
    {
        return new ArticleResource($this->article);
    }
}
