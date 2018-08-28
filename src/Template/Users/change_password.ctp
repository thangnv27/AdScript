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
                    <form class="form" id="frmChangePassword" action="" method="post">
                        <table class="table table-bordered mb0">
                            <tbody>
                                <tr>
                                    <td width="40%">Old Password</td>
                                    <td>
                                        <input type="password" name="old_pwd" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>New Password</td>
                                    <td>
                                        <input type="password" name="new_pwd" value="" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Retype New Password</td>
                                    <td>
                                        <input type="password" name="new_pwd2" value="" class="form-control" />
                                    </td>
                                </tr>
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