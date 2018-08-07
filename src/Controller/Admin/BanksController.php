<?php

namespace App\Controller\Admin;

use App\Controller\AdminsController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

class BanksController extends AdminsController {

    public $paginate = [
        'fields' => ['Banks.id', 'Banks.name', 'Banks.branch', 'Banks.account_number', 'Banks.account_name', 'Banks.is_active'],
        'limit' => 30,
        'order' => [
            'Banks.id' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $this->set('banks', $this->paginate('Banks'));
        $this->set('title', __('Tài khoản ngân hàng'));
    }

    public function find() {
        $q = $this->request->query('q');
        $query = $this->Banks->find('all', [
            'fields' => ['name'],
            'limit' => 30,
            'conditions' => ['name LIKE' => "%$q%"]
        ]);
        echo json_encode(array(
            'items' => $query,
            'total_count' => $query->count(),
        ), JSON_PRETTY_PRINT);
        exit;
    }

    public function add() {
        if ($this->request->is('post')) {
            $bank = $this->Banks->newEntity();
            $name = $this->request->data('name');
            $branch = $this->request->data('branch');
            $account_number = $this->request->data('account_number');
            $account_name = $this->request->data('account_name');

            $acc_check = $this->Banks->find('all', array(
                'conditions' => array('Banks.account_number' => $account_number)
            ));

            if (empty($name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên ngân hàng!'));
            } else if (empty($branch)) {
                $this->Flash->warning(__('Vui lòng nhập Chi nhánh ngân hàng!'));
            } else if (empty($account_number)) {
                $this->Flash->warning(__('Vui lòng nhập Số tài khoản!'));
            } else if ($acc_check->count() > 0) {
                $this->Flash->warning(__('Số tài khoản đã tồn tại!'));
            } else if (empty($account_name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên tài khoản!'));
            } else {
                $bank->name = $name;
                $bank->branch = $branch;
                $bank->account_number = $account_number;
                $bank->account_name = $account_name;
                $savedBank = $this->Banks->save($bank);
                if ($savedBank) {
                    $this->Flash->success(__('Thêm mới thành công!'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        $this->Flash->error(__('Thêm mới không thành công!'));
    }

    public function edit($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $bank = $this->Banks->get($id);
        if (!$bank) {
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['post', 'put'])) {
            $name = $this->request->data('name');
            $branch = $this->request->data('branch');
            $account_number = $this->request->data('account_number');
            $account_name = $this->request->data('account_name');

            $acc_check = $this->Banks->find('all', array(
                'conditions' => array('Banks.account_number' => $account_number)
            ));

            if (empty($name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên ngân hàng!'));
            } else if (empty($branch)) {
                $this->Flash->warning(__('Vui lòng nhập Chi nhánh ngân hàng!'));
            } else if (empty($account_number)) {
                $this->Flash->warning(__('Vui lòng nhập Số tài khoản!'));
            } else if ($bank->account_number != $account_number and $acc_check->count() > 0) {
                $this->Flash->warning(__('Số tài khoản đã tồn tại!'));
            } else if (empty($account_name)) {
                $this->Flash->warning(__('Vui lòng nhập Tên tài khoản!'));
            } else {
                $bank->name = $name;
                $bank->branch = $branch;
                $bank->account_number = $account_number;
                $bank->account_name = $account_name;
                $bank->updated_date = date('Y-m-d H:i:s');

                if ($this->Banks->save($bank)) {
                    $this->Flash->success(__('Cập nhật thành công!'));
                    return $this->redirect(['action' => 'edit', $id]);
                }

                $this->Flash->error(__('Cập nhật không thành công!'));
            }
        }
        $this->set('bank', $bank);
        $this->set('title', __('Tài khoản ngân hàng'));
    }

    public function setActive($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $bank = $this->Banks->get($id);
        if ($bank) {
            $bank->is_active = 1;
            if ($this->Banks->save($bank)) {
                $this->Banks->query()->update()
                    ->set(['is_active' => 0])
                    ->where(['is_active' => 1, 'id !=' => $id])
                    ->execute();
                $this->Flash->success(__('Đã kích hoạt thành công!'));
            } else {
                $this->Flash->error(__('Kích hoạt không thành công!'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function delete($id) {
        if ($id < 0) {
            return $this->redirect(['action' => 'index']);
        }
        $bank = $this->Banks->get($id);
        if ($bank) {
            $this->Banks->deleteBank($bank);
            $this->Flash->success(__('Đã xóa thẻ!'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
