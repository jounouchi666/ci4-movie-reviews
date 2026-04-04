<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTMDbInfotoMovies extends Migration
{
    public function up()
    {
        $this->forge->addColumn('movies', [
            'tmdb_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'user_id'
            ],
            'poster_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'genre'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('movies', 'tmdb_id');
        $this->forge->dropColumn('movies', 'poster_path');
    }
}
