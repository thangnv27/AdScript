<?php

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class OffersController extends AppController {

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
            $price = str_replace(",", "", $this->request->data('price'));
            $price_view = str_replace(",", "", $this->request->data('price_view'));
            $min_amount = str_replace(",", "", $this->request->data('min_amount'));
            $max_amount = str_replace(",", "", $this->request->data('max_amount'));
            $limit_time = $this->request->data('limit_time');
            
            if($price < 15925 or $price > 45500){
                $msg = "Giá bạn thực nhận phải nằm trong khoảng từ 15,925.00 đên 45,500.00";
            } else if($min_amount < 5){
                $msg = "Giới hạn tối thiểu là 5.00 USD";
            } else if($max_amount > 100000){
                $msg = "Giới hạn tối đa là 100,000.00 USD";
            } else if(!in_array($limit_time, array(15, 30))){
                $msg = "Giới hạn thời gian không đúng!";
            } else {
                $offer = $this->Offers->newEntity();
                $offer->user_id = $user->id;
                $offer->offer_type = "sell";
                $offer->price = $price;
                $offer->price_view = $price_view;
                $offer->min_amount = $min_amount;
                $offer->max_amount = $max_amount;
                $offer->limit_time = $limit_time;

                if($this->Offers->save($offer)){
                    $msg = "Tạo quảng cáo thành công!";
                    $status = "success";
                    $redirect_url = Router::url(['controller' => 'Dashboard', 'action' => 'myOffers']);
                } else {
                    $msg = "Tạo quảng cáo không thành công!";
                }
            }
            
            echo json_encode(array(
                'status' => $status,
                'message' => $msg,
                'redirect_url' => $redirect_url,
            ));
            exit;
        }
        
        $this->set('title', 'Tạo quảng cáo Bán WEX');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
    /**
     * Tạo quảng cáo Mua
     */
    public function createBuy(){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Offers', 'action' => 'createBuy']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        if ($this->request->is('post')) {
            $status = "error";
            $msg = "";
            $redirect_url = "";
            $user = $this->Auth->user();
            $price = str_replace(",", "", $this->request->data('price'));
            $price_view = str_replace(",", "", $this->request->data('price_view'));
            $min_amount = str_replace(",", "", $this->request->data('min_amount'));
            $max_amount = str_replace(",", "", $this->request->data('max_amount'));
            $limit_time = $this->request->data('limit_time');
            
            if($price < 15925 or $price > 45500){
                $msg = "Giá bạn thực trả phải nằm trong khoảng từ 15,925.00 đên 45,500.00";
            } else if($min_amount < 5){
                $msg = "Giới hạn tối thiểu là 5.00 USD";
            } else if($max_amount > 100000){
                $msg = "Giới hạn tối đa là 100,000.00 USD";
            } else if(!in_array($limit_time, array(15, 30))){
                $msg = "Giới hạn thời gian không đúng!";
            } else {
                $offer = $this->Offers->newEntity();
                $offer->user_id = $user->id;
                $offer->offer_type = "buy";
                $offer->price = $price;
                $offer->price_view = $price_view;
                $offer->min_amount = $min_amount;
                $offer->max_amount = $max_amount;
                $offer->limit_time = $limit_time;

                if($this->Offers->save($offer)){
                    $msg = "Tạo quảng cáo thành công!";
                    $status = "success";
                    $redirect_url = Router::url(['controller' => 'Dashboard', 'action' => 'myOffers']);
                } else {
                    $msg = "Tạo quảng cáo không thành công!";
                }
            }
            
            echo json_encode(array(
                'status' => $status,
                'message' => $msg,
                'redirect_url' => $redirect_url,
            ));
            exit;
        }
        
        $this->set('title', 'Tạo quảng cáo Mua WEX');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
    /**
     * Kích hoạt quảng cáo
     */
    public function activateOffer($id = 0){
        if ($this->request->is('post')) {
            $offer = $this->Offers->get($id);
            $offer->status = 1;
            if($this->Offers->save($offer)){
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Kích hoạt thành công!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Kích hoạt không thành công!',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Xảy ra lỗi!',
            ));
        }
        exit;
    }
    
    /**
     * Tạm dừng quảng cáo
     */
    public function deactivateOffer($id = 0){
        if ($this->request->is('post')) {
            $offer = $this->Offers->get($id);
            $offer->status = 0;
            if($this->Offers->save($offer)){
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Tạm dừng thành công!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Tạm dừng không thành công!',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Xảy ra lỗi!',
            ));
        }
        exit;
    }
    
    /**
     * Xóa quảng cáo
     */
    public function deleteOffer($id = 0){
        if ($this->request->is('post')) {
            $offer = $this->Offers->get($id);
            if($this->Offers->delete($offer)){
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Xóa quảng cáo thành công!',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Xóa quảng cáo không thành công!',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Xảy ra lỗi!',
            ));
        }
        exit;
    }

}
