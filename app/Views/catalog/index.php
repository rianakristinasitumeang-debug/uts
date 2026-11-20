<section class="catalog-page">
    <div class="catalog-intro">
        <div class="intro-copy">
            <div class="eyebrow"><span class="eyebrow-line"></span> OBJEK PILIHAN / 2026</div>
            <h1>Ruang untuk<br><em>yang bermakna.</em></h1>
            <p class="intro-note">Benda-benda yang tumbuh dari tanah, waktu, dan tangan-tangan terampil. Dikurasi dengan hati di Yogyakarta.</p>
        </div>
        <div class="intro-art">
            <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=90" alt="Interior hangat dengan dekorasi buatan tangan">
            <div class="art-caption"><span>ATELIER 04</span><span>EST. MMXXI</span></div>
            <div class="art-stamp" aria-hidden="true"><span>BUATAN<br>LOKAL</span><b>✳</b></div>
        </div>
        <div class="intro-index" aria-hidden="true">01<br>—<br>08</div>
    </div>

    <section class="inventory-strip" aria-label="Ringkasan inventaris">
        <div class="inventory-label"><span class="live-dot"></span> CATATAN INVENTARIS</div>
        <div class="inventory-stat"><strong><?= e($stats['product_count']) ?></strong><span>objek<br>di katalog</span></div>
        <div class="inventory-stat"><strong><?= e($stats['category_count']) ?></strong><span>kelompok<br>pilihan</span></div>
        <div class="inventory-stat"><strong><?= e($stats['item_count']) ?></strong><span>buah<br>tersedia</span></div>
        <div class="inventory-alert"><span class="alert-mark">!</span><span><?= e($stats['low_stock_count']) ?> produk perlu<br>perhatian stok</span><span class="alert-arrow">↗</span></div>
    </section>

    <section class="collection-section" id="koleksi">
        <div class="collection-heading">
            <div>
                <div class="eyebrow"><span class="eyebrow-line"></span> PILIHAN STUDIO</div>
                <h2>Koleksi <span>terkini</span><sup><?= str_pad((string) count($products), 2, '0', STR_PAD_LEFT) ?></sup></h2>
            </div>
            <form class="search-form" action="/" method="get" role="search">
                <?php if ($activeCategory !== ''): ?><input type="hidden" name="category" value="<?= e($activeCategory) ?>"><?php endif; ?>
                <label for="catalog-search" class="sr-only">Cari produk</label>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7.25"></circle><path d="m16.5 16.5 4 4"></path></svg>
                <input id="catalog-search" type="search" name="q" value="<?= e($search) ?>" placeholder="Cari nama atau kode">
                <button type="submit" aria-label="Cari">↵</button>
            </form>
        </div>
        <div class="collection-tools">
            <div class="category-filters" aria-label="Filter kategori">
                <?php $allUrl = $search !== '' ? '/?' . http_build_query(['q' => $search]) : '/'; ?>
                <a class="filter-chip <?= $activeCategory === '' ? 'is-selected' : '' ?>" href="<?= e($allUrl) ?>">Semua</a>
                <?php foreach ($categories as $item): ?>
                    <?php $categoryUrl = '/?' . http_build_query(array_filter(['category' => $item['category'], 'q' => $search])); ?>
                    <a class="filter-chip <?= $activeCategory === $item['category'] ? 'is-selected' : '' ?>" href="<?= e($categoryUrl) ?>"><?= e($item['category']) ?><span><?= e($item['total']) ?></span></a>
                <?php endforeach; ?>
            </div>
            <span class="sort-note">URUTAN <b>TERBARU DULU ↓</b></span>
        </div>

        <?php if ($products === []): ?>
            <div class="empty-state">
                <span class="empty-symbol">⌕</span>
                <h3>Belum ada yang cocok.</h3>
                <p>Coba kata kunci atau kategori lain untuk melihat pilihan studio.</p>
                <a class="text-link" href="/">Lihat semua koleksi <span>↗</span></a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $index => $product): ?>
                    <article class="product-card" style="--card-index: <?= e($index) ?>">
                        <div class="product-image-wrap">
                            <img class="product-image" src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" loading="lazy">
                            <span class="product-category"><?= e($product['category']) ?></span>
                            <?php if ((int) $product['stock'] <= 5): ?><span class="stock-badge">STOK TERBATAS</span><?php endif; ?>
                            <a class="card-edit" href="/?action=edit&amp;id=<?= e($product['id']) ?>" aria-label="Edit <?= e($product['name']) ?>" title="Edit produk">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14 5 5 5M4 20l4.3-.9L19 8.4a2.1 2.1 0 0 0-3-3L5.3 16.1 4 20Z"></path></svg>
                            </a>
                        </div>
                        <div class="product-details">
                            <div class="product-meta"><span><?= e($product['code']) ?></span><span class="stock-count"><?= e($product['stock']) ?> TERSEDIA</span></div>
                            <h3><?= e($product['name']) ?></h3>
                            <p><?= e($product['description']) ?></p>
                            <div class="product-bottom">
                                <span class="product-price"><?= e(rupiah($product['price'])) ?></span>
                                <form action="/?action=destroy" method="post" class="delete-form" data-confirm="Hapus <?= e($product['name']) ?> dari katalog?">
                                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                    <input type="hidden" name="id" value="<?= e($product['id']) ?>">
                                    <button class="delete-button" type="submit" aria-label="Hapus <?= e($product['name']) ?>" title="Hapus produk">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M9 7V4h6v3m3 0-.8 13H6.8L6 7m4 3v6m4-6v6"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <div class="closing-note"><span>01 — 08</span><span>Setiap objek punya asal. Setiap tangan punya cerita.</span><span>RUMAH ANYAM / 2026</span></div>
</section>
