<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'customer_address' => [
                'type' => 'TEXT',
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'],
                'default' => 'pending',
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
