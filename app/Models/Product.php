<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

final class Product
{
    public function __construct(private PDO $database)
    {
    }

    public function all(string $search = '', string $category = ''): array
    {
        $conditions = [];
        $parameters = [];

        if ($search !== '') {
            $conditions[] = '(name LIKE :search OR code LIKE :search OR description LIKE :search)';
            $parameters['search'] = '%' . $search . '%';
        }
        if ($category !== '') {
            $conditions[] = 'category = :category';
            $parameters['category'] = $category;
        }

        $sql = 'SELECT * FROM products';
        if ($conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY id DESC';

        $statement = $this->database->prepare($sql);
        $statement->execute($parameters);
        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->database->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
        $product = $statement->fetch();
        return $product === false ? null : $product;
    }

    public function categories(): array
    {
        return $this->database->query('SELECT category, COUNT(*) AS total FROM products GROUP BY category ORDER BY category')->fetchAll();
    }

    public function stats(): array
    {
        return $this->database->query(
            'SELECT COUNT(*) AS product_count, COALESCE(SUM(stock), 0) AS item_count,
                    COUNT(DISTINCT category) AS category_count,
                    COALESCE(SUM(CASE WHEN stock <= 5 THEN 1 ELSE 0 END), 0) AS low_stock_count
             FROM products'
        )->fetch();
    }

    public function create(array $product): void
    {
        $statement = $this->database->prepare(
            'INSERT INTO products (code, name, category, description, price, stock, image_url)
             VALUES (:code, :name, :category, :description, :price, :stock, :image_url)'
        );
        $statement->execute($product);
    }

    public function update(int $id, array $product): void
    {
        $product['id'] = $id;
        $statement = $this->database->prepare(
            'UPDATE products SET code = :code, name = :name, category = :category,
                description = :description, price = :price, stock = :stock, image_url = :image_url
             WHERE id = :id'
        );
        $statement->execute($product);
    }

    public function delete(int $id): void
    {
        $statement = $this->database->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
