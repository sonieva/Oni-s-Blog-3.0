<?php

namespace Controllers;

use Models\User;
use Utils\TwigService;
use Utils\Validator;
use Utils\Auth;

class ProfileController {
  private array $viewData = [];
  private User $userModel;

  public function __construct() {
    $this->viewData['title'] = 'Perfil';
    $this->viewData['tab'] = 'favorites';
    $this->userModel = new User();
  }

  public function index() {
    TwigService::render('profile.html.twig', $this->viewData);
  }

  public function changePassword() {
    $oldPassword = $_POST['current-password'] ?? '';
    $newPassword = $_POST['new-password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    $errors = [];

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
      $errors[] = 'Tots els camps són obligatoris';
    }

    if ($newPassword !== $confirmPassword) {
      $errors[] = 'Les contrasenyes no coincideixen';
    }

    if (!Validator::isStrongPassword($newPassword)) {
      $errors[] = 'La contrasenya ha de tenir 8 caràcters, incloure majúscules, minúscules, números i un caràcter especial.';
    }

    $user = Auth::getUser();

    if (!password_verify($oldPassword, $user['password'])) {
      $errors[] = 'La contrasenya antiga no és correcta';
    }

    if ($errors) {
      $this->viewData['errors'] = $errors;
      $this->viewData['tab'] = 'change-password';
      return $this->index();
    }

    $encryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $this->userModel->updatePassword($user['id'], $encryptedPassword);

    $user['password'] = $encryptedPassword;
    Auth::updateUser($user);

    unset($this->viewData['errors']);
    return $this->index();
  }
}