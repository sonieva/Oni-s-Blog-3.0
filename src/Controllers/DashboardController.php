<?php

namespace Controllers;

use Utils\TwigService;
use Utils\Auth;
use Models\Article;

class DashboardController {
  private array $viewData = [];
  private Article $articleModel;

  public function __construct() {
    $this->viewData['title'] = 'Dashboard';
    $this->viewData['tab'] = 'view-articles';
    $this->articleModel = new Article();
  }

  public function index() {
    $this->viewData['articles'] = $this->articleModel->getArticlesByAuthor(Auth::getUser()['nickname']);
    TwigService::render('dashboard.html.twig', $this->viewData);
  }
}