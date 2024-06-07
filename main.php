<?php

require 'vendor/autoload.php';

use Warehouse\Controllers\UserController;
use Warehouse\Controllers\ProductController;

$userController = new UserController();
$productController = new ProductController();

$access_code = trim(readline("Please enter your user code: "));

$user = $userController->authenticate($access_code);

if (!$user) {
    echo "Authentication failed\n";
    exit(1);
}

echo "User authenticated successfully\n";

while (true) {
    echo "\nMenu:\n";
    echo "1. Add a product\n";
    echo "2. Update product amount\n";
    echo "3. Delete a product\n";
    echo "4. Display all products\n";
    echo "5. Generate report\n";
    echo "6. Delete all products\n";
    echo "7. Exit\n";
    echo "Enter your choice: ";

    $choice = trim(readline());

    switch ($choice) {
        case '1':
            $name = trim(readline("Enter product name: "));

            $amount = trim(readline("Enter product amount: "));

            $price = trim(readline("Enter product price: "));

            $expiration_date = trim(readline("Enter expiration date (YYYY-MM-DD) or leave blank: "));
            $expiration_date = $expiration_date ?: null;

            $productController->createProduct($name, $amount, $price, $expiration_date, $user['name']);
            echo "Product created successfully\n";
            break;

        case '2':
            $id = trim(readline("Enter product ID: "));

            $amount = trim(readline("Enter new amount: "));

            $productController->updateProductAmount($id, $amount, $user['name']);
            echo "Product amount updated successfully\n";
            break;

        case '3':
            $id = trim(readline("Enter product ID: "));

            $productController->deleteProduct($id, $user['name']);
            echo "Product deleted successfully\n";
            break;

        case '4':
            $products = $productController->getAllProducts();
            $productController->displayProducts($products);
            break;

        case '5':
            $report = $productController->generateReport();
            echo "Total Products: " . $report['total_products'] . "\n";
            echo "Total Value: $" . $report['total_value'] . "\n";
            break;

        case '6':
            $productController->deleteAllProducts($user['name']);
            echo "All products deleted successfully\n";
            break;

        case '7':
            echo "Goodbye!\n";
            exit(0);

        default:
            echo "Invalid choice, please try again\n";
            break;
    }
}
