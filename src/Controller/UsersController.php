<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class UsersController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'login', 'logout', 'forgotPassword', 'confirmEmail', 'refeshAuthLogedIn']);
    }
    
    /**
     * Đăng ký thành viên
     */
    public function signup(){
        $user = $this->Auth->user();
        if ($user) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $status = "error";
            $msg = "";
            $username = $this->request->data('username');
            $password = $this->request->data('password');
            $confirm_password = $this->request->data('confirm_password');
            $salt = $this->Commons->random_salt(30);
            $hash_password = $this->Commons->hash_password($password, $salt);
            $email = $this->request->data('email');
            $confirm_email = $this->request->data('confirm_email');
            $email_confirm_salt = $this->Commons->random_salt(30);
            $email_confirm_code = $this->Commons->hash_password($email, $email_confirm_salt);
            $user = $this->Users->newEntity();
            $user->username = $username;
            $user->password = $hash_password;
            $user->email = $email;
            $user->role = 'member';
            $user->salt = $salt;
            $user->email_confirm_salt = $email_confirm_salt;
            $user->email_confirm_code = $email_confirm_code;
            
            $username_check = $this->Users->find('all', array(
                'conditions' => array('Users.username' => $username)
            ));
            $email_check = $this->Users->find('all', array(
                'conditions' => array('Users.email' => $email)
            ));
            
            if (empty($username)) {
                $msg .= "<p>" . __("Vui lòng nhập Tên đăng nhập!") . "</p>";
            } else if (!$this->Commons->is_valid_username($username)) {
                $msg .= "<p>" . __("Tên đăng nhập không hợp lệ!") . "</p>";
            } else if ($username_check->count() > 0) {
                $msg .= "<p>" . __('Tên đăng nhập đã được sử dụng. Hãy thử một tên khác khác!') . "</p>";
            }
            if (empty($password)) {
                $msg .= "<p>" . __("Vui lòng nhập Mật khẩu!") . "</p>";
            } else if ($password != $confirm_password) {
                $msg .= "<p>" . __('Xác nhận Mật khẩu không đúng!') . "</p>";
            }
            if (empty($email)) {
                $msg .= "<p>" . __("Vui lòng nhập Email!") . "</p>";
            } else if (!$this->Commons->isValidEmail($email)) {
                $msg .= "<p>" . __("Email không hợp lệ!") . "</p>";
            } else if ($email != $confirm_email) {
                $msg .= "<p>" . __('Xác nhận Email không đúng!') . "</p>";
            } else if ($email_check->count() > 0) {
                $msg .= "<p>" . __('Email đã được sử dụng. Hãy thử một Email khác!') . "</p>";
            }
            if (empty($msg)) {
                $savedUser = $this->Users->save($user);
                if ($savedUser) {
                    // Add User Meta Data
                    $user_meta_table = TableRegistry::get('user_meta');
                    $user_meta_data = $user_meta_table->newEntity();
                    $user_meta_data->user_id = $savedUser->id;
                    $user_meta = $user_meta_table->save($user_meta_data);
                    
                    // Add wallet for user
                    $wallets_table = TableRegistry::get('wallets');
                    $wallet = $wallets_table->newEntity();
                    $wallet->user_id = $savedUser->id;
                    $walletSaved = $wallets_table->save($wallet);
                    
                    if ($user_meta and $walletSaved) {
                        // Send email confirmation
                        $email_confirm_link = SITE_URL . "/users/confirm_email/{$savedUser->id}/{$email_confirm_code}";
                        $mail = new Email('default');
                        $mail_from = $mail->profile('default')->getFrom();
                        $mail->from($mail_from)
                            ->to($email)
                            ->subject('Xác nhận địa chỉ Email')
                            ->viewVars(['name' => $username, 'link' => $email_confirm_link])
                            ->template('user_email_confirm', 'default')
                            ->emailFormat('html')
                            ->send();
                        
                        // Response message
                        $msg .= "<p>" . __('<strong>Đăng ký thành công!</strong> Vui lòng kiểm tra hòm thư và kích hoạt tài khoản.<br/>Lưu ý: Kiểm tra cả các mục Spam/Junk/Quảng cáo...') . "</p>";
                        $status = "success";
                    } else {
                        $this->Users->delete($savedUser);
                        $msg .= "<p>" . __('Xảy ra lỗi!') . "</p>";
                    }
                } else {
                    $msg .= "<p>" . __('Xảy ra lỗi!') . "</p>";
                }
            }

            echo json_encode(array(
                'status' => $status,
                'message' => $msg,
            ));
            exit;
        }
        
        $this->set('title', 'Đăng ký thành viên');
    }

    /**
     * Đăng nhập vào hệ thống của thành viên
     */
    public function login() {
        $user = $this->Auth->user();
        if ($user) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $username = $this->request->data('username');
            $password = $this->request->data('password');
            $status = "error";
            $msg = "";
            $redirect_url = $this->request->data('redirect_url');
            if (empty($redirect_url)) {
                $redirect_url = $this->Auth->redirectUrl();
            }

            if (empty($username)) {
                $msg .= "<p>" . __("Vui lòng nhập Tên đăng nhập!") . "</p>";
            } else if (!$this->Commons->is_valid_username($username)) {
                $msg .= "<p>" . __("Tên đăng nhập không hợp lệ!") . "</p>";
            }
            if (empty($password)) {
                $msg .= "<p>" . __("Vui lòng nhập Mật khẩu!") . "</p>";
            }
            if (empty($msg)) {
                $username_check = $this->Users->find('all', array(
                    'conditions' => array('Users.username' => $username)
                ));
                if ($username_check->count() == 1) {
                    $user = $username_check->first();
                    $hash_password = $this->Commons->hash_password($password, $user->salt);
                    $user_check = $this->Users->find('all', array(
                        'conditions' => array(
                            'Users.username' => $username,
                            'Users.password' => $hash_password
                        )
                    ))->contain(['Wallets', 'UserMeta']);
                    if ($user_check->count() == 1) {
                        $this->request->data['password'] = $hash_password;
                        $user = $user_check->first();
                        if ($user) {
                            $this->Auth->setUser($user);
                            $status = "success";
                            
                            $log_login_table = TableRegistry::get('log_login');
                            $log_login = $log_login_table->newEntity();
                            $log_login->user_id = $user->id;
                            $log_login->ip_address = $_SERVER['REMOTE_ADDR'];
                            $log_login->user_agent = $_SERVER['HTTP_USER_AGENT'];
                            $log_login->login_date = date('Y-m-d H:i:s');
                            $log_login_table->save($log_login);
                        } else {
                            $msg .= "<p>" . __("Sai tài khoản hoặc mật khẩu!") . "</p>";
                        }
                    } else {
                        $msg .= "<p>" . __("Sai tài khoản hoặc mật khẩu!") . "</p>";
                    }
                } else {
                    $msg .= "<p>" . __("Sai tài khoản hoặc mật khẩu!") . "</p>";
                }
            }
            echo json_encode(array(
                'status' => $status,
                'message' => $msg,
                'redirect_url' => $redirect_url
            ));
            exit;
        }
        
        $this->set('title', 'Đăng nhập');
    }
    
    /**
     * Làm mới trạng thái đăng nhập của thành viên
     */
    public function refeshAuthLogedIn(){
        $user = $this->Auth->user();
        if($user){
            $user = $this->Users->find('all', array(
                'conditions' => array(
                    'Users.id' => $user->id,
                )
            ))->contain(['Wallets', 'UserMeta'])->first();
            $this->Auth->setUser($user);

            echo json_encode(array(
                'status' => 'success',
                'msg' => 'User loged in',
                'wallets' => array(
                    'vnd' => $user->wallet->vnd,
                    'usd' => $user->wallet->usd,
                )
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'msg' => 'User not loged in',
            ));
        }
        exit;
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    /**
     * Quên mật khẩu
     */
    public function forgotPassword() {
        if ($this->request->is('post')) {
            $status = "error";
            $msg = "Updating!";

            echo json_encode(array(
                'status' => $status,
                'message' => $msg
            ));
            exit;
        } else {
            return $this->redirect(['action' => 'login']);
        }
    }

    /**
     * Xác minh địa chỉ Email
     * 
     * @param int $id User ID
     * @return action
     */
    public function confirmEmail($id = 0, $code = "") {
        $message = "Xác nhận Email KHÔNG thành công!";
        $user = $this->Users->get($id);
        if ($user) {
            if($user->email_confirm_code != $code){
                $message = "Mã xác nhận không đúng hoặc đã hết hạn!";
            } else {
                $user->email_confirmed = 1;
                if($this->Users->save($user)){
                    $this->Auth->setUser($user);
                    $message = "Xác nhận Email thành công!";
                } else {
                    $message = "Xác nhận Email KHÔNG thành công!";
                }
            }
        }
        $this->set('message', $message);
        $this->set('title', __('Xác nhận địa chỉ Email'));
    }
    
    /**
     * Xem hồ sơ thành viên
     * 
     * @param string $username Name of user login
     */
    public function profile($username){
        $user = $this->Users->findByUsername($username)
                ->contain([
                    'Wallets', 'UserMeta', 
                    'Ads' => ['fields' => ['Ads.id', 'Ads.user_id']],
                    'LogLogin' => function($q) {
                            return $q->order('LogLogin.login_date DESC')->limit(1);
                        }
                ])->first();
        
        // SEO
        $title = __('Hồ sơ của {0}', [$username]);
        $meta_description = __('');
        $og_type = "article";
        $og_image = SITE_URL . '/img/frontend/logo.png';
        $og_url = SITE_URL . Router::url(['controller' => 'Users', 'action' => 'profile', $username]);

        $this->set('user', $user);
        $this->set('title', $title);
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }

    /**
     * Sửa hồ sơ thành viên
     */
    public function editProfile(){
        $user = $this->Auth->user();
        if($user){
            $user = $this->Users->findById($user->id)
                ->contain([
                    'Wallets', 'UserMeta', 
                    'Ads' => ['fields' => ['Ads.id', 'Ads.user_id']],
                    'LogLogin' => function($q) {
                            return $q->order('LogLogin.login_date DESC')->limit(1);
                        }
                ])->first();
        }
        
        if($this->request->is('post')){
            $
            
            $user_meta_table = TableRegistry::get('user_meta');
            $user_meta = $user_meta_table->get($user->id);
            $user_meta->fullname = $this->request->data('fullname');
            $user_meta->address = $this->request->data('address');
            $user_meta->phone = $this->request->data('phone');
            $user_meta->sex = $this->request->data('sex');
            $user_meta->passport = $this->request->data('passport');
            $user_meta->updated_date = date('Y-m-d H:i:s');
            $savedUserMeta = $user_meta_table->save($user_meta);
            if ($savedUserMeta) {
                echo json_encode(array(
                    'status' => 'success',
                    'message' => __('Updated successfully!'),
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => __('Update profile failed!'),
                ));
            }
            exit;
        }
        
        // SEO
        $title = __('Edit your profile');
        $meta_description = __('');
        $og_type = "article";
        $og_image = SITE_URL . '/img/frontend/logo.png';
        $og_url = SITE_URL . Router::url(['controller' => 'Users', 'action' => 'editProfile']);

        $this->set('user', $user);
        $this->set('title', $title);
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
    /**
     * Sửa hồ sơ thành viên
     */
    public function changePassword(){
        $user = $this->Auth->user();
        if($user){
            $user = $this->Users->findById($user->id)
                ->contain([
                    'Wallets', 'UserMeta', 
                    'Ads' => ['fields' => ['Ads.id', 'Ads.user_id']],
                    'LogLogin' => function($q) {
                            return $q->order('LogLogin.login_date DESC')->limit(1);
                        }
                ])->first();
        }
        
        if($this->request->is('post')){
            $old_pwd = $this->request->data('old_pwd');
            $new_pwd = $this->request->data('new_pwd');
            $new_pwd2 = $this->request->data('new_pwd2');
            $status = "error";
            $msg = "";

            if (empty($old_pwd)) {
                $msg .= "<p>" . __("Old password is required!") . "</p>";
            } else if (empty($new_pwd)) {
                $msg .= "<p>" . __("New password is required!") . "</p>";
            } else if($old_pwd == $new_pwd){
                $msg .= "<p>" . __("New passwords and Old passwords must be different!") . "</p>";
            } else if (empty($new_pwd2)) {
                $msg .= "<p>" . __("Retype New password is required!") . "</p>";
            } else if ($new_pwd != $new_pwd2) {
                $msg .= "<p>" . __("Retype Password was wrong!") . "</p>";
            }
            if (empty($msg)) {
                $hash_password = $this->Commons->hash_password($old_pwd, $user->salt);
                $user_check = $this->Users->find('all', array(
                    'conditions' => array(
                        'Users.username' => $user->username,
                        'Users.password' => $hash_password
                    )
                ));
                if ($user_check->count() == 1) {
                    $new_password = $this->Commons->hash_password($new_pwd, $user->salt);
                    $user = $user_check->first();
                    $user->password = $new_password;
                    $savedUserMeta = $this->Users->save($user);
                    if ($savedUserMeta) {
                        $status = "success";
                        $msg .= "<p>" . __("Password changed successfully!") . "</p>";
                    } else {
                        $msg .= "<p>" . __("Change password failed!") . "</p>";
                    }
                } else {
                    $msg .= "<p>" . __("Old Password was wrong!") . "</p>";
                }
            }
            echo json_encode(array(
                'status' => $status,
                'message' => $msg,
            ));
            exit;
        }
        
        // SEO
        $title = __('Change Password');
        $meta_description = __('');
        $og_type = "article";
        $og_image = SITE_URL . '/img/frontend/logo.png';
        $og_url = SITE_URL . Router::url(['controller' => 'Users', 'action' => 'changePassword']);

        $this->set('user', $user);
        $this->set('title', $title);
        $this->set('meta_description', $meta_description);
        $this->set('og_type', $og_type);
        $this->set('og_url', $og_url);
        $this->set('og_image', $og_image);
        $this->set('canonical', $og_url);
    }
    
}
