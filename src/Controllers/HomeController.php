<?php

namespace Controllers;

use Utils\TwigService;
use Models\Article;

class HomeController {
  // private Article $articleModel;
  private array $viewData = [];

  public function __construct() {
    // $this->articleModel = new Article();
  }

  public function index() {
    TwigService::render('home.twig', [
      'title' => 'Inici',
      'current_page' => 1,
      'total_pages' => 0,
      'articles_per_page' => 8, 
      'sort' => 'recent', 
      'search_query' => '',
  ]);
  }
}