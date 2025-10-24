<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIconPathToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'icon_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'status_message',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'icon_path');
    }
}