<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class Products extends BaseAdminController
{
    protected $productModel;
    protected $categoryModel;

    // Menyiapkan model produk dan kategori untuk halaman admin.
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Menampilkan daftar produk dengan filter kategori dan pagination.
    public function index()
    {
        $categoryId = $this->request->getGet('category');
        $query = $this->productModel->getProductsWithCategory(
            $categoryId ? (int) $categoryId : null
        );
        $products = $query->orderBy('created_at', 'DESC')->paginate(10);
        $categories = $this->categoryModel->getOrderedCategories();

        $data = [
            'title' => 'Kelola Produk | Vegetarian Paradise',
            'products' => $products,
            'pager' => $this->productModel->pager,
            'categories' => $categories,
            'selected_category' => $categoryId,
        ];

        return view('admin/products/index', $data);
    }

    // Menampilkan formulir untuk menambahkan produk.
    public function create()
    {
        $categories = $this->categoryModel->getOrderedCategories();

        $data = [
            'title' => 'Tambah Produk | Vegetarian Paradise',
            'categories' => $categories,
        ];

        return view('admin/products/form', $data);
    }

    // Memvalidasi lalu menyimpan produk baru dan gambar opsional.
    public function store()
    {
        $rules = [
            'name' => 'required|string|max_length[255]',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|is_natural_no_zero|is_not_unique[categories.id]',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),
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

    // Menampilkan formulir edit beserta data produk yang dipilih.
    public function edit($id)
    {
        $product = $this->productModel->getProductWithCategory((int) $id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $categories = $this->categoryModel->getOrderedCategories();

        $data = [
            'title' => 'Edit Produk | Vegetarian Paradise',
            'product' => $product,
            'categories' => $categories,
        ];

        return view('admin/products/form', $data);
    }

    // Memvalidasi lalu menyimpan perubahan produk dan gambar opsional.
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
            'category_id' => 'required|is_natural_no_zero|is_not_unique[categories.id]',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),
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

    // Menghapus produk berdasarkan ID.
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
