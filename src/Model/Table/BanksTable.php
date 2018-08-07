<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

class BanksTable extends Table {

    public function initialize(array $config) {
        $this->primaryKey('id');
//        $this->addAssociations([
//            'belongsToMany' => [
//                'Posts' => [
//                    'joinTable' => 'posts_banks',
//                    'foreignKey' => 'tag_id'
//                ]
//            ]
//        ]);
    }

    public function deleteTag($entity) {
        // Delete tag relationship
//        $connection = ConnectionManager::get('default');
//        $connection->delete('posts_banks', ['tag_id' => $entity->id]);

        // Delete tag
        return $this->delete($entity);
    }

}
