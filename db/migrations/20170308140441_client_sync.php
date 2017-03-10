<?php

use Phinx\Migration\AbstractMigration;

class ClientSync extends AbstractMigration
{
    public function up() {
        $table = $this->table('companies');
        $table->addColumn('is_client', 'boolean', [
            'default' => false
        ]);
        $table->addColumn('sonovate3_client_id', 'integer', [
            'null' => true
        ]);
        $table->update();
    }

    public function down() {
        $table = $this->table('companies');
        $table->removeColumn('is_client');
        $table->removeColumn('sonovate3_client_id');
        $table->update();
    }
}
