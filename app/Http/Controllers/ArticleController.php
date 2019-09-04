<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\Article\IndexArticles;
use App\Http\Requests\API\Article\StoreArticle;
use App\Http\Requests\API\Article\UpdateArticle;
use App\Http\Responses\API\Article\IndexArticlesResponse;
use App\Http\Responses\API\Article\ShowArticleResponse;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Article\IndexArticles  $request
     * @return \App\Http\Responses\API\Article\IndexArticlesResponse
     */
    public function index(IndexArticles $request)
    {
        $per_page = (int) $request->input('per_page', 5);
        $articles = Article::latest()->paginate($per_page);

        return new IndexArticlesResponse($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\Article\StoreArticle  $request
     * @return \App\Http\Responses\API\Article\ShowArticleResponse
     */
    public function store(StoreArticle $request)
    {
        $article = Article::create($request->validated());

        return new ShowArticleResponse($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \App\Http\Responses\API\Article\ShowArticleResponse
     */
    public function show(Article $article)
    {
        return new ShowArticleResponse($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\Article\UpdateArticle  $request
     * @param  \App\Article  $article
     * @return \App\Http\Responses\API\Article\ShowArticleResponse
     */
    public function update(UpdateArticle $request, Article $article)
    {
        $article->update($request->validated());

        return new ShowArticleResponse($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \App\Http\Responses\API\Article\ShowArticleResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return new ShowArticleResponse($article);
    }
}
