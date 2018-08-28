<?php

namespace App\Controller\Admin;

use App\Controller\AdminsController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Routing\Router;

class PostCategoriesController extends AdminsController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $catOptions = $this->PostCategories->categoryOptions();
        $catRowsTable = $this->PostCategories->categoryRowsTable();

        $this->set('catOptions', $catOptions);
        $this->set('catRowsTable', $catRowsTable);
        $this->set('title', __('Danh mục bài viết'));
    }

    public function add() {
        $status = "error";
        $msg = __('Xảy ra lỗi!');
        $options = "";
        $body = "";

        if ($this->request->is('post')) {
            $category = $this->PostCategories->newEntity();
            $name = $this->request->data('name');
            $slug = $this->Commons->generateSlug($name, $this->request->data('slug'));
            $parent = $this->request->data('parent');

            $slug_check = $this->PostCategories->find('all', array(
                'conditions' => array('PostCategories.slug' => $slug)
            ));

            while ($slug_check->count() > 0) {
                $slug .= "-2";
                $slug_check = $this->PostCategories->find('all', array(
                    'conditions' => array('PostCategories.slug' => $slug)
                ));
            }

            if (empty($name)) {
                $msg = __('Vui lòng nhập Tên danh mục!');
            } else if (intval($parent) < 0) {
                $msg = __('Danh mục cha không hợp lệ!');
            } else {
                $category->name = $name;
                $category->slug = $slug;
                $category->description = $this->request->data('description');
                $category->image = $this->request->data('image');
                $category->parent = intval($parent);
                $category->created_date = date('Y-m-d H:i:s');
                $category->updated_date = date('Y-m-d H:i:s');
                $savedCategory = $this->PostCategories->save($category);
                if ($savedCategory) {
                    $status = "success";
                    $msg = __('Thêm danh mục mới thành công!');

                    // Query data options
                    $catOptions = $this->PostCategories->categoryOptions();
                    foreach ($catOptions as $id => $name) :
                        $options .= '<option value="' . $id . '">' . $name . '</option>';
                    endforeach;

                    // Query data table
                    $catRowsTable = $this->PostCategories->categoryRowsTable();
                    foreach ($catRowsTable as $cat) :
                        $viewUrl = Router::url(['prefix' => false, 'controller' => 'PostCategories', 'action' => 'view', $cat->slug]);
                        $viewText = __('Xem chuyên mục');
                        $editUrl = Router::url(['controller' => 'PostCategories', 'action' => 'edit', $cat->id]);
                        $editText = __('Chỉnh sửa');
                        $deleteUrl = Router::url(['controller' => 'PostCategories', 'action' => 'delete', $cat->id]);
                        $deleteText = __('Xóa');
                        $body .= <<<HTML
<tr class="background-tr">
    <td>{$cat->id}</td>
    <td class="left">
        <a href="{$editUrl}" title="{$editText}">{$cat->name}</a>
    </td>
    <td class="left">{$cat->slug}</td>
    <td>
        <a href="{$viewUrl}" class="btn btn-primary btn-xs" title="{$viewText}" target="_blank">
            <i class="fa fa-eye"></i>
        </a>
        <a href="{$editUrl}" class="btn btn-primary btn-xs" title="{$editText}">
            <i class="fa fa-pencil"></i>
        </a>
        <a href="{$deleteUrl}" class="btn btn-danger btn-xs" title="{$deleteText}">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
HTML;
                    endforeach;
                }
            }
        }
        echo json_encode(array(
            'status' => $status,
            'message' => $msg,
            'options' => $options,
            'body' => $body
        ));
        exit;
    }

    public function edit($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $category = $this->PostCategories->get($id);
        if (!$category) {
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['post', 'put'])) {
            $name = $this->request->data('name');
            $parent = $this->request->data('parent');

            if (empty($slug)) {
                $slug = $this->Commons->generateSlug($name, $this->request->data('slug'));
                $slug_check = $this->PostCategories->find('all', array(
                    'conditions' => array('PostCategories.slug' => $slug)
                ));

                while ($category->slug != $slug and $slug_check->count() > 0) {
                    $slug .= "-2";
                    $slug_check = $this->PostCategories->find('all', array(
                        'conditions' => array('PostCategories.slug' => $slug)
                    ));
                }
            }

            if (empty($name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên danh mục!'));
            } else if (intval($parent) < 0) {
                $this->Flash->warning(__('Danh mục cha không hợp lệ!'));
            } else {
                $category->name = $name;
                $category->slug = $slug;
                $category->description = $this->request->data('description');
                $category->image = $this->request->data('image');
                $category->parent = intval($parent);
                $category->updated_date = date('Y-m-d H:i:s');

                if ($this->PostCategories->save($category)) {
                    $this->Flash->success(__('Cập nhật thành công!'));
                    return $this->redirect(['action' => 'edit', $id]);
                }

                $this->Flash->error(__('Cập nhật không thành công!'));
            }
        }
        $catOptions = $this->PostCategories->categoryOptions();
        $this->set('category', $category);
        $this->set('catOptions', $catOptions);
        $this->set('title', __('Chỉnh sửa danh mục bài viết'));
    }

    public function delete($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $category = $this->PostCategories->get($id);
        if (!$category) {
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['post', 'put'])) {
            $cat = $this->request->data('cat');
            if ($cat <= 0) {
                $this->Flash->warning(__('Danh mục không hợp lệ!'));
            } else if ($cat == $id) {
                $this->Flash->warning(__('Không thể chọn danh mục hiện tại!'));
            } else {
                $this->PostCategories->deleteCategory($category, $cat);
                $this->Flash->success(__('Đã xóa danh mục bài viết!'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $catOptions = $this->PostCategories->categoryOptions(false);
        $this->set('category', $category);
        $this->set('catOptions', $catOptions);
        $this->set('title', __('Xóa danh mục bài viết'));
    }

}
