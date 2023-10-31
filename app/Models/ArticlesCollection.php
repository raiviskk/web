<?php

namespace App\Models;

class ArticlesCollection
{
    private array $articles = [];

    public function add(Article $article)
    {
        $this->articles[] = $article;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function findArticleById($id): ?Article
    {
        foreach ($this->articles as $article) {
            if ($article->getId() == $id) {
                return $article;
            }
        }

        return null;
    }
}
