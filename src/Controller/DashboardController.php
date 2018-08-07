<?php

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class DashboardController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
    public function index(){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Dashboard', 'action' => 'index']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        $this->set('title', 'Bảng điều khiển');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }

    public function tradesClosed(){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Dashboard', 'action' => 'tradesClosed']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        $this->set('title', 'Giao dịch đã đóng');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
    public function myOffers(){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Dashboard', 'action' => 'myOffers']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        $user = $this->Auth->user();
        $offers_table = TableRegistry::get('offers');
        $offersSell = $offers_table->find('all', array(
            'conditions' => array('offer_type' => 'sell', 'user_id' => $user->id)
        ));
        $offersBuy = $offers_table->find('all', array(
            'conditions' => array('offer_type' => 'buy', 'user_id' => $user->id)
        ));
        
        $this->set('offersSell', $offersSell);
        $this->set('offersBuy', $offersBuy);
        $this->set('title', 'Quảng cáo của tôi');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
    public function referral(){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Dashboard', 'action' => 'referral']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        $this->set('title', 'Danh sách giới thiệu');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
}
