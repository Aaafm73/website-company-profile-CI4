<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

abstract class BaseAdminController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        if (!session()->get('admin_user')) {
            redirect()->to(site_url('admin/login'))->send();
            exit;
        }
    }

    /**
     * Return default admin view data to ensure canonical variables exist.
     * Controllers may merge/override these values.
     *
     * @param string $type 'contact' or 'order'
     * @param array $overrides
     * @return array
     */
    protected function adminDefaults(string $type = 'contact', array $overrides = []): array
    {
        $contactStatuses = ['new', 'read', 'replied'];
        $orderStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        $statusLabel = ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'];
        $statusColor = ['new' => 'danger', 'read' => 'warning', 'replied' => 'success'];

        $defaults = [
            'statuses' => $type === 'order' ? $orderStatuses : $contactStatuses,
            'statusLabel' => $statusLabel,
            'statusColor' => $statusColor,
        ];

        return array_merge($defaults, $overrides);
    }
}
