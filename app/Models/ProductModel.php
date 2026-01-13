<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'category_id',
        'name',
        'sku',
        'description',
        'price',
        'cost_price',
        'stock',
        'min_stock',
        'unit',
        'is_active',
        'image_url'
    ];

    protected $useTimestamps = true;

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'sku' => 'required|min_length[3]|max_length[50]|is_unique[products.sku,id,{id}]',
        'price' => 'required|decimal|greater_than_equal_to[0]',
        'cost_price' => 'permit_empty|decimal|greater_than_equal_to[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
        'min_stock' => 'required|integer|greater_than_equal_to[0]',
        'unit' => 'required|max_length[20]',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required',
            'min_length' => 'Product name must be at least 3 characters',
        ],
        'sku' => [
            'required' => 'SKU is required',
            'is_unique' => 'SKU already exists',
        ],
        'price' => [
            'required' => 'Price is required',
            'decimal' => 'Price must be a valid number',
        ],
    ];

    /**
     * Get products with category information
     */
    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.stock <=', 'products.min_stock', false)
            ->where('products.is_active', 1)
            ->orderBy('(products.min_stock - products.stock)', 'DESC')
            ->findAll();
    }

    /**
     * Get product with category by ID
     */
    public function getProductWithCategory($id)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->find($id);
    }
}
