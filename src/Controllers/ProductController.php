<?php

namespace Warehouse\Controllers;

use Warehouse\Models\Product;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function getAllProducts() {
        return $this->productModel->getAll();
    }

    public function createProduct($name, $amount, $price, $expiration_date, $user) {
        $this->productModel->create($name, $amount, $price, $expiration_date, $user);
    }

    public function updateProductAmount($id, $amount, $user) {
        $this->productModel->updateAmount($id, $amount, $user);
    }

    public function deleteProduct($id, $user) {
        $this->productModel->delete($id, $user);
    }

    public function deleteAllProducts($user) {
        $this->productModel->deleteAll($user);
    }

    public function generateReport() {
        return $this->productModel->generateReport();
    }

    public function displayProducts($products) {
        $output = new ConsoleOutput();
        $table = new Table($output);
        $table->setHeaders(['ID', 'Name', 'Amount', 'Price', 'Expiration Date', 'Created At', 'Updated At']);

        foreach ($products as $product) {
            $table->addRow([
                $product['id'],
                $product['name'],
                $product['amount'],
                $product['price'],
                $product['expiration_date'],
                $product['created_at'],
                $product['updated_at']
            ]);
        }

        $table->render();
    }
}
