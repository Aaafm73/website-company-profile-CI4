<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SettingModel;

class Home extends BaseController
{
    protected $productModel;
    protected $settingModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda | Vegetarian Paradise',
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
            'company_tagline' => $this->settingModel->getSetting('company_tagline', ''),
            'company_description' => $this->settingModel->getSetting('company_description', ''),
            'company_phone' => $this->settingModel->getSetting('company_phone', ''),
            'company_email' => $this->settingModel->getSetting('company_email', ''),
            'company_address' => $this->settingModel->getSetting('company_address', ''),
            'featured_products' => $this->productModel->getPopularProducts(6),
        ];

        return view('frontend/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'Tentang Kami | Vegetarian Paradise',
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
            'company_description' => $this->settingModel->getSetting('company_description', ''),
            'company_phone' => $this->settingModel->getSetting('company_phone', ''),
            'company_email' => $this->settingModel->getSetting('company_email', ''),
            'company_address' => $this->settingModel->getSetting('company_address', ''),
        ];

        return view('frontend/about', $data);
    }
}
