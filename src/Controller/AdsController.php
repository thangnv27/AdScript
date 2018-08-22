<?php

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Event\Event;

class AdsController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Tạo quảng cáo
     */
    public function add(){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Offers', 'action' => 'createSell']);
        $og_image = SITE_URL . '/img/frontend/logo.png';

        if ($this->request->is('post')) {
            $status = "error";
            $msg = "";
            $redirect_url = "";
            $user = $this->Auth->user();
            $title = $this->request->data('title');
            $description = $this->request->data('description');
            $image_url = $this->request->data('image_url');
            $target_url = $this->request->data('target_url');
            $utm_params = $this->request->data('utm_params');
            $_status = $this->request->data('status');
            
            if(empty($title)){
                $msg = "Title is required!";
            } else if(empty($image_url)){
                $msg = "Image URL is required!";
            } else if(empty($target_url)){
                $msg = "Target URL is required!";
            } else if(!in_array($_status, array(0,1))){
                $msg = "Status is invalid!";
            } else {
                $entity = $this->Ads->newEntity();
                $entity->user_id = $user->id;
                $entity->title = $title;
                $entity->description = $description;
                $entity->image_url = $image_url;
                $entity->target_url = $target_url;
                $entity->utm_params = $utm_params;
                $entity->status = $_status;
                $entity->created_date = date('Y-m-d H:i:s');
                $entity->updated_date = date('Y-m-d H:i:s');

                if($this->Ads->save($entity)){
                    $msg = "Ads created successfully!";
                    $status = "success";
                    $redirect_url = Router::url(['controller' => 'Dashboard', 'action' => 'index']);
                } else {
                    $msg = "Ads creation failed!";
                }
            }

            echo json_encode(array(
                'status' => $status,
                'message' => $msg,
                'redirect_url' => $redirect_url,
            ));
            exit;
        }
        
        $this->set('title', 'Create an Ad banner');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
    /**
     * Kích hoạt quảng cáo
     */
    public function activate($id = 0){
        if ($this->request->is('post')) {
            $entity = $this->Ads->get($id);
            $entity->status = 1;
            if($this->Ads->save($entity)){
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Ad activated successfully!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Ad activation failed!',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Error occurred!',
            ));
        }
        exit;
    }
    
    /**
     * Tạm dừng quảng cáo
     */
    public function deactivate($id = 0){
        if ($this->request->is('post')) {
            $entity = $this->Ads->get($id);
            $entity->status = 0;
            if($this->Ads->save($entity)){
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Ad deactivate successfully!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Ad deactivation failed!',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Error occurred!',
            ));
        }
        exit;
    }
    
    /**
     * Xóa quảng cáo
     */
    public function deleteOffer($id = 0){
        if ($this->request->is('post')) {
            $entity = $this->Ads->get($id);
            if($this->Ads->delete($entity)){
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Ad deleted successfully!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Delete failed!',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Error occurred!',
            ));
        }
        exit;
    }

}
