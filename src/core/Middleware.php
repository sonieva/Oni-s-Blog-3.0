<?php
namespace Core;

use Utils\Auth;

class Middleware {
  public static function auth(): void {
    if (!Auth::isAuthenticated()) {
      header('Location: /login');
      exit;
    }
  }

  public static function guest(): void {
    if (Auth::isAuthenticated()) {
      header('Location: /');
      exit;
    }
  }

  public static function role(string $requiredRole): void {
    $user = Auth::getUser();

    if (!$user || ($user['role'] ?? '') !== $requiredRole) {
      header('HTTP/1.1 403 Forbidden');
      echo 'No tens permisos per accedir a aquesta pàgina.';
      exit;
    }
  }

  public static function authAndRole(string $requiredRole): void {
    self::auth();
    self::role($requiredRole);
  }
}
