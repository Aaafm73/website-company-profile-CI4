<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\ProductModel;

class Products extends BaseAdminController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $category = $this->request->getGet('category');
        $query = $this->productModel;

        if ($category) {
            $query = $query->where('category', $category);
        }

        $products = $query->orderBy('created_at', 'DESC')->paginate(10);
        $categories = array_unique(array_column($this->productModel->findAll(), 'category'));

        $data = [
            'title' => 'Kelola Produk | Vegetarian Paradise',
            'products' => $products,
            'pager' => $this->productModel->pager,
            'categories' => $categories,
            'selected_category' => $category,
        ];

        return view('admin/products/index', $data);
    }

    public function create()
    {
        $categories = ['Protein', 'Sayuran', 'Makanan Jadi', 'Minuman', 'Dessert', 'Lainnya'];

        $data = [
            'title' => 'Tambah Produk | Vegetarian Paradise',
            'categories' => $categories,
        ];

        return view('admin/products/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|string|max_length[255]',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
            'stock' => $this->request->getPost('stock'),
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $newName);
            $data['image'] = 'uploads/products/' . $newName;
        }

        $this->productModel->insert($data);

        return redirect()->to('/admin/products')->with('message', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $categories = ['Protein', 'Sayuran', 'Makanan Jadi', 'Minuman', 'Dessert', 'Lainnya'];

        $data = [
            'title' => 'Edit Produk | Vegetarian Paradise',
            'product' => $product,
            'categories' => $categories,
        ];

        return view('admin/products/form', $data);
    }

    public function update($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $rules = [
            'name' => 'required|string|max_length[255]',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
            'stock' => $this->request->getPost('stock'),
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $newName);
            $data['image'] = 'uploads/products/' . $newName;
        }

        $this->productModel->update($id, $data);

        return redirect()->to('/admin/products')->with('message', 'Produk berhasil diperbarui');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $this->productModel->delete($id);

        return redirect()->to('/admin/products')->with('message', 'Produk berhasil dihapus');
    }
}
