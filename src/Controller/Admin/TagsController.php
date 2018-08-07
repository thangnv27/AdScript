<?php

namespace App\Controller\Admin;

use App\Controller\AdminsController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

class TagsController extends AdminsController {

    public $paginate = [
        'fields' => ['Tags.id', 'Tags.name', 'Tags.slug'],
        'limit' => 20,
        'order' => [
            'Tags.id' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $this->set('tags', $this->paginate('Tags'));
        $this->set('title', __('Tags (Thẻ/Nhãn)'));
    }

    public function find() {
        $q = $this->request->query('q');
        $query = $this->Tags->find('all', [
            'fields' => ['name'],
            'limit' => 30,
            'conditions' => ['name LIKE' => "%$q%"]
        ]);
        echo json_encode(array(
            'items' => $query,
            'total_count' => $query->count(),
        ), JSON_PRETTY_PRINT);
        exit;
    }

    public function add() {
        if ($this->request->is('post')) {
            $tag = $this->Tags->newEntity();
            $name = $this->request->data('name');
            $slug = $this->Commons->generateSlug($name, $this->request->data('slug'));

            $slug_check = $this->Tags->find('all', array(
                'conditions' => array('Tags.slug' => $slug)
            ));

            while ($slug_check->count() > 0) {
                $slug .= "-2";
                $slug_check = $this->Tags->find('all', array(
                    'conditions' => array('Tags.slug' => $slug)
                ));
            }

            if (empty($name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên thẻ!'));
            } else {
                $tag->name = $name;
                $tag->slug = $slug;
                $tag->description = $this->request->data('description');
                $tag->image = $this->request->data('image');
                $savedTag = $this->Tags->save($tag);
                if ($savedTag) {
                    $this->Flash->success(__('Thêm thẻ mới thành công!'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        $this->Flash->error(__('Thêm thẻ không thành công!'));
    }

    public function edit($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $tag = $this->Tags->get($id);
        if (!$tag) {
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['post', 'put'])) {
            $name = $this->request->data('name');

            if (empty($slug)) {
                $slug = $this->Commons->generateSlug($name, $this->request->data('slug'));
                $slug_check = $this->Tags->find('all', array(
                    'conditions' => array('Tags.slug' => $slug)
                ));

                while ($tag->slug != $slug and $slug_check->count() > 0) {
                    $slug .= "-2";
                    $slug_check = $this->Tags->find('all', array(
                        'conditions' => array('Tags.slug' => $slug)
                    ));
                }
            }

            if (empty($name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên thẻ!'));
            } else {
                $tag->name = $name;
                $tag->slug = $slug;
                $tag->description = $this->request->data('description');
                $tag->image = $this->request->data('image');
                $tag->updated_date = date('Y-m-d H:i:s');

                if ($this->Tags->save($tag)) {
                    $this->Flash->success(__('Cập nhật thành công!'));
                    return $this->redirect(['action' => 'edit', $id]);
                }

                $this->Flash->error(__('Cập nhật không thành công!'));
            }
        }
        $this->set('tag', $tag);
        $this->set('title', __('Chỉnh sửa thẻ'));
    }

    public function delete($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $tag = $this->Tags->get($id);
        if ($tag) {
            $this->Tags->deleteTag($tag);
            $this->Flash->success(__('Đã xóa thẻ!'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
