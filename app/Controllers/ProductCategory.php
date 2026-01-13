<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductCategory extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('categories/index', $data);
    }

    public function new()
    {
        return view('categories/create');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|min_length[3]|max_length[100]|is_unique[categories.slug]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->save([
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('slug'), '-', true),
        ]);

        return redirect()->to('/categories')->with('success', 'Category created successfully');
    }

    public function edit($id = null)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw PageNotFoundException::forPageNotFound("Category with ID $id not found");
        }

        return view('categories/edit', ['category' => $category]);
    }

    public function update($id = null)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw PageNotFoundException::forPageNotFound("Category with ID $id not found");
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'slug' => "required|min_length[3]|max_length[100]|is_unique[categories.slug,id,$id]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('slug'), '-', true),
        ]);

        return redirect()->to('/categories')->with('success', 'Category updated successfully');
    }

    public function delete($id = null)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $this->categoryModel->delete($id);

        return redirect()->to('/categories')->with('success', 'Category deleted successfully');
    }
}
