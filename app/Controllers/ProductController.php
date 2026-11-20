<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use PDOException;

final class ProductController
{
    public function __construct(private Product $products)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public function dispatch(): void
    {
        $action = (string) ($_GET['action'] ?? 'index');
        $routes = [
            'index' => ['GET', 'index'],
            'create' => ['GET', 'create'],
            'edit' => ['GET', 'edit'],
            'store' => ['POST', 'store'],
            'update' => ['POST', 'update'],
            'destroy' => ['POST', 'destroy'],
        ];

        if (!isset($routes[$action])) {
            $this->errorPage(404, 'Halaman tidak ditemukan', 'Alamat yang Anda tuju tidak tersedia.');
            return;
        }
        [$method, $handler] = $routes[$action];
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->errorPage(405, 'Metode tidak diizinkan', 'Kembali ke katalog untuk melanjutkan.');
            return;
        }
        if ($method === 'POST' && !hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
            $this->errorPage(419, 'Sesi formulir berakhir', 'Muat ulang halaman lalu kirim formulir kembali.');
            return;
        }

        $this->{$handler}();
    }

    private function index(): void
    {
        $search = trim((string) ($_GET['q'] ?? ''));
        $category = trim((string) ($_GET['category'] ?? ''));
        $this->render('catalog/index', [
            'products' => $this->products->all($search, $category),
            'categories' => $this->products->categories(),
            'stats' => $this->products->stats(),
            'search' => $search,
            'activeCategory' => $category,
        ]);
    }

    private function create(): void
    {
        $this->render('catalog/form', [
            'editing' => false,
            'product' => [
                'code' => '', 'name' => '', 'category' => '', 'description' => '',
                'price' => '', 'stock' => '', 'image_url' => '',
            ],
            'errors' => [],
        ]);
    }

    private function edit(): void
    {
        $product = $this->products->find((int) ($_GET['id'] ?? 0));
        if ($product === null) {
            $this->errorPage(404, 'Produk tidak ditemukan', 'Produk ini mungkin sudah dihapus dari koleksi.');
            return;
        }
        $this->render('catalog/form', ['editing' => true, 'product' => $product, 'errors' => []]);
    }

    private function store(): void
    {
        [$product, $errors] = $this->validatedInput();
        if ($errors !== []) {
            $this->render('catalog/form', ['editing' => false, 'product' => $product, 'errors' => $errors]);
            return;
        }
        try {
            $this->products->create($product);
        } catch (PDOException) {
            $this->render('catalog/form', [
                'editing' => false,
                'product' => $product,
                'errors' => ['code' => 'Kode produk sudah digunakan. Pilih kode lain.'],
            ]);
            return;
        }
        $this->flash('Produk baru masuk ke koleksi.');
        $this->redirect('/');
    }

    private function update(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($this->products->find($id) === null) {
            $this->errorPage(404, 'Produk tidak ditemukan', 'Produk ini mungkin sudah dihapus dari koleksi.');
            return;
        }
        [$product, $errors] = $this->validatedInput();
        if ($errors !== []) {
            $product['id'] = $id;
            $this->render('catalog/form', ['editing' => true, 'product' => $product, 'errors' => $errors]);
            return;
        }
        try {
            $this->products->update($id, $product);
        } catch (PDOException) {
            $product['id'] = $id;
            $this->render('catalog/form', [
                'editing' => true,
                'product' => $product,
                'errors' => ['code' => 'Kode produk sudah digunakan. Pilih kode lain.'],
            ]);
            return;
        }
        $this->flash('Perubahan produk berhasil disimpan.');
        $this->redirect('/');
    }

    private function destroy(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($this->products->find($id) === null) {
            $this->errorPage(404, 'Produk tidak ditemukan', 'Produk ini mungkin sudah dihapus dari koleksi.');
            return;
        }
        $this->products->delete($id);
        $this->flash('Produk telah dihapus dari koleksi.');
        $this->redirect('/');
    }

    private function validatedInput(): array
    {
        $product = [];
        foreach (['code', 'name', 'category', 'description', 'image_url'] as $field) {
            $product[$field] = trim((string) ($_POST[$field] ?? ''));
        }
        $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT);
        $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT);
        $product['price'] = $price === false ? '' : $price;
        $product['stock'] = $stock === false ? '' : $stock;

        $errors = [];
        if (!preg_match('/^[A-Z0-9-]{3,18}$/', $product['code'])) {
            $errors['code'] = 'Gunakan 3-18 karakter: huruf kapital, angka, atau tanda hubung.';
        }
        if ($product['name'] === '' || mb_strlen($product['name']) > 90) {
            $errors['name'] = 'Nama wajib diisi dan maksimal 90 karakter.';
        }
        if ($product['category'] === '' || mb_strlen($product['category']) > 40) {
            $errors['category'] = 'Kategori wajib diisi dan maksimal 40 karakter.';
        }
        if ($product['description'] === '' || mb_strlen($product['description']) > 500) {
            $errors['description'] = 'Deskripsi wajib diisi dan maksimal 500 karakter.';
        }
        if (!is_int($price) || $price < 1) {
            $errors['price'] = 'Harga harus berupa angka lebih dari nol.';
        }
        if (!is_int($stock) || $stock < 0) {
            $errors['stock'] = 'Stok harus berupa bilangan bulat nol atau lebih.';
        }
        $image = filter_var($product['image_url'], FILTER_VALIDATE_URL);
        if ($image === false || !in_array(parse_url($product['image_url'], PHP_URL_SCHEME), ['http', 'https'], true)) {
            $errors['image_url'] = 'Masukkan URL gambar yang diawali http:// atau https://.';
        }

        return [$product, $errors];
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $pageTitle = isset($pageTitle) ? $pageTitle . ' — Rumah Anyam' : 'Rumah Anyam — Katalog Studio';
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        $csrfToken = $_SESSION['csrf_token'];
        ob_start();
        require APP_ROOT . '/app/Views/' . $view . '.php';
        $content = ob_get_clean();
        require APP_ROOT . '/app/Views/layout.php';
    }

    private function errorPage(int $status, string $title, string $message): void
    {
        http_response_code($status);
        $this->render('errors/message', ['errorTitle' => $title, 'errorMessage' => $message]);
    }

    private function flash(string $message): void
    {
        $_SESSION['flash'] = $message;
    }

    private function redirect(string $location): never
    {
        header('Location: ' . $location, true, 303);
        exit;
    }
}
