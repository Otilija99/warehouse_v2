<?php

require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Warehouse\Utilities\FileStorage;

$filePath = 'data/products.json';
$products = FileStorage::read($filePath);

foreach ($products as &$product) {
    if (!isset($product['id']) || !Uuid::isValid($product['id'])) {
        $product['id'] = Uuid::uuid4()->toString();
    }
}

FileStorage::write($filePath, $products);

echo "Backward compatibility script executed successfully. All products now have valid UUIDs.\n";
