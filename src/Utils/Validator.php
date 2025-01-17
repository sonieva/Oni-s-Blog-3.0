<?php
namespace Utils;

class Validator {
  public static function isStrongPassword(string $password): bool {
    $length = strlen($password) >= 8;              
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChar = preg_match('@[^\w]@', $password);

    return $length && $uppercase && $lowercase && $number && $specialChar;
  }
}
