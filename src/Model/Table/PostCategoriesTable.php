<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\CommonsComponent;

class PostCategoriesTable extends Table {

    public function initialize(array $config) {
        $this->table('post_categories');
        $this->primaryKey('id');
        $this->entityClass('App\Model\Entity\PostCategory');
        $this->addAssociations([
            'belongsToMany' => [
                'Posts' => [
                    'className' => 'App\Model\Table\PostsTable',
                    'joinTable' => 'post_cat_relationship',
                    'foreignKey' => 'cat_id',
                    'targetForeignKey' => 'post_id'
                ]
            ]
        ]);
    }
    
    public function deleteCategory($entity, $new_cat_id) {
        // Change category parent
        $this->updateAll(['parent' => $entity->parent], ['parent' => $entity->id]);

        // Change category for posts
        $connection = ConnectionManager::get('default');
        $connection->update('post_cat_relationship', ['cat_id' => $new_cat_id], ['cat_id' => $entity->id]);

        // Delete category
        return $this->delete($entity);
    }

    /**
     * @param bool $has_none First item is None
     * @return array 
     */
    public function categoryOptions($has_none = true) {
        $result = array();
        if ($has_none) {
            $result = array('0' => __('Không'));
        }
        $categories = $this->find('all', array(
                    'fields' => array('id', 'name'),
                    'conditions' => array('parent' => 0),
                    'order' => array('name' => 'asc')
                ))->all()->toArray();

        foreach ($categories as $category) {
            $result[$category->id] = $category->name;
            $childs = $this->categoryChildOptions($category->id, 0);
            $result = $result + $childs;
        }
        return $result;
    }

    /**
     * 
     * @param int $parent Category parent
     * @return array 
     */
    function categoryChildOptions($parent, $indent = 0) {
        $result = array();
        $categories = $this->find('all', array(
                    'fields' => array('id', 'name'),
                    'conditions' => array('parent' => intval($parent)),
                    'order' => array('name' => 'asc')
                ))->all()->toArray();

        foreach ($categories as $category) {
            $result[$category->id] = CommonsComponent::indentSpace($indent + 4) . $category->name;
            $childs = $this->categoryChildOptions($category->id, $indent + 4);
            $result = $result + $childs;
        }
        return $result;
    }

    /**
     * Get data table
     * 
     * @return array 
     */
    function categoryRowsTable() {
        $result = array();
        $categories = $this->find('all', array(
                    'fields' => array('id', 'name', 'slug', 'parent'),
                    'conditions' => array('parent' => 0),
                    'order' => array('name' => 'asc')
                ))->all()->toArray();

        foreach ($categories as $category) {
            $result[] = $category;
            $childs = $this->categoryChildRowsTable($category->id, 0);
            foreach ($childs as $child) {
                $result[] = $child;
            }
        }
        return $result;
    }

    /**
     * Get data table by category parent
     * @param int $parent Category parent
     * @return array 
     */
    function categoryChildRowsTable($parent, $indent = 0) {
        $result = array();
        $categories = $this->find('all', array(
                    'fields' => array('id', 'name', 'slug', 'parent'),
                    'conditions' => array('parent' => intval($parent)),
                    'order' => array('name' => 'asc')
                ))->all()->toArray();

        foreach ($categories as $category) {
            $category->name = CommonsComponent::indentDash($indent + 1) . " " . $category->name;
            $result[] = $category;
            $childs = $this->categoryChildRowsTable($category->id, $indent + 1);
            foreach ($childs as $child) {
                $result[] = $child;
            }
        }
        return $result;
    }

}
