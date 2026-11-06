<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description', 'price', 'image', 'category_id', 'stock'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'category_id' => 'required|is_natural_no_zero',
        'stock' => 'integer',
    ];

    // Mengambil semua produk dalam kategori tertentu.
    public function getProductsByCategoryId(int $categoryId)
    {
        return $this->select('products.*, categories.name AS category')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.category_id', $categoryId)
            ->findAll();
    }

    // Menyiapkan query produk beserta nama kategorinya, dengan filter kategori opsional.
    public function getProductsWithCategory(?int $categoryId = null)
    {
        $query = $this->select('products.*, categories.name AS category')
            ->join('categories', 'categories.id = products.category_id');

        if ($categoryId !== null) {
            $query->where('products.category_id', $categoryId);
        }

        return $query;
    }

    // Mengambil satu produk beserta nama kategorinya berdasarkan ID.
    public function getProductWithCategory(int $productId)
    {
        return $this->select('products.*, categories.name AS category')
            ->join('categories', 'categories.id = products.category_id')
            ->find($productId);
    }

    // Mengambil produk terbaru untuk ditampilkan sebagai produk unggulan.
    public function getPopularProducts($limit = 6)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}
