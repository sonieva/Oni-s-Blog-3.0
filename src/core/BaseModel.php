<?php
namespace Core;

use Config\Database;
use PDO;

abstract class BaseModel {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function findById(string $table, int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findWhere(string $table, array $conditions): array {
        $where = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE $where");
        $stmt->execute($conditions);
        return $stmt->fetchAll();
    }

    public function findAll(string $table): array {
        $stmt = $this->db->query("SELECT * FROM $table");
        return $stmt->fetchAll();
    }

    public function insert(string $table, array $data): ?int {
      $columns = implode(', ', array_keys($data));
      $placeholders = ':' . implode(', :', array_keys($data));
      $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
      $stmt = $this->db->prepare($sql);
  
      if ($stmt->execute($data)) {
          return (int) $this->db->lastInsertId();
      }
  
      return null;
    }

    public function update(string $table, int $id, array $data): bool {
        $fields = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE $table SET $fields WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(string $table, int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
