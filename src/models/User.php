<?php
namespace Models;

use PDO;
use Config\Database;

class User {
  private PDO $db;
  private string $table = 'users';

  public function __construct() {
    $this->db = Database::connect();
  }

  public function findByEmailOrNickname(string $identifier): ?array {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :identifier OR nickname = :identifier");
    $stmt->execute(['identifier' => $identifier]);
    return $stmt->fetch() ?: null;
  }

  public function findByRememberMeToken(string $token): ?array {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE remember_me_token = :token");
    $stmt->execute(['token' => $token]);
    return $stmt->fetch() ?: null;
  }

  /** 
   * Crea un nou usuari amb dades dinàmiques
   */
  public function create(array $data): bool {
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));

    $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute($data);
  }

  /**
   * Actualitza un usuari segons l'ID amb dades dinàmiques.
   */
  public function update(int $id, array $data): bool {
    $fields = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));

    $sql = "UPDATE {$this->table} SET $fields WHERE id = :id";
    $data['id'] = $id;

    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
  }

  /** 
   * Elimina un usuari segons l'ID
   */
  public function delete(int $id): bool {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
    return $stmt->execute(['id' => $id]);
  }
}
