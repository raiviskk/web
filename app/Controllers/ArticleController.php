<?php

namespace App\Controllers;

use App\ApiFetcher;
use App\Response;


class ArticleController
{
    private ApiFetcher $apiFetcher;

    public function __construct(ApiFetcher $apiFetcher)
    {
        $this->apiFetcher = $apiFetcher;
    }

    public function index(): Response
    {
        $data = $this->apiFetcher->fetchEpisodesFromApi();

        $template = 'articles.index';
        $data = ['articles' => $data->getArticles()];
        return new Response($template, $data);
    }

    public function show($id): Response
    {
        $data = $this->apiFetcher->fetchEpisodesFromApi();
        $episode = $data->findArticleById($id);

        $template = 'article.show';
        $data = ['article' => $episode];
        return new Response($template, $data);
    }
}
