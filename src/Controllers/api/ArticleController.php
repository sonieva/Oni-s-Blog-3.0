<?php

namespace Controllers\Api;

use Models\Article;

class ArticleController {
  public function getArticles() {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    $articleModel = new Article();
    $articles = $articleModel->getArticlesWithPagination($limit, $offset);
    $totalArticles = $articleModel->countArticles();
    $totalPages = ceil($totalArticles / $limit);

    header('Content-Type: application/json');
    echo json_encode([
        'articles' => $articles,
        'totalPages' => $totalPages,
        'currentPage' => $page,
    ]);
    exit;
  }

  public function getArticleDetails($id)
  {
    $articleModel = new Article();
    $article = $articleModel->getArticle($id);

    if (!$article) {
        http_response_code(404);
        echo json_encode(['error' => 'Article no trobat']);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($article);
    exit;
  }
}
