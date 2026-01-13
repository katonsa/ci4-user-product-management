<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInventoryFieldsToProducts extends Migration
{
    public function up()
    {
        $fields = [
            'cost_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'comment' => 'Cost of goods sold (COGS)',
                'after' => 'price',
            ],
            'min_stock' => [
                'type' => 'INT',
                'default' => 0,
                'after' => 'stock',
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'pcs',
                'comment' => 'Unit of measure (pcs, box, kg, etc)',
                'after' => 'min_stock',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'after' => 'unit',
            ],
        ];

        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', ['cost_price', 'min_stock', 'unit', 'is_active']);
    }
}
