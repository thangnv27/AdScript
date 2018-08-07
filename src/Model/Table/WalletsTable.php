<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WalletsTable extends Table {

    public function initialize(array $config) {
        $this->table('wallets');
        $this->primaryKey('user_id');
    }

}
