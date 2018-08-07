<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

class OffersTable extends Table {

    public function initialize(array $config) {
        $this->primaryKey('id');
        $this->addAssociations([
            'belongsTo' => ['Users'],
        ]);
    }

}
