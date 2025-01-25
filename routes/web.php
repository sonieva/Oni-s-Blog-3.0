<?php

use Utils\Router;
use Controllers\AuthController;
use Controllers\HomeController;
use Controllers\ProfileController;
use Controllers\AdminController;
use Core\Middleware;

// Inici
Router::GET('/',[HomeController::class,'index']);

// Profile
Router::GET('/profile', function () {
  Middleware::auth();
  (new ProfileController())->index();
});

Router::POST('/change-password', function () {
  Middleware::auth();
  (new ProfileController())->changePassword();
});

// Admin
Router::GET('/admin', function () {
  Middleware::authAndRole('admin');
  (new AdminController())->index();
});

// --------------------------------------------------------------------
// ------------------------------- AUTH -------------------------------
// --------------------------------------------------------------------

// Login
Router::GET('/login', function () {
  Middleware::guest();
  (new AuthController())->showLoginForm();
});

Router::POST('/login', function () {
  Middleware::guest();
  (new AuthController())->login();
});

// Register
Router::GET('/register', function () {
  Middleware::guest();
  (new AuthController())->showRegisterForm();
});

Router::POST('/register', function () {
  Middleware::guest();
  (new AuthController())->register();
});

// Verify email
Router::GET('/verify-email', function () {
  Middleware::guest();
  (new AuthController())->showVerificationForm();
});

Router::POST('/verify-email', function () {
  Middleware::guest();
  (new AuthController())->verifyCode();
});

// Logout
Router::GET('/logout', function () {
  Middleware::auth();
  (new AuthController())->logout();
});