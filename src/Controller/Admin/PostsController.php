<?php

namespace App\Controller\Admin;

use App\Controller\AdminsController;
use App\Controller\Component\CommonsComponent;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\I18n\Time;

class PostsController extends AdminsController {

    public $paginate = [
        'fields' => ['Posts.id', 'Posts.title', 'Posts.slug', 'Posts.image', 'Posts.status', 'Posts.created_date'],
        'limit' => 20,
        'order' => [
            'Posts.id' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $action = $this->request->query('_action');
        // Bulk move to trash
        if ($action and $action == 'bulk_trash') {
            $ids = $this->request->query('ids');
            if(!empty($ids)){
                $this->Posts->updateAll(['status' => 'trash'], ['id IN' => $ids]);
                $this->Flash->success(__('Bài viết đã được chuyển đến thùng rác!'));
            } else {
                $this->Flash->warning(__('Cần chọn ít nhất một bài viết!'));
            }
            return $this->redirect(['action' => 'index']);
        }

        // Default conditions
        $conditions = array('status <>' => 'trash');
        // Search conditions
        $s = $this->request->query('s');
        if(!empty($s)){
            $conditions['title LIKE'] = "%$s%";
        }
        // Filter conditions
        $fromDate = $this->request->query('fromDate');
        $toDate = $this->request->query('toDate');
        $cat = $this->request->query('cat');
        if(!empty($fromDate) and !empty($toDate)){
            $fromDate = Time::createFromFormat("d/m/Y", $fromDate);
            $toDate = Time::createFromFormat("d/m/Y", $toDate);
            $conditions[] = "created_date BETWEEN '" . date("Y-m-d", strtotime($fromDate)) . "' AND '" . date("Y-m-d", strtotime($toDate)) . "'";
        } else if(!empty ($fromDate)){
            $conditions['created_date >='] = Time::createFromFormat("d/m/Y", $fromDate);
        } else if(!empty($toDate)){
            $conditions['created_date <='] = Time::createFromFormat("d/m/Y", $toDate);
        }
        // Query posts
        $query = $this->Posts->find('all', array(
            'conditions' => $conditions
        ));
        // Filter category
        if(intval($cat) > 0){
            $query->matching('PostCategories', function ($q) use ($cat) {
                    return $q->where(['PostCategories.id' => intval($cat)]);
                }
            );
        }

        $catOptions = $this->Posts->PostCategories->categoryOptions(false);

        $this->set('posts', $this->paginate($query));
        $this->set('catOptions', $catOptions);
        $this->set('title', __('Quản lý bài viết'));
    }

    public function trashed() {
        $query = $this->Posts->find('all', array(
            'conditions' => array('Posts.status' => 'trash')
        ));
        $this->set('posts', $this->paginate($query));
        $this->set('title', __('Quản lý bài viết - Thùng rác'));
    }

    public function add() {
        $user = $this->Auth->user();
        $post = $this->Posts->newEntity();
        $catOptions = $this->Posts->PostCategories->categoryOptions(false);
        if ($this->request->is('post')) {
            $title = $this->request->data('title');
            $slug = $this->Commons->generateSlug($title, $this->request->data('slug'));
            $categories = $this->request->data('categories');
            $tags = $this->request->data('tags');
            $status = $this->request->data('status');
            $sticky = $this->request->data('sticky');
            if(!$sticky){
                $sticky = 0;
            }

            $slug_check = $this->Posts->find('all', array(
                'conditions' => array('Posts.slug' => $slug)
            ));

            while ($slug_check->count() > 0) {
                $slug .= "-2";
                $slug_check = $this->Posts->find('all', array(
                    'conditions' => array('Posts.slug' => $slug)
                ));
            }

            if (empty($title)) {
                $this->Flash->warning(__('Vui lòng nhập Tiêu đề bài viết!'));
            } else if(empty($categories)){
                $this->Flash->warning(__('Vui lòng chọn ít nhất 1 danh mục!'));
            } else if (!in_array($status, CommonsComponent::getPostStatusKeys())) {
                $this->Flash->warning(__('Trạng thái bài viết không hợp lệ!'));
            } else {
                $post->title = $title;
                $post->slug = $slug;
                $post->content = $this->request->data('content');
                $post->excerpt = $this->request->data('excerpt');
                $post->image = $this->request->data('image');
                $post->status = $status;
                $post->sticky = $sticky;
                $post->user_id = $user->id;
                $savedPost = $this->Posts->save($post);
                if ($savedPost) {
                    $this->Flash->success(__('Thêm bài viết mới thành công!'));

                    // Set categories
                    $categories_list = array();
                    foreach ($categories as $category_id) {
                        $category = $this->Posts->PostCategories->findById($category_id)->first();
                        if($category){
                            $categories_list[] = $category;
                        }
                    }
                    $this->Posts->PostCategories->link($savedPost, $categories_list);

                    // Insert tags
                    $tags_list = array();
                    if(!empty($tags)){
                        // Tags to lowercase
                        $tags = array_map('strtolower', $tags);

                        foreach ($tags as $tag_name) {
                            $tag_name = trim($tag_name);
                            $tag_slug = $this->Commons->generateSlug($tag_name);
                            $tag = $this->Posts->Tags->findBySlug($tag_slug)->first();
                            if(!$tag){
                                $tag = $this->Posts->Tags->newEntity();
                                $tag->name = $tag_name;
                                $tag->slug = $tag_slug;
                                $tag = $this->Posts->Tags->save($tag);
                            }
                            $tags_list[] = $tag;
                        }
                        $this->Posts->Tags->link($savedPost, $tags_list);
                    }

                    return $this->redirect(['action' => 'edit', $savedPost->id]);
                }
                $this->Flash->error(__('Không thể thêm bài viết mới!'));
            }
        }
        $this->set('post', $post);
        $this->set('catOptions', $catOptions);
        $this->set('title', __('Thêm bài viết mới'));
    }

    public function edit($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $post = $this->Posts->get($id, ['contain' => ['PostCategories', 'Tags']]);
        $catOptions = $this->Posts->PostCategories->categoryOptions(false);
        if ($this->request->is(['post', 'put'])) {
            $title = $this->request->data('title');
            $slug = $this->request->data('slug');
            $categories = $this->request->data('categories');
            $tags = $this->request->data('tags');
            $status = $this->request->data('status');
            $sticky = $this->request->data('sticky');
            if(!$sticky){
                $sticky = 0;
            }
            if (empty($slug)) {
                $slug = $this->Commons->generateSlug($title, $this->request->data('slug'));

                $slug_check = $this->Posts->find('all', array(
                    'conditions' => array('Posts.slug' => $slug)
                ));

                while ($post->slug != $slug and $slug_check->count() > 0) {
                    $slug .= "-2";
                    $slug_check = $this->Posts->find('all', array(
                        'conditions' => array('Posts.slug' => $slug)
                    ));
                }
            }

            if (empty($title)) {
                $this->Flash->warning(__('Vui lòng nhập Tiêu đề bài viết!'));
            } else if(empty($categories)){
                $this->Flash->warning(__('Vui lòng chọn ít nhất 1 danh mục!'));
            } else if (!in_array($status, CommonsComponent::getPostStatusKeys())) {
                $this->Flash->warning(__('Trạng thái bài viết không hợp lệ!'));
            } else {
                $post->title = $title;
                $post->slug = $slug;
                $post->content = $this->request->data('content');
                $post->excerpt = $this->request->data('excerpt');
                $post->image = $this->request->data('image');
                $post->status = $status;
                $post->sticky = $sticky;
                $post->updated_date = date('Y-m-d H:i:s');
                $savedPost = $this->Posts->save($post);

                if ($savedPost) {
                    $this->Flash->success(__('Cập nhật thành công!'));

                    ## Set categories
                    $categories_linked = array();
                    $categories_list = array();
                    $categories_unlinks = array();
                    // unlink categories
                    foreach ($post->post_categories as $cat) {
                        $categories_linked[] = $cat->id;
                        if(!in_array($cat->id, $categories)){
                            $categories_unlinks[] = $cat;
                        }
                    }
                    // link new categories
                    foreach ($categories as $category_id) {
                        if(!in_array($category_id, $categories_linked)){
                            $category = $this->Posts->PostCategories->findById($category_id)->first();
                            if($category){
                                $categories_list[] = $category;
                            }
                        }
                    }
                    // Save Associate
                    if(!empty($categories_list)){
                        $this->Posts->PostCategories->link($savedPost, $categories_list);
                    }
                    if(!empty($categories_unlinks)){
                        $this->Posts->PostCategories->unlink($savedPost, $categories_unlinks);
                    }

                    // Insert tags
                    $tags_linked = array();
                    $tags_list = array();
                    $tags_unlinks = array();
                    if(!empty($tags)){
                        // Tags to lowercase
                        $tags = array_map('strtolower', $tags);
                        // unlink tags
                        foreach ($post->tags as $tag) {
                            $tags_linked[] = $tag->slug;
                            if(!in_array($tag->name, $tags)){
                                $tags_unlinks[] = $tag;
                            }
                        }
                        // link new tags
                        foreach ($tags as $tag_name) {
                            $tag_name = trim($tag_name);
                            $tag_slug = $this->Commons->generateSlug($tag_name);
                            if(!in_array($tag_slug, $tags_linked)){
                                $tag = $this->Posts->Tags->findBySlug($tag_slug)->first();
                                if(!$tag){
                                    $tag = $this->Posts->Tags->newEntity();
                                    $tag->name = $tag_name;
                                    $tag->slug = $tag_slug;
                                    $tag = $this->Posts->Tags->save($tag);
                                }
                                $tags_list[] = $tag;
                            }
                        }
                        // Save Associate
                        if(!empty($tags_list)){
                            $this->Posts->Tags->link($savedPost, $tags_list);
                        }
                        if(!empty($tags_unlinks)){
                            $this->Posts->Tags->unlink($savedPost, $tags_unlinks);
                        }
                    }

                    return $this->redirect(['action' => 'edit', $id]);
                }

                $this->Flash->error(__('Cập nhật không thành công!'));
            }
        }
        $this->set('post', $post);
        $this->set('catOptions', $catOptions);
        $this->set('title', __('Chỉnh sửa bài viết'));
    }

    public function duplicate($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Auth->user();
        $post = $this->Posts->get($id, ['contain' => ['PostCategories', 'Tags']]);
        $slug = $post->slug . "-2";
        $slug_check = $this->Posts->find('all', array(
            'conditions' => array('Posts.slug' => $slug)
        ));

        while ($slug_check->count() > 0) {
            $slug .= "-2";
            $slug_check = $this->Posts->find('all', array(
                'conditions' => array('Posts.slug' => $slug)
            ));
        }

        $new_post = $this->Posts->newEntity();
        $new_post->title = $post->title;
        $new_post->slug = $slug;
        $new_post->content = $post->content;
        $new_post->excerpt = $post->excerpt;
        $new_post->image = $post->image;
        $new_post->status = 'draft';
        $new_post->sticky = 0;
        $new_post->user_id = $user->id;
        $savedPost = $this->Posts->save($new_post);
        if ($savedPost) {
            $this->Flash->success(__('Nhân bản thành công!'));

            // Set categories
            $categories_list = array();
            foreach ($post->post_categories as $category) {
                $category = $this->Posts->PostCategories->findById($category->id)->first();
                $categories_list[] = $category;
            }
            $this->Posts->PostCategories->link($savedPost, $categories_list);

            // Set tags
            $tags_list = array();
            foreach ($post->tags as $tag) {
                $tag = $this->Posts->Tags->findById($tag->id)->first();
                $tags_list[] = $tag;
            }
            $this->Posts->Tags->link($savedPost, $tags_list);

            return $this->redirect(['action' => 'edit', $savedPost->id]);
        }
        $this->Flash->error(__('Nhân bản không thành công!'));
        return $this->redirect(['action' => 'edit', $id]);
    }

    /**
     * Move post to trash
     * 
     * @param int $id Post ID
     * @return action
     */
    public function trash($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $post = $this->Posts->get($id);
        $post->status = 'trash';
        $savedPost = $this->Posts->save($post);
        if ($savedPost) {
            $this->Flash->success(__('Bài viết đã được chuyển đến thùng rác!'));
        } else {
            $this->Flash->error(__('Xảy ra lỗi!'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete a post permanently
     * 
     * @param int $id Post ID
     * @return action
     */
    public function delete($id) {
        if ($id <= 0) {
            return $this->redirect(['action' => 'index']);
        }
        $post = $this->Posts->get($id, ['contain' => ['PostCategories', 'Tags']]);
        if ($post) {
            // unlink categories
            $this->Posts->PostCategories->unlink($post, $post->post_categories);

            // unlink tags
            $this->Posts->Tags->unlink($post, $post->tags);

            // Delete post
            $this->Posts->delete($post);
            $this->Flash->success(__('Đã xóa bài viết thành công!'));
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
        $query = $this->Posts->find('list', array(
            'fields' => ['id'],
            'conditions' => array('Posts.status' => 'trash')
        ));
        $array = $query->toArray();
        $ids = array_keys($array);
        if(!empty($ids)){
            $this->Posts->emptyTrash($ids);
            $this->Flash->success(__('Đã làm rỗng thùng rác!'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
