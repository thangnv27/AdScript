<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $helpers = [
        'WyriHaximus/MinifyHtml.MinifyHtml',
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Paginator');
        $this->loadComponent('Commons');

        if( (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin') or
                $this->request->params['controller'] == 'Admins'){
            $this->loadComponent('Auth', [
                'loginAction' => ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login'],
                'loginRedirect' => ['prefix' => false, 'controller' => 'Admins', 'action' => 'display', 'index'],
                'logoutRedirect' => ['prefix' => false, 'controller' => 'Pages', 'action' => 'display', 'home']
            ]);
        } else {
            $this->loadComponent('Auth', [
                'loginAction' => ['prefix' => false, 'controller' => 'Users', 'action' => 'login'],
                'loginRedirect' => ['prefix' => false, 'controller' => 'Dashboard', 'action' => 'index'],
                'logoutRedirect' => ['prefix' => false, 'controller' => 'Pages', 'action' => 'display', 'home']
            ]);
        }

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        
        if ($this->params['controller'] != 'api') {
            $this->_setLanguage();
        }
        
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    function _setLanguage() {
        //if the cookie was previously set, and Config.language has not been set
        //write the Config.language with the value from the Cookie
        //echo $this->Cookie->read('lang');
        $lang = $this->Cookie->read('lang');
        if ($lang != "vi")
            $lang = "vi";
        if (isset($this->Cookie) && $this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
            //$this->Session->write('Config.language', $this->Cookie->read('lang'));
            $this->Session->write('Config.language', $lang);
        }
        //if the user clicked the language URL
        else if (isset($this->params['language']) &&
                ($this->params['language'] != $this->Session->read('Config.language'))
        ) {
            //then update the value in Session and the one in Cookie
            $this->Session->write('Config.language', $this->params['language']);
            $this->Cookie->write('lang', $this->params['language'], false, '20 days');
        }
    }
    
    function isAuthenticated() {
        $user = $this->Auth->user();
        if ($user)
            return true;
        return false;
    }

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && in_array($user['role'], array('admin', 'editor', 'author'))) {
            return true;
        }

        // Default deny
        return false;
    }

}
