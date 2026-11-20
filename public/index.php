<?php

declare(strict_types=1);

use App\Controllers\ProductController;
use App\Core\Database;
use App\Models\Product;

const APP_ROOT = __DIR__ . '/..';

require APP_ROOT . '/app/Support/helpers.php';
require APP_ROOT . '/app/Core/Database.php';
require APP_ROOT . '/app/Models/Product.php';
require APP_ROOT . '/app/Controllers/ProductController.php';

$database = new Database();
$controller = new ProductController(new Product($database->connection()));
$controller->dispatch();
