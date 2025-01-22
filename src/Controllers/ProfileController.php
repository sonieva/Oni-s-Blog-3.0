<?php

namespace Controllers;

use Utils\TwigService;

class ProfileController {
  private array $viewData = [];

  public function index() {
    $this->viewData['title'] = 'Perfil';
    TwigService::render('profile.twig', $this->viewData);
  }
}