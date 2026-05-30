<?php echo $this->include('frontend/layout/header'); ?>

<!-- Main Content -->
<main>
    <?php
        $product = isset($product) ? (array) $product : [];
        $relatedProducts = isset($relatedProducts) ? (array) $relatedProducts : [];
    ?>
    <!-- Page Title -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 40px 0;">
        <div class="container">
            <h1><i class="fas fa-info-circle"></i> Detail Produk</h1>
        </div>
    </section>

    <?php $relatedProducts = $relatedProducts ?? []; ?>
    <?php if (empty($product)): ?>
        <section class="container my-5">
            <div class="alert alert-warning">
                Produk tidak ditemukan. <a href="<?= site_url('products') ?>">Kembali ke Katalog</a>
            </div>
        </section>
    <?php else: ?>

    <!-- Product Detail -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div style="background-color: var(--light-bg); border-radius: 10px; padding: 30px; text-align: center;">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" class="img-fluid" style="max-height: 400px; object-fit: cover;">
                    <?php else: ?>
                        <i class="fas fa-image fa-5x" style="color: #ccc;"></i>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="card-body">
                        <h2 class="card-title mb-3"><?= $product['name'] ?></h2>
                        
                        <div class="mb-4">
                            <span class="badge bg-info" style="font-size: 14px; padding: 5px 10px;">
                                <?= $product['category'] ?>
                            </span>
                        </div>

                        <h3 class="product-price mb-3">
                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                        </h3>

                        <p class="text-muted mb-4">
                            <strong>Stok:</strong>
                            <?php if ($product['stock'] > 0): ?>
                                <span class="badge bg-success">Tersedia (<?= $product['stock'] ?> unit)</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Habis Stok</span>
                            <?php endif; ?>
                        </p>

                        <hr>

                        <h5 class="mb-3">Deskripsi Produk</h5>
                        <p><?= nl2br($product['description']) ?></p>

                        <hr>

                        <!-- Add to Cart Form -->
                        <form action="<?= site_url('checkout/add-to-cart') ?>" method="POST" class="mb-3">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah:</label>
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <div class="input-group" style="max-width: 150px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">-</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control" style="text-align: center;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQty(<?= $product['stock'] ?>)">+</button>
                                </div>
                            </div>

                            <button type="button" class="btn btn-add-cart btn-lg w-100 mb-2" onclick="submitAddToCart()" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </form>

                        <a href="<?= site_url('products') ?>" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts) && count($relatedProducts) > 1): ?>
        <section style="background-color: var(--light-bg); padding: 60px 0;">
            <div class="container">
                <h2 class="section-title">Produk <span class="highlight">Sejenis</span></h2>
                
                <div class="row">
                    <?php foreach ($relatedProducts as $related): ?>
                        <?php if ($related['id'] != $product['id']): ?>
                            <div class="col-sm-6 col-lg-4 mb-4">
                                <div class="card product-card">
                                    <div class="card-img-top" style="background-color: white; display: flex; align-items: center; justify-content: center;">
                                        <?php if ($related['image']): ?>
                                            <img src="<?= base_url($related['image']) ?>" alt="<?= $related['name'] ?>" class="img-fluid" style="max-height: 250px; object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fas fa-image fa-4x" style="color: #ccc;"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $related['name'] ?></h5>
                                        <p class="card-text text-muted" style="height: 60px; overflow: hidden; font-size: 14px;">
                                            <?= substr($related['description'], 0, 80) ?>...
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="product-price">Rp <?= number_format($related['price'], 0, ',', '.') ?></span>
                                            <span class="product-stock" style="font-size: 12px;">
                                                <?php if ($related['stock'] > 0): ?>
                                                    <span class="badge bg-success">Tersedia</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Habis</span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="<?= site_url('products/detail/' . $related['id']) ?>" class="btn btn-sm btn-outline-primary mb-2">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
                                            <button type="button" class="btn btn-sm btn-add-cart" onclick="addToCart(<?= $related['id'] ?>)" <?= $related['stock'] <= 0 ? 'disabled' : '' ?>>
                                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php endif; ?>
</main>

<script>
    function decreaseQty() {
        let qty = document.getElementById('quantity');
        if (qty.value > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
    }

    function increaseQty(max) {
        let qty = document.getElementById('quantity');
        if (qty.value < max) {
            qty.value = parseInt(qty.value) + 1;
        }
    }

    /**
     * Submit the add-to-cart form via AJAX and show success/error feedback.
     */
    function submitAddToCart() {
        let form = document.querySelector('form');
        let formData = new FormData(form);
        
        fetch('<?= site_url('checkout/add-to-cart') ?>', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Produk ditambahkan ke keranjang');
                document.getElementById('quantity').value = 1;
            } else {
                showModal('Gagal', data.message || 'Tidak dapat menambahkan produk', 'error');
            }
        })
        .catch(() => showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error'));
    }
</script>

<?php echo $this->include('frontend/layout/footer'); ?>