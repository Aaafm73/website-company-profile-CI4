<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\ContactModel;

class Contacts extends BaseAdminController
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    /**
     * Show paginated contacts and current filter status.
     */
    public function index()
    {
        $status = $this->request->getGet('status');
        $query = $this->contactModel;

        if ($status && in_array($status, ['new', 'read', 'replied'])) {
            $query = $query->where('status', $status);
        }

        $contacts = $query->orderBy('created_at', 'DESC')->paginate(10);

        $data = [
            'title' => 'Kelola Kontak | Vegetarian Paradise',
            'contacts' => $contacts,
            'pager' => $this->contactModel->pager,
            'selected_status' => $status,
        ];

        // Merge with admin defaults for contact views (ensures $statuses exists)
        $data = array_merge($this->adminDefaults('contact'), $data);

        return view('admin/contacts/index', $data);
    }

    /**
     * Show detail for a single contact and mark new messages as read.
     */
    public function detail($id)
    {
        $contact = $this->contactModel->find($id);

        if (!$contact) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kontak tidak ditemukan');
        }

        // Update status to read if it's new
        if ($contact['status'] === 'new') {
            $this->contactModel->update($id, ['status' => 'read']);
        }

        $data = [
            'title' => 'Detail Kontak dari ' . $contact['name'] . ' | Vegetarian Paradise',
            'contact' => $contact,
        ];

        // Merge with admin defaults for contact views
        $data = array_merge($this->adminDefaults('contact'), $data);

        return view('admin/contacts/detail', $data);
    }

    /**
     * Handle AJAX request to update contact status.
     * Returns JSON for frontend SweetAlert2 feedback.
     */
    public function updateStatus($id)
    {
        $contact = $this->contactModel->find($id);

        if (!$contact) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kontak tidak ditemukan']);
        }

        $status = $this->request->getPost('status');
        $validStatuses = ['new', 'read', 'replied'];

        if (!in_array($status, $validStatuses)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status tidak valid']);
        }

        $this->contactModel->update($id, ['status' => $status]);

        return $this->response->setJSON(['success' => true, 'message' => 'Status kontak berhasil diperbarui']);
    }

    /**
     * Delete a contact record and redirect to the contact list.
     */
    public function delete($id)
    {
        $contact = $this->contactModel->find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Kontak tidak ditemukan');
        }

        $this->contactModel->delete($id);

        return redirect()->to('/admin/contacts')->with('message', 'Kontak berhasil dihapus');
    }
}
