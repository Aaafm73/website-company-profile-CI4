<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $settingModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $category = $this->request->getGet('category');
        
        if ($category && $category !== 'semua') {
            $products = $this->productModel->getProductsByCategoryId((int) $category);
        } else {
            $products = $this->productModel->getProductsWithCategory()->findAll();
        }

        $categories = $this->categoryModel->getOrderedCategories();

        $data = [
            'title' => 'Katalog Produk | Vegetarian Paradise',
            'products' => $products,
            'categories' => $categories,
            'selected_category' => $category,
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
        ];

        return view('frontend/products', $data);
    }

    public function detail($id)
    {
        $product = $this->productModel->getProductWithCategory((int) $id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $relatedProducts = $this->productModel->getProductsByCategoryId((int) $product['category_id']);

        $data = [
            'title' => $product['name'] . ' | Vegetarian Paradise',
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'company_name' => $this->settingModel->getSetting('company_name', 'Vegetarian Paradise'),
        ];

        return view('frontend/product_detail', $data);
    }
}
