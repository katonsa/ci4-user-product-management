<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'products' => $this->productModel->getProductsWithCategory(),
        ];

        return view('products/index', $data);
    }

    public function new()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
            'units' => ['pcs', 'box', 'kg', 'liter', 'meter', 'pack'],
        ];

        return view('products/create', $data);
    }

    public function create()
    {
        $data = [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name' => $this->request->getPost('name'),
            'sku' => $this->request->getPost('sku'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'cost_price' => $this->request->getPost('cost_price') ?: null,
            'stock' => $this->request->getPost('stock'),
            'min_stock' => $this->request->getPost('min_stock'),
            'unit' => $this->request->getPost('unit'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'image_url' => $this->request->getPost('image_url'),
        ];

        if (!$this->productModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        return redirect()->to('/products')->with('success', 'Product created successfully');
    }

    public function edit($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound("Product with ID $id not found");
        }

        $data = [
            'product' => $product,
            'categories' => $this->categoryModel->findAll(),
            'units' => ['pcs', 'box', 'kg', 'liter', 'meter', 'pack'],
        ];

        return view('products/edit', $data);
    }

    public function update($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound("Product with ID $id not found");
        }

        $data = [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name' => $this->request->getPost('name'),
            'sku' => $this->request->getPost('sku'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'cost_price' => $this->request->getPost('cost_price') ?: null,
            'stock' => $this->request->getPost('stock'),
            'min_stock' => $this->request->getPost('min_stock'),
            'unit' => $this->request->getPost('unit'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'image_url' => $this->request->getPost('image_url'),
        ];

        // Set validation rules for update (exclude current ID from unique check)
        $this->productModel->setValidationRule('sku', "required|min_length[3]|max_length[50]|is_unique[products.sku,id,$id]");

        if (!$this->productModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        return redirect()->to('/products')->with('success', 'Product updated successfully');
    }

    public function delete($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $this->productModel->delete($id);

        return redirect()->to('/products')->with('success', 'Product deleted successfully');
    }

    public function toggleActive($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $newStatus = $product['is_active'] ? 0 : 1;
        $this->productModel->update($id, ['is_active' => $newStatus]);

        $message = $newStatus ? 'Product activated successfully' : 'Product deactivated successfully';
        return redirect()->back()->with('success', $message);
    }
}
