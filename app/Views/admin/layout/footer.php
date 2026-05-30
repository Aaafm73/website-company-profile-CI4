    </div><!-- end main-content -->

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /**
         * Show a small toast notification in the top-right corner.
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
         * Show a modal dialog for success, error, or confirmation details.
         * @param {string} title
         * @param {string} text
         * @param {'success'|'error'|'warning'|'info'} [icon='info']
         */
        function showModal(title, text, icon = 'info') {
            return Swal.fire({ title: title, text: text, icon: icon });
        }

        /**
         * Update the status of an order via AJAX.
         * @param {number|string} orderId
         */
        function updateOrderStatus(orderId) {
            let status = document.getElementById('status_' + orderId).value;

            fetch('/admin/orders/update-status/' + orderId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'status=' + encodeURIComponent(status) + '&' + encodeURIComponent(window.csrfName) + '=' + encodeURIComponent(window.csrfHash)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', data.message || 'Status berhasil diperbarui');
                    setTimeout(() => location.reload(), 900);
                } else {
                    showModal('Gagal', data.message || 'Tidak dapat memperbarui status', 'error');
                }
            })
            .catch(() => showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error'));
        }

        // Update contact status
        /**
         * Update the status of a contact message via AJAX.
         * @param {number|string} contactId
         */
        function updateContactStatus(contactId) {
            let status = document.getElementById('status_' + contactId).value;

            fetch('/admin/contacts/update-status/' + contactId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'status=' + encodeURIComponent(status) + '&' + encodeURIComponent(window.csrfName) + '=' + encodeURIComponent(window.csrfHash)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', data.message || 'Status berhasil diperbarui');
                    setTimeout(() => location.reload(), 900);
                } else {
                    showModal('Gagal', data.message || 'Tidak dapat memperbarui status', 'error');
                }
            })
            .catch(() => showModal('Kesalahan', 'Tidak dapat menghubungi server', 'error'));
        }

        // Delete confirmation using SweetAlert2
        /**
         * Confirm deletion with SweetAlert2 and submit a POST form if approved.
         * @param {string} url
         * @param {string} itemName
         */
        function deleteConfirm(url, itemName) {
            Swal.fire({
                title: 'Hapus ' + itemName + '?',
                text: 'Tindakan ini tidak bisa dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit a hidden POST form with CSRF token to perform server-side delete and let PHP redirect
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.style.display = 'none';
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = window.csrfName;
                    csrfInput.value = window.csrfHash;
                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
