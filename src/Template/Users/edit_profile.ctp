<?php $this->layout = 'default'; ?>

<div class="main-content">
    <div class="container">
        <div class="row mt30">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="panel panel-info user-profile">
                    <div class="panel-heading">
                        <h1 class="title"><?=$title?></h1>
                    </div>
                    <form class="form" action="" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered mb0">
                            <tbody>
                                <tr>
                                    <td width="40%">Họ và tên</td>
                                    <td>
                                        <input type="text" name="name" value="<?=$user->user_metum->fullname?>" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ</td>
                                    <td>
                                        <input type="text" name="address" value="<?=$user->user_metum->address?>" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số giao dịch</td>
                                    <td>
                                        <?php echo count($user->trades) ?>
                                    </td>
                                </tr>
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
                                        <button type="button" class="btn-save btn btn-primary">Lưu thay đổi</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>