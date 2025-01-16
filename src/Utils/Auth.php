<?php
namespace Utils;

class Auth {
  // Start the session and store user data
  public static function login(array $user): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION['user'] = $user;
  }

  // Destroy the session to log out the user
  public static function logout(): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    session_destroy();
  }

  // Check if the user is logged in
  public static function isAuthenticated(): bool {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return isset($_SESSION['user']);
  }

  // Get the logged-in user's data
  public static function getUser(): ?array {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return $_SESSION['user'] ?? null;
  }
}
