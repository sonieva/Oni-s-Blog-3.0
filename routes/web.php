<?php

use Utils\Router;
use Controllers\AuthController;
use Controllers\HomeController;

Router::GET('/',[HomeController::class,'index']);

// Login
Router::GET('/login',[AuthController::class,'showLoginForm']);
Router::POST('/login',[AuthController::class,'login']);

// Register
Router::GET('/register',[AuthController::class,'showRegisterForm']);
Router::POST('/register',[AuthController::class,'signup']);

// Verify email
Router::get('/verify-email', [AuthController::class, 'showVerificationForm']);
Router::post('/verify-email', [AuthController::class, 'verifyCode']);

// Logout
Router::GET('/logout', [AuthController::class, 'logout']);