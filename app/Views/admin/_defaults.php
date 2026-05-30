<?php
// Admin view defaults to avoid undefined variable notices in views
$statuses = $statuses ?? ['new', 'read', 'replied'];
$orders = $orders ?? [];
$order = $order ?? [];
$contacts = $contacts ?? [];
$contact = $contact ?? [];
$products = $products ?? [];
$categories = $categories ?? [];
$pager = $pager ?? null;
$recentContacts = $recentContacts ?? [];
$recentOrders = $recentOrders ?? [];
$totalOrders = $totalOrders ?? 0;
$pendingOrders = $pendingOrders ?? 0;
$newContacts = $newContacts ?? 0;
$totalProducts = $totalProducts ?? 0;

// Helper labels/colors used in several admin views
$statusLabel = $statusLabel ?? ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'];
$statusColor = $statusColor ?? ['new' => 'danger', 'read' => 'warning', 'replied' => 'success'];

?>
