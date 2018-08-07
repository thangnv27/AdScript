<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admin/Posts/index.ctp with your own version.');
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
                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <li class="trash">
                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'emptyTrash']) ?>">
                        <i class="fa fa-trash"></i> <?= __('Làm rỗng Thùng rác') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'index']) ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?= __('Quay lại') ?>
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
                    <th style="width:80px"><?= __('Ảnh') ?></th>
                    <th><?= __('Tiêu đề') ?></th>
                    <th style="width:152px"><?= __('Ngày đăng') ?></th>
                    <th style="width:94px;"><?= __('Tùy chọn') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                <tr class="background-tr">
                    <td><?= $post->id ?></td>
                    <td><img class="size-img-thumbnail" src="<?= $post->image ?>"/></td>
                    <td class="left"><a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'edit', $post->id]) ?>"><?= $post->title ?></a></td>
                    <td class="left"><?= date('d/m/Y H:i:s', strtotime($post->created_date)) ?></td>
                    <td>
                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Posts', 'action' => 'view', $post->slug]) ?>" 
                           class="btn btn-primary btn-xs" title="<?= __('Xem bài viết') ?>" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'edit', $post->id]) ?>" class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'delete', $post->id]) ?>" 
                           onclick="return confirm('<?= __('Bài viết này sẽ bị xóa vĩnh viễn!\nBạn có muốn tiếp tục không?') ?>')" class="btn btn-danger btn-xs" title="<?= __('Xóa vĩnh viễn') ?>">
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