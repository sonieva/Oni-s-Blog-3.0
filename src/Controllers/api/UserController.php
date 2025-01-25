<?php

namespace Controllers\Api;

use Models\User;

class UserController {
  private User $userModel;

  public function __construct() {
    $this->userModel = new User();
  }

  public function getUsers() {
    $users = $this->userModel->findUsers();

    header('Content-Type: application/json');
    echo json_encode($users);
    exit;
  }
}