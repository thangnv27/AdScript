<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

class TagsTable extends Table {

    public function initialize(array $config) {
        $this->primaryKey('id');
        $this->addAssociations([
            'belongsToMany' => [
                'Posts' => [
                    'joinTable' => 'posts_tags',
                    'foreignKey' => 'tag_id'
                ],
                'Products' => [
                    'joinTable' => 'products_tags',
                    'foreignKey' => 'tag_id'
                ]
            ]
        ]);
    }

    public function deleteTag($entity) {
        // Delete tag relationship
        $connection = ConnectionManager::get('default');
        $connection->delete('posts_tags', ['tag_id' => $entity->id]);
        $connection->delete('products_tags', ['tag_id' => $entity->id]);

        // Delete tag
        return $this->delete($entity);
    }

}
