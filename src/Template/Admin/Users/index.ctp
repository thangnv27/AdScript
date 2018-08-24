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
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width:60px">ID</th>
                    <th><?= __('Tài khoản') ?></th>
                    <th><?= __('Email') ?></th>
                    <th><?= __('Quyền') ?></th>
                    <th style="width:94px"><?= __('Tùy chọn') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr class="background-tr">
                    <td><?= $user->id ?></td>
                    <td><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id]) ?>"><?= $user->username ?></a></td>
                    <td><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></td>
                    <td><?= CommonsComponent::getRole($user->role) ?></td>
                    <td>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'send_email_confirm', $user->id]) ?>" 
                           onclick="return confirm('<?= __('Bạn có chắc chắn muốn gửi không?') ?>')" class="btn btn-success btn-xs" title="<?= __('Gửi email xác minh') ?>">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id]) ?>" class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'delete', $user->id]) ?>" 
                           onclick="return confirm('<?= __('Bạn có chắc chắn muốn xóa không?') ?>')" class="btn btn-danger btn-xs" title="<?= __('Xóa') ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <ul class="pagination">
        <?php
        echo $this->Paginator->first('←');
        echo $this->Paginator->prev('«');
        echo $this->Paginator->numbers();
        echo $this->Paginator->next('»');
        echo $this->Paginator->last('→');
        ?>
    </ul>
</div>