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
    protected $allowedFields = ['name', 'description', 'price', 'image', 'category', 'stock'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'category' => 'required|string|max_length[100]',
        'stock' => 'integer',
    ];

    public function getProductsByCategory($category)
    {
        return $this->where('category', $category)->findAll();
    }

    public function getPopularProducts($limit = 6)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}
