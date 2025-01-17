<?php

use Utils\Router;
use Controllers\AuthController;
use Controllers\HomeController;

Router::GET('/',[HomeController::class,'index']);

// Login
Router::GET('/login',[AuthController::class,'showLoginForm']);
Router::POST('/login',[AuthController::class,'login']);

// Signup
Router::GET('/signup',[AuthController::class,'showSignupForm']);

// Logout
Router::GET('/logout', [AuthController::class, 'logout']);