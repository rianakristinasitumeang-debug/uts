<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f5ee">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/app.css">
    <script src="/assets/app.js" defer></script>
</head>
<body>
    <div class="announcement"><span>DIRAJUT DENGAN WAKTU</span><span>Objek sehari-hari, dibuat dekat dengan alam.</span><span>YOGYAKARTA · INDONESIA</span></div>
    <header class="site-header">
        <a class="brand" href="/" aria-label="Rumah Anyam, beranda">
            <span class="brand-mark" aria-hidden="true">R<span>A</span></span>
            <span class="brand-name">RUMAH<br>ANYAM</span>
        </a>
        <nav class="main-nav" aria-label="Navigasi utama">
            <a class="nav-link is-current" href="/">Koleksi studio</a>
            <span class="nav-note">CATALOGUE / 04</span>
        </nav>
        <a class="header-action" href="/?action=create"><span class="plus-icon" aria-hidden="true">+</span><span>Tambah produk</span></a>
    </header>
    <main>
        <?php if ($flash): ?>
            <div class="flash-message" role="status"><span class="flash-dot"></span><?= e($flash) ?><button type="button" class="flash-close" aria-label="Tutup pemberitahuan">×</button></div>
        <?php endif; ?>
        <?= $content ?>
    </main>
    <footer class="site-footer">
        <a class="footer-brand" href="/">RUMAH ANYAM<span>®</span></a>
        <span>Objek dengan cerita, dari tangan-tangan terampil Nusantara.</span>
        <span class="footer-coord">7° 47′ 12.0″ S / 110° 21′ 54.0″ E</span>
    </footer>
</body>
</html>
