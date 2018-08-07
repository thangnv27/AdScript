<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller\Component\CommonsComponent;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admin/Users/edit.ctp with your own version.');
endif;
?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="button-customer pull-right">
            <ul>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?= __('Quay lại') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="form-wrap">
        <?php
        echo $this->Form->create("Users", array(
            'url' => ''
        ));
        $this->Form->templates([
            'input' => '<div class="col-sm-6"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
            'inputContainer' => '<div class="form-group row input {{type}}{{required}}">{{content}}</div>',
        ]);
        echo $this->Form->input('fullname', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Họ và tên'),
                'class' => 'col-sm-3'
            ),
            'placeholder' => __('Nguyễn Văn A'),
            'value' => $usermeta->fullname
        ));
        echo $this->Form->input('username', array(
            'disabled' => true, 
            'class' => 'form-control',
            'label' => array(
                'text' => __('Tên đăng nhập'),
                'class' => 'col-sm-3'
            ),
            'value' => $user->username
        ));
        echo $this->Form->input('password', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Mật khẩu'),
                'class' => 'col-sm-3'
            ),
        ));
        echo $this->Form->input('confirm_password', array(
            'type' => 'password',
            'class' => 'form-control',
            'label' => array(
                'text' => __('Gõ lại Mật khẩu'),
                'class' => 'col-sm-3'
            ),
        ));
        ?>
        <div class="form-group row">
            <label for="email" class="col-sm-3"><?= __('Địa chỉ Email') ?></label>
            <div class="col-sm-6">
                <input type="email" name="email" id="email" value="<?=$user->email?>" class="form-control" placeholder="example@domain.com" aria-describedby="emailHelp" required />
            </div>
            <div class="col-sm-3">
                <small id="emailHelp" class="form-text text-muted mt10" style="display: block">
                    <?php
                    if($user->email_confirmed == 1){
                        echo __('Đã xác minh Email');
                    } else {
                        echo __('Chưa xác minh Email');
                    }
                    ?>
                </small>
            </div>
        </div>
        <?php
        echo $this->Form->input('address', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Địa chỉ nơi ở'),
                'class' => 'col-sm-3'
            ),
            'placeholder' => __('Số nhà, Tên đường/Láng/Xóm, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố'),
            'value' => $usermeta->address
        ));
        echo $this->Form->input('phone', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Số điện thoại'),
                'class' => 'col-sm-3'
            ),
            'value' => $usermeta->phone
        ));
        echo $this->Form->input('passport', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Số CMND'),
                'class' => 'col-sm-3'
            ),
            'value' => $usermeta->passport
        ));
        ?>
        <div class="form-group row">
            <label for="passport_confirmed" class="col-sm-3"><?= __('Xác minh CMND') ?></label>
            <div class="col-sm-6">
                <?php
                echo $this->Form->select('passport_confirmed', array('0' => __('Chưa xác minh'), '1' => __('Đã xác minh')), array(
                    'id' => 'passport_confirmed',
                    'default' => '0',
                    'class' => 'form-control',
                    'value' => $usermeta->passport_confirmed
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="sex" class="col-sm-3"><?= __('Giới tính') ?></label>
            <div class="col-sm-6">
                <?php
                echo $this->Form->select('sex', CommonsComponent::genderList(), array(
                    'id' => 'sex',
                    'default' => 'male',
                    'class' => 'form-control',
                    'value' => $usermeta->sex
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="role" class="col-sm-3"><?= __('Quyền hạn') ?></label>
            <div class="col-sm-6">
                <?php
                echo $this->Form->select('role', CommonsComponent::getRoleList(), array(
                    'required' => true,
                    'id' => 'role',
                    'default' => 'member',
                    'class' => 'form-control',
                    'value' => $user->role
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3"><?= __('Ngày tạo') ?></label>
            <div class="col-sm-6">
                <?php echo date('d/m/Y H:i:s', strtotime($usermeta->created_date)); ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3"><?= __('Chỉnh sửa') ?></label>
            <div class="col-sm-6">
                <?php echo date('d/m/Y H:i:s', strtotime($usermeta->updated_date)); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                echo $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . __('Lưu thay đổi'), array(
                    'class' => 'btn btn-success',
                    'type' => 'submit'
                ));
                ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="btn btn-default">
                    <i class="fa fa-ban" aria-hidden="true"></i> <?= __('Hủy') ?>
                </a>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>