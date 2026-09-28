<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['name'];

    public function getOrderedCategories(): array
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }
}
