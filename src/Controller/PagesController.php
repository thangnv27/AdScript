<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

class PagesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['display']);
    }
    
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        
        // SEO
        $title = "";
        $meta_description = "";
        $og_type = "article";
        $og_url = SITE_URL . Router::url(['controller' => 'Pages', 'action' => 'display', $page]);
        $og_image = "";
        
        switch ($page) {
            case "home":
                $this->redirect(["controller" => "Dashboard", "action" => "index"]);
                
                // SEO
                $title = __('AdScript');
                $meta_description = __('');
                $og_type = "website";
                $og_image = SITE_URL . '/img/frontend/logo.png';
                
                // Data
                
                break;
            default:
                break;
        }
        
        $this->set('title', $title);
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}
