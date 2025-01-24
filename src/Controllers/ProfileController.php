<?php

namespace Controllers;

use Utils\TwigService;

class ProfileController {
  private array $viewData = [];

  public function index() {
    $this->viewData['title'] = 'Perfil';
    $this->viewData['tab'] = 'change-password';
    TwigService::render('profile.html.twig', $this->viewData);
  }
}