<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UserMetaTable extends Table {

    public function initialize(array $config) {
        $this->table('user_meta');
        $this->primaryKey('user_id');
    }

}
