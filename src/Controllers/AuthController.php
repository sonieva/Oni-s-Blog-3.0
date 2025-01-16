<?php

namespace Controllers;

use Utils\Auth;
use Models\User;
use Utils\TwigService;

class AuthController {
  private User $userModel;
  private array $viewData = [];

  public function __construct() {
    $this->userModel = new User();
  }

  public function showLoginForm() {
    if (isset($_COOKIE['remember_me_token'])) {
      $token = $_COOKIE['remember_me_token'];

      $user = $this->userModel->findByRememberMeToken($token);

      if ($user) {
        Auth::login($user);
        header('Location: /');
        exit;
      }
    }

    TwigService::render('auth/login.twig', $this->viewData);
  }

  public function login() {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember-me']);

    $user = $this->userModel->findByEmailOrNickname($identifier);

    if ($user && password_verify($password, $user['password'])) {
      Auth::login($user);

      if ($rememberMe) {
        $token = bin2hex(random_bytes(32));
        setcookie('remember_me_token', $token, time() + 60 * 60 * 24 * 30, '/');
        $this->userModel->update($user['id'], ['remember_me_token' => $token]);
      }

      header('Location: /');
      exit;
    }

    $this->viewData['error'] = 'Les dades introduïdes no són correctes';
    $this->showLoginForm();
  }

  public function logout() {
    Auth::logout();
    header('Location: /');
    exit;
  }
}