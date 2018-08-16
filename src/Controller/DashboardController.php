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

}
