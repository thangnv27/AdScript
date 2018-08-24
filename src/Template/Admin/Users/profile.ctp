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
        <div class="button-customer pull-right"></div>
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
            'required' => true,
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
            'required' => true,
            'class' => 'form-control',
            'label' => array(
                'text' => __('Số điện thoại'),
                'class' => 'col-sm-3'
            ),
            'value' => $usermeta->phone
        ));
        ?>
        <div class="form-group row">
            <label for="passport" class="col-sm-3"><?= __('Số CMND') ?></label>
            <div class="col-sm-6">
                <input type="text" name="passport" id="passport" value="<?=$usermeta->passport?>" class="form-control" aria-describedby="passportHelp" required />
            </div>
            <div class="col-sm-3">
                <small id="passportHelp" class="form-text text-muted mt10" style="display: block">
                    <?php
                    if($usermeta->passport_confirmed == 1){
                        echo __('Đã xác minh CMND');
                    } else {
                        echo __('Chưa xác minh CMND');
                    }
                    ?>
                </small>
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
            <label class="col-sm-3"><?= __('Quyền hạn') ?></label>
            <div class="col-sm-6">
                <?php echo CommonsComponent::getRole($user->role); ?>
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
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>