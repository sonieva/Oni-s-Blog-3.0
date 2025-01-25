<?php

namespace Models;

use PDO;
use Core\BaseModel;

class Article extends BaseModel {
  private string $table = 'articles';

  public function findArticles(): array {
    return $this->findAll($this->table);
  }

  public function findArticle(int $id) {
    return $this->findById($this->table, $id);
  }

  public function createArticle(array $data): ?int {
    return $this->insert($this->table, $data);
  }

  public function updateArticle(int $id, array $data): bool {
    return $this->update($this->table, $id, $data);
  }

  public function getArticlesWithPagination(int $limit, int $offset): array {
    $sql = "
      SELECT 
        articles.*,
        users.nickname AS author_nickname,
        users.img_path AS author_img_path
      FROM 
        articles
      INNER JOIN 
        users
      ON 
        articles.author_id = users.id
      ORDER BY 
        articles.created DESC
      LIMIT 
        :offset, :limit
    ";
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

  public function getArticlesByAuthor(string $author): array {
    $sql = "
      SELECT 
        articles.*
      FROM 
        articles
      INNER JOIN 
        users
      ON 
        articles.author_id = users.id
      WHERE 
        users.nickname = :author
      ORDER BY 
        articles.created DESC
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':author', $author, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}