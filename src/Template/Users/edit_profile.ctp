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
                    <form class="form" id="frmEditProfile" action="" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered mb0">
                            <tbody>
                                <tr>
                                    <td width="40%">Full Name</td>
                                    <td>
                                        <input type="text" name="fullname" value="<?=$user->user_metum->fullname?>" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>
                                        <input type="text" name="address" value="<?=$user->user_metum->address?>" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td>
                                        <input type="text" name="phone" value="<?=$user->user_metum->phone?>" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Passport</td>
                                    <td>
                                        <input type="text" name="passport" value="<?=$user->user_metum->passport?>" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>
                                        <label for="status_male" class="normal mr15">
                                            <input type="radio" id="status_male" name="sex" value="male" <?php echo ($user->user_metum->sex=='male')?"checked":"" ?> /> Male
                                        </label>
                                        <label for="status_female" class="normal">
                                            <input type="radio" id="status_female" name="sex" value="female" <?php echo ($user->user_metum->sex=='female')?"checked":"" ?> /> Female
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Join date</td>
                                    <td><?php echo date('d/m/Y', strtotime($user->user_metum->created_date)); ?></td>
                                </tr>
                                <tr>
                                    <td>Last login</td>
                                    <td><?php
                                    if(empty($user->log_login)){
                                        echo __('Not logged in yet');
                                    } else {
                                        echo date('d/m/Y H:i:s', strtotime($user->log_login[0]->login_date));
                                    }
                                    ?></td>
                                </tr>
<!--                                <tr>
                                    <td>Xác minh CMND</td>
                                    <td>
                                        <?php
                                        if($user->user_metum->passport_confirmed == 1){
                                            echo __('<span class="label label-success">Verified</span>');
                                        } else {
                                            echo __('<span class="label label-danger">Not verified</span>');
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Xác minh Số điện thoại</td>
                                    <td>
                                        <?php
                                        if($user->user_metum->phone_confirmed == 1){
                                            echo __('<span class="label label-success">Verified</span>');
                                        } else {
                                            echo __('<span class="label label-danger">Not verified</span>');
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Xác minh Email</td>
                                    <td>
                                        <?php
                                        if($user->email_confirmed == 1){
                                            echo __('<span class="label label-success">Verified</span>');
                                        } else {
                                            echo __('<span class="label label-danger">Not verified</span>');
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Facebook</td>
                                    <td><?=__('Not connected')?></td>
                                </tr>-->
                                <tr>
                                    <td class="text-center" colspan="2">
                                        <button type="submit" class="btn-save btn btn-primary">Save changes</button>
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