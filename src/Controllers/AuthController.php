<?php

namespace Controllers;

use Models\User;
use Utils\Auth;
use Utils\TwigService;
use Utils\Validator;

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

    $this->viewData['title'] = 'Iniciar sessió';
    TwigService::render('auth/login.twig', $this->viewData);
  }

  public function showSignupForm() {
    $this->viewData['title'] = 'Crear compte';
    TwigService::render('auth/signup.twig', $this->viewData);
  }

  public function login() {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember-me']);

    if (empty($identifier) || empty($password)) {
      $this->viewData['errors'][] = 'Has d\'omplir tots els camps';
      return $this->showLoginForm();
    }

    $user = $this->userModel->findByEmailOrNickname($identifier);

    if ($user && password_verify($password, $user['password'])) {
      Auth::login($user);

      if ($rememberMe) {
        $token = bin2hex(random_bytes(32));
        setcookie(
          'remember_me_token',
          $token,
          [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443,
            'httponly' => true,
            'samesite' => 'Strict'
          ]
      );
        $this->userModel->update($user['id'], ['remember_me_token' => $token]);
      }

      header('Location: /');
      exit;
    }

    $this->viewData['errors'][] = 'Les credencials no són correctes';
    $this->showLoginForm();
  }

  public function logout() {
    Auth::logout();
    header('Location: /');
    exit;
  }
}