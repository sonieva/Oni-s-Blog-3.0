<?php

use Utils\Router;
use Controllers\Api\ArticleController;
use Controllers\Api\UserController;

// Articles
Router::GET('/api/articles', [ArticleController::class, 'getArticles']);
Router::GET('/api/articles/{id}', [ArticleController::class, 'getArticleDetails']);
Router::GET('/api/articles/author/{author}', [ArticleController::class, 'getArticlesByAuthor']);

// Users
Router::GET('/api/users', [UserController::class, 'getUsers']);