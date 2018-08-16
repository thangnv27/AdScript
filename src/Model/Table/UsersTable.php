<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Controller\Component\CommonsComponent;

class UsersTable extends Table {

    public function initialize(array $config) {
        $this->primaryKey('id');
        $this->hasOne('Wallets');
        $this->hasOne('UserMeta');
        $this->hasMany('LogLogin');
    }

    public function validationDefault(Validator $validator) {
        return $validator->notEmpty('username', __('Vui lòng nhập Tài khoản!'))
                        ->notEmpty('password', __('Vui lòng nhập Mật khẩu!'))
                        ->notEmpty('email', __('Vui lòng chọn nhập Email!'))
                        ->notEmpty('role', __('Vui lòng chọn Quyền cho tài khoản!'))
                        ->add('role', 'inList', [
                            'rule' => ['inList', CommonsComponent::getRoleKeys()],
                            'message' => __('Vui lòng chọn Quyền hợp lệ!')
        ]);
    }

}
