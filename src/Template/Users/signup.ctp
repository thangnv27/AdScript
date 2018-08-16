<?php $this->layout = 'app'; ?>
<form id="signup_form" method="post" action="<?=$this->Url->build(['controller' => 'Users', 'action' => 'signup'])?>">
    <div id="signup_result" style="margin-bottom: 5px;color: red;"></div>
    <div class="form-group">
        <label for="signup_username"><?php echo __('Tên đăng nhập'); ?></label>
        <input type="text" class="form-control" value="" name="username" id="signup_username" required />
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="signup_password"><?php echo __('Mật khẩu'); ?></label>
                <input type="password" class="form-control" value="" name="password" id="signup_password" required />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="confirm_password"><?php echo __('Gõ lại Mật khẩu'); ?></label>
                <input type="password" class="form-control" value="" name="confirm_password" id="confirm_password" required />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="email"><?php echo __('Email'); ?></label>
        <input type="email" class="form-control" value="" name="email" id="email" required />
    </div>
    <div class="form-group">
        <label for="confirm_email"><?php echo __('Gõ lại Email'); ?></label>
        <input type="email" class="form-control" value="" name="confirm_email" id="confirm_email" required />
    </div>
    <div class="form-group">
        <label class="normal">
            <input type="checkbox" name="chkAccept" id="chkAccept" />
            <?php echo __('Tôi đã đọc và đồng ý với điều khoản sử dụng tại AdScript'); ?>
        </label>
    </div>
    <div class="submit_section">
        <button type="submit" id="btnSignup" class="btn btn-lg btn-success btn-block"><?php echo __('Đăng ký'); ?></button>
    </div>
</form>