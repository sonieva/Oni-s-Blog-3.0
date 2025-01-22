<?php

namespace Controllers;

use Utils\TwigService;
use Models\Article;

class HomeController {
  private array $viewData = [];

  public function __construct() {
  }

  public function index() {
    $this->viewData['title'] = 'Inici';
    TwigService::render('home.twig', $this->viewData);
  }
}