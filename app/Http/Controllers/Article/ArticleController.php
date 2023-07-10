<?php

namespace App\Http\Controllers\Article;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\View\View;
use App\Services\ArticleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Article\ArticleRequest;

class ArticleController extends Controller
{

    public ArticleService $service;

    public function __construct(ArticleService $service)
    {
        $this->authorizeResource(Article::class);
        $this->service = $service;
    }

    /**
     * Show all articles.
     *
     * @return View
     */
    public function index(): View
    {
        return view('article.index')->with('articles', Article::latest('published_at')->published()->get());
    }

    /**
     * Show a single article.
     *
     * @param Article $article
     * @return View
     */
    public function show(Article $article): View
    {
        return view('article.show')->with('article', $article->load('tags'));
    }

    /**
     * Show create article form.
     *
     * @return View
     */
    public function create(): View
    {
        return view('article.edit')->with([
            'action' => [
                'url' => 'article.store',
            ],
            'tags' => Tag::pluck('name', 'id'),
            'title' => __('form.new_article'),
            'submitButton' => __('form.create')
        ]);
    }

    /**
     * Show edit article form.
     *
     * @param Article $article
     * @return View
     */
    public function edit(Article $article): View
    {
        return view('article.edit')->with([
            'article' => $article,
            'action' => [
                'url' => 'article.update',
                'data' => $article->id,
                'method' => 'patch',
            ],
            'tags' => Tag::pluck('name', 'id'),
            'title' => __('form.edit'),
            'submitButton' => __('form.save')
        ]);
    }

    /**
     * Save a new article.
     *
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function store(ArticleRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());
        toastr()->success(__('flash.create_article'), __('flash.articles'));
        return redirect('article');
    }

    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function update(Article $article, ArticleRequest $request): RedirectResponse
    {
        $this->service->update($article, $request->validated());
        toastr()->success(__('flash.edit_article'), __('flash.articles'));
        return redirect('article');
    }
}
