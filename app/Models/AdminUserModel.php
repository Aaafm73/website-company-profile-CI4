<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table = 'admin_users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'role', 'is_active', 'last_login'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'username' => 'required|string|max_length[100]|is_unique[admin_users.username]',
        'email' => 'required|valid_email|is_unique[admin_users.email]',
        'password' => 'required|min_length[6]',
        'full_name' => 'required|string|max_length[255]',
    ];

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->where('is_active', true)->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
