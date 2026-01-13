<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'slug'];

    // Dates
    protected $useTimestamps = true;

    // Validation
    protected $validationRules = [
        'name' => 'required|max_length[100]|min_length[3]',
        'slug' => 'required|max_length[100]|is_unique[categories.slug,id,{id}]',
    ];
}
