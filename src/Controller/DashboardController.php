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
        // SEO
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Dashboard', 'action' => 'index']);
        $og_image = SITE_URL . '/img/frontend/logo.png';
        
        // Data
        $user = $this->Auth->user();
        $ads_table = TableRegistry::get('ads');
        $query = $ads_table->find('all', array(
            'conditions' => array(
                'ads.user_id' => $user->id,
            )
        ));
        $ads = $this->paginate($query, [
            'limit' => 50,
            'order' => [
                'Ads.status' => 'desc'
            ]
        ]);
        
        $this->set('ads', $ads);
        $this->set('title', 'Bảng điều khiển');
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }

}
