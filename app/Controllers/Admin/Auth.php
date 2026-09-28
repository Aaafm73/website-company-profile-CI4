<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;

class Auth extends BaseController
{
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
    }

    public function login()
    {
        if (session('admin_user')) {
            session()->remove('admin_user');
            session()->regenerate(true);
        }

        $data = [
            'title' => 'Login Admin | Vegetarian Paradise',
        ];

        return view('admin/login', $data);
    }

    public function processLogin()
    {
        $rules = [
            'username' => 'required|string|max_length[100]',
            'password' => 'required|string|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->adminUserModel->getUserByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username atau password salah');
        }

        // Update last login
        $this->adminUserModel->updateLastLogin($user['id']);

        // Rotate the session ID after authentication to prevent session fixation.
        session()->regenerate(true);

        // Set session
        session()->set('admin_user', [
            'id' => (int) $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
        ]);

        return redirect()->to(site_url('admin/dashboard'))->with('message', 'Selamat datang, ' . $user['full_name']);
    }

    public function logout()
    {
        session()->remove('admin_user');
        session()->regenerate(true);
        return redirect()->to(site_url('admin/login'))->with('message', 'Anda telah logout');
    }
}
