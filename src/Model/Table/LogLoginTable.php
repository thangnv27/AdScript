<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class LogLoginTable extends Table {

    public function initialize(array $config) {
        $this->table('log_login');
        $this->primaryKey('id');
    }

}
