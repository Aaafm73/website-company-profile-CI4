<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'email', 'phone', 'subject', 'message', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'email' => 'required|valid_email',
        'subject' => 'required|string|max_length[255]',
        'message' => 'required|string',
    ];

    public function getNewContacts()
    {
        return $this->where('status', 'new')->findAll();
    }

    public function getContactsByStatus($status)
    {
        return $this->where('status', $status)->orderBy('created_at', 'DESC')->findAll();
    }
}
