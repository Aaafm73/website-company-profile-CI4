<?php echo $this->include('admin/layout/header'); ?>
<?php echo $this->include('admin/_defaults'); ?>

<?php
// Local fallback values ensure this view renders even when static analysis cannot infer included defaults.
$statuses = $statuses ?? ['new', 'read', 'replied'];
$contacts = $contacts ?? [];
$pager = $pager ?? null;
?>

<!-- Contacts List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-envelope"></i> Daftar Kontak</h5>
        <div>
            <!-- Status buttons are populated from the shared admin default view data. -->
            <?php foreach ($statuses as $status): ?>
                <a href="/admin/contacts?status=<?= $status ?>" class="btn btn-sm btn-outline-primary">
                    <?php
                    $statusLabel = ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'];
                    echo $statusLabel[$status] ?? ucfirst($status);
                    ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background-color: var(--light-bg);">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><strong><?= $contact['name'] ?></strong></td>
                            <td><?= $contact['email'] ?></td>
                            <td><?= substr($contact['subject'], 0, 50) ?></td>
                            <td>
                                <?php
                                $statusColor = ['new' => 'danger', 'read' => 'warning', 'replied' => 'success'];
                                $statusLabel = ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'];
                                ?>
                                <span class="badge bg-<?= $statusColor[$contact['status']] ?>">
                                    <?= $statusLabel[$contact['status']] ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($contact['created_at'])) ?></td>
                            <td>
                                <a href="/admin/contacts/detail/<?= $contact['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Use SweetAlert2 confirmation, then submit POST with CSRF token -->
                                <form action="/admin/contacts/delete/<?= $contact['id'] ?>" method="POST" style="display:inline-block; margin:0;" onsubmit="event.preventDefault(); deleteConfirm(this.action, '<?= esc($contact['name']) ?>');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <?= $pager ? $pager->links() : '' ?>
        </nav>
    </div>
</div>

<?php echo $this->include('admin/layout/footer'); ?>
