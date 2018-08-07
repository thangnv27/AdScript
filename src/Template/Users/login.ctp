<?php $this->layout = 'app'; ?>
<form id="login_form" method="post" action="<?=$this->Url->build(['controller' => 'Users', 'action' => 'login'])?>">
    <div id="login_result" style="margin-bottom: 5px;color: red;"></div>
    <div class="form-group">
        <label for="username"><?php echo __('Tên đăng nhập'); ?></label>
        <input type="text" class="form-control input-lg" value="" name="username" id="username" required />
    </div>
    <div class="form-group">
        <label for="password"><?php echo __('Mật khẩu'); ?></label>
        <input type="password" class="form-control input-lg" value="" name="password" id="password" required />
    </div>
    <div class="submit_section">
        <button type="submit" id="btnLogin" class="btn btn-lg btn-success btn-block"><?php echo __('Đăng nhập'); ?></button>
        <input type="hidden" name="redirect_url" value="<?php echo $_REQUEST['redirect'];  ?>" />
    </div>
</form>