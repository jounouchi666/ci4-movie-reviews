<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersDropUsernameUnique extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE users DROP INDEX username');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE users ADD UNIQUE(username)');
    }
}