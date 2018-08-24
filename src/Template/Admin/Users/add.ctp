<?php

use Cake\Cache\Cache;
use App\Controller\Component\CommonsComponent;

$this->layout = 'admin';
?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="button-customer pull-right">
            <ul>
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
            'placeholder' => __('Nguyễn Văn A')
        ));
        echo $this->Form->input('username', array(
            'required' => true, 
            'class' => 'form-control',
            'label' => array(
                'text' => __('Tên đăng nhập'),
                'class' => 'col-sm-3'
            ),
        ));
        echo $this->Form->input('password', array(
            'required' => true, 
            'class' => 'form-control',
            'label' => array(
                'text' => __('Mật khẩu'),
                'class' => 'col-sm-3'
            ),
        ));
        echo $this->Form->input('confirm_password', array(
            'type' => 'password',
            'required' => true, 
            'class' => 'form-control',
            'label' => array(
                'text' => __('Gõ lại Mật khẩu'),
                'class' => 'col-sm-3'
            ),
        ));
        echo $this->Form->input('email', array(
            'required' => true, 
            'class' => 'form-control',
            'label' => array(
                'text' => __('Địa chỉ Email'),
                'class' => 'col-sm-3'
            ),
            'placeholder' => 'example@domain.com'
        ));
        echo $this->Form->input('confirm_email', array(
            'type' => 'email',
            'required' => true, 
            'class' => 'form-control',
            'label' => array(
                'text' => __('Gõ lại Địa chỉ Email'),
                'class' => 'col-sm-3'
            )
        ));
        echo $this->Form->input('address', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Địa chỉ nơi ở'),
                'class' => 'col-sm-3'
            ),
            'placeholder' => __('Số nhà, Tên đường/Láng/Xóm, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố')
        ));
        echo $this->Form->input('phone', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Số điện thoại'),
                'class' => 'col-sm-3'
            ),
        ));
        echo $this->Form->input('passport', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Số CMND'),
                'class' => 'col-sm-3'
            ),
        ));
        ?>
        <div class="form-group row">
            <label for="sex" class="col-sm-3"><?= __('Giới tính') ?></label>
            <div class="col-sm-6">
                <?php
                echo $this->Form->select('sex', CommonsComponent::genderList(), array(
                    'id' => 'sex',
                    'default' => 'male',
                    'class' => 'form-control',
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
                ));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                echo $this->Form->button('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Thêm mới'), array(
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