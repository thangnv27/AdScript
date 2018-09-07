<?php

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

class BannersController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['display']);
    }
    
    /**
     * Xem trước mẫu quảng cáo
     */
    public function preview($id = 0){
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Ads', 'action' => 'createSell']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        $entity = TableRegistry::get('ads')->get($id);
        
        $this->set('ad', $entity);
        $this->set('title', 'Edit Ad banner');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
        $this->layout = false;
    }
    
    /**
     * Hiển thị quảng cáo
     */
    public function display($id = 0){
        $entity = Cache::read('ad_' . $id);

        if ($entity == false) {
            $ads_table = TableRegistry::get('ads');
            $entity = $ads_table->get($id);
            Cache::write('ad_' . $id, $entity);
        }

        $this->set('ad', $entity);
        $this->layout = false;
    }

}
