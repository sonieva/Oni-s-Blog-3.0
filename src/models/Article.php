<?php

namespace Models;

use PDO;
use Core\BaseModel;

class Article extends BaseModel {
  private string $table = 'articles';

  public function getArticles(): array {
    return $this->findAll($this->table);
  }

  public function getArticle(int $id) {
    return $this->findById($this->table, $id);
  }

  public function createArticle(array $data): ?int {
    return $this->insert($this->table, $data);
  }

  public function updateArticle(int $id, array $data): bool {
    return $this->update($this->table, $id, $data);
  }

  public function getArticlesWithPagination(int $limit, int $offset): array {
    $sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT :offset, :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function countArticles(): int {
    $sql = "SELECT COUNT(*) as total FROM articles";
    $stmt = $this->db->query($sql);
    return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
  }
}