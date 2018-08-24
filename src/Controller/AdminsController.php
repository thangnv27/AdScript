<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

class AdminsController extends AppController {

    public function initialize() {
        parent::initialize();

//        $this->loadComponent('Auth', [
//            'loginAction' => ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login'],
//            'loginRedirect' => ['prefix' => false, 'controller' => 'Admins', 'action' => 'display', 'index'],
//            'logoutRedirect' => ['prefix' => false, 'controller' => 'Pages', 'action' => 'display', 'home']
//        ]);
        
        $user = $this->Auth->user();
        if (!$user or !parent::isAuthorized($user)){
            $this->redirect(SITE_URL);
        }
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
//    function isAuthenticated() {
//        $user = $this->Auth->user();
//        if ($user)
//            return true;
//        return false;
//    }
//
//    public function isAuthorized($user) {
//        // Admin can access every action
//        if (isset($user['role']) && in_array($user['role'], array('admin', 'editor', 'author'))) {
//            return true;
//        }
//
//        // Default deny
//        return false;
//    }

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
        $this->set(compact('page', 'subpage'));
        $this->set('title', 'Admin Panel');

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
