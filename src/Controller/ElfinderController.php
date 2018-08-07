<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

class ElfinderController extends AdminsController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        
    }

}
