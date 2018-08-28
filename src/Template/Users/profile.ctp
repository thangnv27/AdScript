<?php $this->layout = 'default'; ?>

<div class="main-content">
    <div class="container">
        <div class="row mt30">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="panel panel-info user-profile">
                    <div class="panel-heading">
                        <h1 class="title"><?=$title?></h1>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Ngày đăng ký</td>
                                <td><?php echo date('d/m/Y', strtotime($user->user_metum->created_date)); ?></td>
                            </tr>
                            <tr>
                                <td>Lần truy cập cuối</td>
                                <td><?php
                                if(empty($user->log_login)){
                                    echo __('Chưa đăng nhập lần nào');
                                } else {
                                    echo date('d/m/Y H:i:s', strtotime($user->log_login[0]->login_date));
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td>Xác minh CMND</td>
                                <td>
                                    <?php
                                    if($user->user_metum->passport_confirmed == 1){
                                        echo __('<span class="label label-success">Đã xác minh</span>');
                                    } else {
                                        echo __('<span class="label label-danger">Chưa xác minh</span>');
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Xác minh Số điện thoại</td>
                                <td>
                                    <?php
                                    if($user->user_metum->phone_confirmed == 1){
                                        echo __('<span class="label label-success">Đã xác minh</span>');
                                    } else {
                                        echo __('<span class="label label-danger">Chưa xác minh</span>');
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Xác minh Email</td>
                                <td>
                                    <?php
                                    if($user->email_confirmed == 1){
                                        echo __('<span class="label label-success">Đã xác minh</span>');
                                    } else {
                                        echo __('<span class="label label-danger">Chưa xác minh</span>');
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Facebook</td>
                                <td><?=__('Chưa kết nối')?></td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <button type="button" class="btn-block-trader btn btn-danger">Chặn tài khoản này</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>