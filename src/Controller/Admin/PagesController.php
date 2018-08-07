<?php

namespace App\Controller\Admin;

use App\Controller\AdminsController;
use App\Controller\Component\CommonsComponent;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

class PagesController extends AdminsController {

    public $paginate = [
        'fields' => ['Pages.id', 'Pages.title', 'Pages.slug', 'Pages.status', 'Pages.created_date'],
        'limit' => 20,
        'order' => [
            'Pages.id' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $query = $this->Pages->find('all', array(
            'conditions' => array('Pages.status <>' => 'trash')
        ));
        $this->set('pages', $this->paginate($query));
        $this->set('title', __('Quản lý trang'));
    }

    public function trashed() {
        $query = $this->Pages->find('all', array(
            'conditions' => array('Pages.status' => 'trash')
        ));
        $this->set('pages', $this->paginate($query));
        $this->set('title', __('Quản lý trang - Thùng rác'));
    }

    public function add() {
        $page = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $title = $this->request->data('title');
            $slug = $this->Commons->generateSlug($title, $this->request->data('slug'));
            $status = $this->request->data('status');

            $slug_check = $this->Pages->find('all', array(
                'conditions' => array('Pages.slug' => $slug)
            ));

            while ($slug_check->count() > 0) {
                $slug .= "-2";
                $slug_check = $this->Pages->find('all', array(
                    'conditions' => array('Pages.slug' => $slug)
                ));
            }

            if (empty($title)) {
                $this->Flash->warning(__('Vui lòng nhập Tiêu đề trang!'));
            } else if (!in_array($status, CommonsComponent::getPostStatusKeys())) {
                $this->Flash->warning(__('Trạng thái trang không hợp lệ!'));
            } else {
                $page->title = $title;
                $page->slug = $slug;
                $page->content = $this->request->data('content');
                $page->excerpt = $this->request->data('excerpt');
                $page->image = $this->request->data('image');
                $page->status = $status;
                $savedPage = $this->Pages->save($page);
                if ($savedPage) {
                    $this->Flash->success(__('Thêm trang mới thành công!'));
                    return $this->redirect(['action' => 'edit', $savedPage->id]);
                }
                $this->Flash->error(__('Không thể thêm trang mới!'));
            }
        }
        $this->set('page', $page);
        $this->set('title', __('Thêm trang mới'));
    }

    public function edit($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $page = $this->Pages->get($id);
        if ($this->request->is(['post', 'put'])) {
            $title = $this->request->data('title');
            $slug = $this->request->data('slug');
            $status = $this->request->data('status');

            if (empty($slug)) {
                $slug = $this->Commons->generateSlug($title, $this->request->data('slug'));

                $slug_check = $this->Pages->find('all', array(
                    'conditions' => array('Pages.slug' => $slug)
                ));

                while ($page->slug != $slug and $slug_check->count() > 0) {
                    $slug .= "-2";
                    $slug_check = $this->Pages->find('all', array(
                        'conditions' => array('Pages.slug' => $slug)
                    ));
                }
            }

            if (empty($title)) {
                $this->Flash->warning(__('Vui lòng nhập Tiêu đề trang!'));
            } else if (!in_array($status, CommonsComponent::getPostStatusKeys())) {
                $this->Flash->warning(__('Trạng thái trang không hợp lệ!'));
            } else {
                $page->title = $title;
                $page->slug = $slug;
                $page->content = $this->request->data('content');
                $page->excerpt = $this->request->data('excerpt');
                $page->image = $this->request->data('image');
                $page->status = $status;
                $page->updated_date = date('Y-m-d H:i:s');

                if ($this->Pages->save($page)) {
                    $this->Flash->success(__('Cập nhật thành công!'));
                    return $this->redirect(['action' => 'edit', $id]);
                }

                $this->Flash->error(__('Cập nhật không thành công!'));
            }
        }
        $this->set('page', $page);
        $this->set('title', __('Chỉnh sửa trang'));
    }

    public function duplicate($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $page = $this->Pages->get($id);
        $slug = $page->slug . "-2";
        $slug_check = $this->Pages->find('all', array(
            'conditions' => array('Pages.slug' => $slug)
        ));

        while ($slug_check->count() > 0) {
            $slug .= "-2";
            $slug_check = $this->Pages->find('all', array(
                'conditions' => array('Pages.slug' => $slug)
            ));
        }

        $new_page = $this->Pages->newEntity();
        $new_page->title = $page->title;
        $new_page->slug = $slug;
        $new_page->content = $page->content;
        $new_page->excerpt = $page->excerpt;
        $new_page->image = $page->image;
        $new_page->status = 'draft';
        $savedPage = $this->Pages->save($new_page);
        if ($savedPage) {
            $this->Flash->success(__('Nhân bản thành công!'));
            return $this->redirect(['action' => 'edit', $savedPage->id]);
        }
        $this->Flash->error(__('Nhân bản không thành công!'));
        return $this->redirect(['action' => 'edit', $id]);
    }

    /**
     * Move page to trash
     * 
     * @param int $id Page ID
     * @return action
     */
    public function trash($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $page = $this->Pages->get($id);
        $page->status = 'trash';
        $savedPage = $this->Pages->save($page);
        if ($savedPage) {
            $this->Flash->success(__('Trang đã được chuyển đến thùng rác!'));
        } else {
            $this->Flash->error(__('Xảy ra lỗi!'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete a page permanently
     * 
     * @param int $id Page ID
     * @return action
     */
    public function delete($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('Đã xóa trang thành công!'));
        } else {
            $this->Flash->error(__('Xảy ra lỗi!'));
        }
        return $this->redirect(['action' => 'trashed']);
    }

    /**
     * Empty trash
     * 
     * @return action
     */
    public function emptyTrash() {
        $this->Pages->deleteAll(array('Pages.status' => 'trash'));
        $this->Flash->success(__('Đã làm rỗng thùng rác!'));
        return $this->redirect(['action' => 'index']);
    }
}
