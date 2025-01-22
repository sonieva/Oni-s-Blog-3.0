<?php

use Utils\Router;
use Controllers\Api\ArticleController;

Router::GET('/api/articles', [ArticleController::class, 'getArticles']);
Router::GET('/api/articles/{id}', [ArticleController::class, 'getArticleDetails']);