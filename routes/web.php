<?php 
use Utils\Router;
use Controllers\HomeController;

Router::GET('/',[HomeController::class,'index']);