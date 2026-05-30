    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <h5><i class="fas fa-leaf"></i> <?= $company_name ?? 'Vegetarian Paradise' ?></h5>
                    <p><?= $company_tagline ?? 'Hidup Sehat Dimulai dari Pilihan' ?></p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Menu</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="<?= site_url('/') ?>">Beranda</a></li>
                        <li><a href="<?= site_url('about') ?>">Tentang Kami</a></li>
                        <li><a href="<?= site_url('products') ?>">Katalog Produk</a></li>
                        <li><a href="<?= site_url('dashboard/contact') ?>">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Informasi</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li><i class="fas fa-phone"></i> <?= $company_phone ?? '+62 XXX XXXX' ?></li>
                        <li><i class="fas fa-envelope"></i> <?= $company_email ?? 'info@example.com' ?></li>
                        <li><i class="fas fa-map-marker-alt"></i> <?= substr($company_address ?? 'Alamat', 0, 30) ?>...</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Ikuti Kami</h5>
                    <a href="#" class="me-2"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>
            <div class="footer-divider">
                <div class="text-center">
                    <p>&copy; <?= date('Y') ?> <?= $company_name ?? 'Vegetarian Paradise' ?>. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /**
         * Show a toast message on the frontend.
         * @param {'success'|'error'|'warning'|'info'} type
         * @param {string} message
         * @param {number} [timer=2000]
         */
        function showToast(type, message, timer = 2000) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: timer,
                timerProgressBar: true,
            });
        }

        /**
         * Show a standard modal dialog.
         * @param {string} title
         * @param {string} text
         * @param {'success'|'error'|'warning'|'info'} [icon='info']
         */
        function showModal(title, text, icon = 'info') {
            return Swal.fire({ title: title, text: text, icon: icon });
        }

        /**
         * Add a product to the cart using AJAX.
         * @param {number|string} productId
         */
        function addToCart(productId) {
            $.ajax({
                url: '<?= site_url('checkout/add-to-cart') ?>',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    [window.csrfName]: window.csrfHash
                },
                success: function(response) {
                    if (response.success) {
                        showToast('success', response.message || 'Produk ditambahkan ke keranjang');
                    } else {
                        showModal('Gagal', response.message || 'Tidak dapat menambahkan produk', 'error');
                    }
                },
                error: function() {
                    showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error');
                }
            });
        }

        /**
         * Confirm removal of a cart item, then remove it.
         * @param {number|string} productId
         */
        function removeFromCart(productId) {
            Swal.fire({
                title: 'Hapus produk dari keranjang?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url('checkout/remove-from-cart') ?>',
                        type: 'POST',
                        data: { product_id: productId, [window.csrfName]: window.csrfHash },
                        success: function(response) {
                            if (response.success) {
                                showToast('success', response.message || 'Produk dihapus');
                                setTimeout(() => location.reload(), 900);
                            } else {
                                showModal('Gagal', response.message || 'Tidak dapat menghapus produk', 'error');
                            }
                        },
                        error: function() { showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error'); }
                    });
                }
            });
        }

        // Update cart quantity
        /**
         * Update cart quantity for a product, or remove if quantity falls below 1.
         * @param {number|string} productId
         * @param {number} quantity
         */
        function updateQuantity(productId, quantity) {
            if (quantity < 1) {
                removeFromCart(productId);
                return;
            }
            
            $.ajax({
                url: '<?= site_url('checkout/update-cart') ?>',
                type: 'POST',
                data: { product_id: productId, quantity: quantity, [window.csrfName]: window.csrfHash },
                success: function(response) {
                    if (response.success) {
                        setTimeout(() => location.reload(), 250);
                    } else {
                        showModal('Gagal', response.message || 'Tidak dapat memperbarui kuantitas', 'error');
                    }
                },
                error: function() { showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error'); }
            });
        }
    </script>
</body>
</html>
