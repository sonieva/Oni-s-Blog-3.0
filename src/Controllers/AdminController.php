<?php 

namespace Controllers;

use Utils\Auth;
use Utils\TwigService;

class AdminController {
  private array $viewData = [];

  public function __construct() {
    $this->viewData['title'] = 'Gestió d\'usuaris';
  }

  public function index(): void {
    TwigService::render('admin.html.twig', $this->viewData);
}
}