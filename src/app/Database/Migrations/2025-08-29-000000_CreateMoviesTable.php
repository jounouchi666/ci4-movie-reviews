<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMoviesTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'year' => [
                'type' => 'SMALLINT',
                'unsigned' => true,
            ],
            'genre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'rating' => [
                'type' => 'TINYINT',
                'unsigned' => true,
            ],
            'review' => [
                'type' => 'TEXT',
                'null' => true
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
        $this->forge->createTable('movies');
    }

    public function down()
    {
        $this->forge->dropTable('movies');
    }
}
