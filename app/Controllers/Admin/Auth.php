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
            return redirect()->to('/admin/dashboard');
        }

        $data = [
            'title' => 'Login Admin | Vegetarian Paradise',
        ];

        return view('admin/login', $data);
    }

    public function processLogin()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
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

        // Set session
        session()->set('admin_user', $user);

        return redirect()->to(site_url('admin/dashboard'))->with('message', 'Selamat datang, ' . $user['full_name']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('admin/login'))->with('message', 'Anda telah logout');
    }
}
