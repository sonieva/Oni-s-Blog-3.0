<?php

namespace Controllers;

use Utils\TwigService;

class HomeController {
  public function index() {
    $viewData = [
      'title' => 'Inici'
    ];
    TwigService::render('base.twig', $viewData);
  }
}