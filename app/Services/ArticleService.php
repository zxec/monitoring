<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    /**
     * Create a new article.
     *
     * @param $request
     * @return Article
     */
    public function store($request): void
    {
        $article = Auth::user()->articles()->create($request);
        $article->tags()->sync($request['tags']);
    }

    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function update(Article $article, $request): void
    {
        $article->update($request);
        $article->tags()->sync($request['tags']);
    }
}
