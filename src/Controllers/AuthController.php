<?php

namespace Controllers;

use Models\User;
use Utils\Auth;
use Utils\TwigService;
use Utils\Validator;
use Utils\MailService;

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

  public function showRegisterForm() {
    TwigService::render('auth/register.twig', $this->viewData);
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

  public function signup() {
    $nickname = $_POST['nickname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    $errors = [];

    if (empty($nickname) || empty($email) || empty($password) || empty($confirmPassword)) {
      $errors[] = 'Tots els camps són obligatoris';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'El correu no és vàlid';
    }

    if ($password !== $confirmPassword) {
      $errors[] = 'Les contrasenyes no coincideixen';
    }

    if (!Validator::isStrongPassword($password)) {
      $errors[] = 'La contrasenya ha de tenir 8 caràcters, incloure majúscules, minúscules, números i un caràcter especial.';
    }

    if ($this->userModel->findByEmailOrNickname($email)) {
      $errors[] = 'El correu ja estan registrat';
    }

    if ($errors) {
      TwigService::render('auth/register.twig', [
        'errors' => $errors,
        'nickname' => $nickname,
        'email' => $email
      ]);
      return;
    }

    $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $this->userModel->create([
      'nickname' => $nickname,
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'verification_code' => $verificationCode,
      'verification_expires_at' => $expiresAt
    ]);

    $this->sendVerificationEmail($email, $verificationCode);

    header('Location: /verify-email');
    exit;
  }

  public function logout() {
    Auth::logout();
    header('Location: /');
    exit;
  }

  public function showVerificationForm(): void {
    TwigService::render('auth/enter_verification_code.twig');
  }

  public function verifyCode(): void {
    $code = trim($_POST['verification-code'] ?? '');

    if (empty($code)) {
      TwigService::render('auth/enter_verification_code.twig', [
        'errors' => ['El codi és obligatori']
      ]);
      return;
    }

    $user = $this->userModel->findByVerificationCode($code);

    if (!$user) {
      TwigService::render('auth/enter_verification_code.twig', [
        'errors' => ['El codi no és vàlid o ha caducat']
      ]);
      return;
    }

    $this->userModel->confirmEmail($user['id']);

    Auth::login($user);

    header('Location: /');
    exit;
}


  private function sendVerificationEmail(string $email, string $code): void {
    $mailService = new MailService();

    $subject = 'Verificació del teu correu electrònic';
    $body = TwigService::renderTemplate('email/verification.twig', [
        'verification_code' => $code,
        'year' => date('Y')
    ]);

    if (!$mailService->send($email, $subject, $body)) {
        error_log("No s'ha pogut enviar el correu de verificació a $email");
    }
  }
}