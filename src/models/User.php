<?php

namespace Models;

use Core\BaseModel;

class User extends BaseModel {
  private string $table = 'users';

  public function findUsers(): array {
    $stmt = $this->db->query("SELECT id, nickname, email, full_name, role, img_path FROM {$this->table}");
    return $stmt->fetchAll();
  }

  public function findByEmailOrNickname(string $identifier): ?array {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :identifier OR nickname = :identifier");
    $stmt->execute(['identifier' => $identifier]);
    return $stmt->fetch() ?: null;
  }

  public function findByRememberMeToken(string $token): ?array {
    return $this->findWhere($this->table, ['remember_me_token' => $token])[0] ?? null;
  }

  public function findByVerificationCode(string $code): ?array {
    return $this->findWhere($this->table, [
      'verification_code' => $code,
      'verification_expires_at >' => date('Y-m-d H:i:s')
    ])[0] ?? null;
  }

  public function confirmEmail(int $id): bool {
    return $this->update($this->table, $id, [
      'verification_code' => null,
      'verification_expires_at' => null,
      'email_confirmed' => 1
    ]);
  }

  public function saveRememberMeToken(int $id, string $token): bool {
    return $this->update($this->table, $id, ['remember_me_token' => $token]);
  }

  public function saveVerificationCode(int $id, string $code, string $expiresAt): bool {
    return $this->update($this->table, $id, [
        'verification_code' => $code,
        'verification_expires_at' => $expiresAt
    ]);
  }

  public function updatePassword(int $id, string $password): bool {
    return $this->update($this->table, $id, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
  }

  public function createUser(array $data): ?int {
    return $this->insert($this->table, $data);
  }
}
