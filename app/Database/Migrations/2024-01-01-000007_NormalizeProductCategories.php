<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NormalizeProductCategories extends Migration
{
    private const FOREIGN_KEY = 'fk_products_category';

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');

        $legacyCategories = $this->db->table('products')
            ->select('category')
            ->distinct()
            ->get()
            ->getResultArray();
        $categoryIds = [];

        foreach ($legacyCategories as $row) {
            $name = trim((string) ($row['category'] ?? '')) ?: 'Lainnya';
            if (!isset($categoryIds[$name])) {
                $this->db->table('categories')->insert(['name' => $name]);
                $categoryIds[$name] = $this->db->table('categories')
                    ->where('name', $name)
                    ->get()
                    ->getRowArray()['id'];
            }
        }

        if (!isset($categoryIds['Lainnya'])) {
            $this->db->table('categories')->insert(['name' => 'Lainnya']);
            $categoryIds['Lainnya'] = $this->db->table('categories')
                ->where('name', 'Lainnya')
                ->get()
                ->getRowArray()['id'];
        }

        $this->forge->addColumn('products', [
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        foreach ($legacyCategories as $row) {
            $legacyName = (string) ($row['category'] ?? '');
            $categoryName = trim($legacyName) ?: 'Lainnya';
            $this->db->table('products')
                ->where('category', $legacyName)
                ->update(['category_id' => $categoryIds[$categoryName]]);
        }

        $this->db->table('products')
            ->where('category_id', null)
            ->update(['category_id' => $categoryIds['Lainnya']]);

        $this->forge->modifyColumn('products', [
            'category_id' => [
                'name' => 'category_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'RESTRICT', self::FOREIGN_KEY);
        $this->forge->dropColumn('products', 'category');
    }

    public function down()
    {
        $this->forge->addColumn('products', [
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
        ]);

        $products = $this->db->table('products')
            ->select('products.id, categories.name AS category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->get()
            ->getResultArray();

        foreach ($products as $product) {
            $this->db->table('products')
                ->where('id', $product['id'])
                ->update(['category' => $product['category_name']]);
        }

        $this->forge->dropForeignKey('products', self::FOREIGN_KEY);
        $this->forge->dropColumn('products', 'category_id');
        $this->forge->modifyColumn('products', [
            'category' => [
                'name' => 'category',
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
        ]);
        $this->forge->dropTable('categories');
    }
}
