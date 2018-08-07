<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

class PostsTable extends Table {

    public function initialize(array $config) {
        $this->primaryKey('id');
        $this->addAssociations([
//            'belongsTo' => ['Users'],
//            'hasMany' => ['Comments'],
            'belongsToMany' => [
                'Tags' => [
                    'joinTable' => 'posts_tags',
                    'foreignKey' => 'post_id'
                ],
                'PostCategories' => [
                    'className' => 'App\Model\Table\PostCategoriesTable',
                    'joinTable' => 'post_cat_relationship',
                    'foreignKey' => 'post_id',
                    'targetForeignKey' => 'cat_id'
                ]
            ]
        ]);
    }

    public function emptyTrash($ids) {
        // Delete posts
        $this->deleteAll(array('id IN' => $ids));

        // Delete post relationship
        $connection = ConnectionManager::get('default');
        $connection->delete('posts_tags', ['post_id IN' => $ids]);
        $connection->delete('post_cat_relationship', ['post_id IN' => $ids]);
    }

}
