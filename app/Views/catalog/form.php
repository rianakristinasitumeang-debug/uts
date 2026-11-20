<?php
$isUpdate = $editing;
$action = $isUpdate ? '/?action=update&id=' . (int) $product['id'] : '/?action=store';
?>
<section class="form-page">
    <a class="back-link" href="/"><span>←</span> Kembali ke koleksi</a>
    <div class="form-header">
        <div>
            <div class="eyebrow"><span class="eyebrow-line"></span> INVENTARIS / <?= $isUpdate ? 'UBAH OBJEK' : 'OBJEK BARU' ?></div>
            <h1><?= $isUpdate ? 'Rawat kembali' : 'Tambahkan cerita' ?><br><em>ke koleksi.</em></h1>
        </div>
        <span class="form-index">FORM / <?= $isUpdate ? '02' : '01' ?></span>
    </div>

    <?php if ($errors !== []): ?>
        <div class="form-alert" role="alert"><strong>Ada yang perlu diperiksa.</strong><span>Perbaiki kolom bertanda merah sebelum menyimpan.</span></div>
    <?php endif; ?>

    <form class="product-form" action="<?= e($action) ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
        <div class="form-main">
            <div class="form-section-title"><span>01</span><div><h2>Identitas objek</h2><p>Nama yang mudah diingat, asal yang mudah ditelusuri.</p></div></div>
            <div class="field-grid">
                <div class="field <?= isset($errors['name']) ? 'has-error' : '' ?>">
                    <label for="name">Nama produk <span>*</span></label>
                    <input id="name" name="name" value="<?= e($product['name']) ?>" maxlength="90" required placeholder="Contoh: Lampu Gantung Lembayung">
                    <?php if (isset($errors['name'])): ?><small><?= e($errors['name']) ?></small><?php endif; ?>
                </div>
                <div class="field <?= isset($errors['code']) ? 'has-error' : '' ?>">
                    <label for="code">Kode inventaris <span>*</span></label>
                    <input id="code" name="code" value="<?= e($product['code']) ?>" maxlength="18" required placeholder="RA-009" autocapitalize="characters">
                    <?php if (isset($errors['code'])): ?><small><?= e($errors['code']) ?></small><?php endif; ?>
                </div>
                <div class="field <?= isset($errors['category']) ? 'has-error' : '' ?>">
                    <label for="category">Kategori <span>*</span></label>
                    <input id="category" name="category" value="<?= e($product['category']) ?>" maxlength="40" required placeholder="Tekstil, keramik, ...">
                    <?php if (isset($errors['category'])): ?><small><?= e($errors['category']) ?></small><?php endif; ?>
                </div>
                <div class="field <?= isset($errors['price']) ? 'has-error' : '' ?>">
                    <label for="price">Harga jual <span>*</span></label>
                    <div class="input-prefix"><span>Rp</span><input id="price" name="price" type="number" min="1" step="1" value="<?= e($product['price']) ?>" required placeholder="350000"></div>
                    <?php if (isset($errors['price'])): ?><small><?= e($errors['price']) ?></small><?php endif; ?>
                </div>
                <div class="field <?= isset($errors['stock']) ? 'has-error' : '' ?>">
                    <label for="stock">Jumlah stok <span>*</span></label>
                    <input id="stock" name="stock" type="number" min="0" step="1" value="<?= e($product['stock']) ?>" required placeholder="0">
                    <?php if (isset($errors['stock'])): ?><small><?= e($errors['stock']) ?></small><?php endif; ?>
                </div>
                <div class="field field-wide <?= isset($errors['description']) ? 'has-error' : '' ?>">
                    <label for="description">Cerita singkat <span>*</span></label>
                    <textarea id="description" name="description" rows="4" maxlength="500" required placeholder="Material, proses, atau kisah di balik objek ini..."><?= e($product['description']) ?></textarea>
                    <?php if (isset($errors['description'])): ?><small><?= e($errors['description']) ?></small><?php endif; ?>
                </div>
                <div class="field field-wide <?= isset($errors['image_url']) ? 'has-error' : '' ?>">
                    <label for="image_url">URL foto produk <span>*</span></label>
                    <input id="image_url" name="image_url" type="url" value="<?= e($product['image_url']) ?>" required placeholder="https://...">
                    <?php if (isset($errors['image_url'])): ?><small><?= e($errors['image_url']) ?></small><?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button class="button-primary" type="submit"><span><?= $isUpdate ? 'Simpan perubahan' : 'Simpan ke koleksi' ?></span><b aria-hidden="true">↗</b></button>
                <a class="cancel-link" href="/">Batalkan</a>
            </div>
        </div>
        <aside class="form-aside">
            <div class="preview-label"><span>PRATINJAU</span><span>01 / 01</span></div>
            <div class="image-preview" data-image-preview>
                <?php if ($product['image_url'] !== ''): ?>
                    <img src="<?= e($product['image_url']) ?>" alt="Pratinjau gambar produk">
                <?php else: ?>
                    <div class="preview-placeholder"><span>✳</span><p>Foto produk<br>akan muncul di sini</p></div>
                <?php endif; ?>
            </div>
            <p class="preview-note">Gunakan foto dengan cahaya alami dan latar yang bersih. Rasio 4:3 tampil paling baik.</p>
            <div class="aside-foot"><span>RUMAH ANYAM</span><span>✳</span><span>YOGYAKARTA</span></div>
        </aside>
    </form>
</section>
