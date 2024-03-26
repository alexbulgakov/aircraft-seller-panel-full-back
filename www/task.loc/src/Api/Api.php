<?php

namespace Task\Api;

class Api
{
  private static $pdo = null;

  private static function connect()
  {
    if (self::$pdo === null) {
      $config = require __DIR__ . '/../../database.php';
      try {
        self::$pdo = new \PDO("mysql:host={$config['host']};dbname={$config['db_name']};port={$config['port']}", $config['username'], $config['password']);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      } catch (\PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
    }
  }

  public static function getAll()
  {
    self::connect();
    $statement = self::$pdo->query("SELECT * FROM products");
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function get($id)
  {
    self::connect();
    $statement = self::$pdo->prepare("SELECT * FROM products WHERE id = :id");
    $statement->execute(['id' => $id]);
    return $statement->fetch(\PDO::FETCH_ASSOC);
  }

  public static function add($name, $supplierEmail, $count, $price)
  {
    self::connect();

    if (empty($name)) {
      return ['error' => 'Name is required.'];
    }

    $statement = self::$pdo->prepare("INSERT INTO products (name, supplierEmail, count, price) VALUES (:name, :supplierEmail, :count, :price)");
    $statement->execute([
      'name' => $name,
      'supplierEmail' => $supplierEmail,
      'count' => $count,
      'price' => $price
    ]);
    return self::$pdo->lastInsertId();
  }

  public static function edit($id, $name, $supplierEmail, $count, $price)
  {
    self::connect();

    if (empty($name)) {
      return ['error' => 'Name is required.'];
    }

    $statement = self::$pdo->prepare("UPDATE products SET name = :name, supplierEmail = :supplierEmail, count = :count, price = :price WHERE id = :id");
    return $statement->execute([
      'id' => $id,
      'name' => $name,
      'supplierEmail' => $supplierEmail,
      'count' => $count,
      'price' => $price
    ]);
  }

  public static function delete($id)
  {
    self::connect();
    $statement = self::$pdo->prepare("DELETE FROM products WHERE id = :id");
    return $statement->execute(['id' => $id]);
  }
}
