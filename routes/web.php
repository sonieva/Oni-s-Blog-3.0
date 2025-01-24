<?php

use Utils\Router;
use Controllers\AuthController;
use Controllers\HomeController;
use Controllers\ProfileController;
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
  (new AuthController())->changePassword();
});

// --------------------------------------------------------------------
// ------------------------------- AUTH -------------------------------
// --------------------------------------------------------------------

// Login
Router::GET('/login',[AuthController::class,'showLoginForm']);
Router::POST('/login',[AuthController::class,'login']);

// Register
Router::GET('/register',[AuthController::class,'showRegisterForm']);
Router::POST('/register',[AuthController::class,'signup']);

// Verify email
Router::GET('/verify-email', [AuthController::class, 'showVerificationForm']);
Router::POST('/verify-email', [AuthController::class, 'verifyCode']);

// Logout
Router::GET('/logout', [AuthController::class, 'logout']);