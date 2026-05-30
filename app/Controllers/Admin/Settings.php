<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\SettingModel;

class Settings extends BaseAdminController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $settings = $this->settingModel->getAllSettings();

        $data = [
            'title' => 'Pengaturan | Vegetarian Paradise',
            'settings' => $settings,
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $settingKeys = [
            'company_name',
            'company_tagline',
            'company_description',
            'company_phone',
            'company_email',
            'company_address',
        ];

        foreach ($settingKeys as $key) {
            $value = $this->request->getPost($key);
            if ($value !== null) {
                $this->settingModel->setSetting($key, $value);
            }
        }

        return redirect()->back()->with('message', 'Pengaturan berhasil diperbarui');
    }
}
