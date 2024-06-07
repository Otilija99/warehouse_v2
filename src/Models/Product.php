<?php

namespace Warehouse\Models;

use Ramsey\Uuid\Uuid;
use Warehouse\Utilities\FileStorage;

class Product {
    private $filePath;

    public function __construct() {
        $this->filePath = 'data/products.json';
    }

    public function getAll() {
        return FileStorage::read($this->filePath);
    }

    public function create($name, $amount, $price, $expiration_date, $user) {
        $products = $this->getAll();
        $id = Uuid::uuid4()->toString();
        $newProduct = [
            'id' => $id,
            'name' => $name,
            'amount' => $amount,
            'price' => $price,
            'expiration_date' => $expiration_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'user' => $user
        ];
        $products[] = $newProduct;
        FileStorage::write($this->filePath, $products);
    }

    public function updateAmount($id, $amount, $user) {
        $products = $this->getAll();
        foreach ($products as &$product) {
            if ($product['id'] === $id) {
                $product['amount'] = $amount;
                $product['updated_at'] = date('Y-m-d H:i:s');
                $product['user'] = $user;
                break;
            }
        }
        FileStorage::write($this->filePath, $products);
    }

    public function delete($id, $user) {
        $products = $this->getAll();
        $products = array_filter($products, function($product) use ($id) {
            return $product['id'] !== $id;
        });
        FileStorage::write($this->filePath, $products);
    }

    public function deleteAll($user) {
        FileStorage::write($this->filePath, []);
    }

    public function generateReport() {
        $products = $this->getAll();
        $totalProducts = count($products);
        $totalValue = array_reduce($products, function($carry, $product) {
            return $carry + ($product['price'] * $product['amount']);
        }, 0);

        return [
            'total_products' => $totalProducts,
            'total_value' => $totalValue
        ];
    }
}
