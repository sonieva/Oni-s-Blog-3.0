<?php
namespace Config;

use PDO;
use PDOException;

class Database {
  private static ?PDO $connection = null;

  public static function connect(): PDO {
    if (self::$connection === null) {
      $host = $_ENV['DB_HOST'];
      $dbname = $_ENV['DB_NAME'];
      $user = $_ENV['DB_USER'];
      $pass = $_ENV['DB_PASS'];
      $charset = $_ENV['DB_CHARSET'];

      $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

      try {
        self::$connection = new PDO($dsn, $user, $pass, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
      } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
      }
    }

    return self::$connection;
  }
}