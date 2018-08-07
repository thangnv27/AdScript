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
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'trashed']) ?>">
                        <i class="fa fa-trash"></i> <?= __('Thùng rác') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row wrap-filter">
        <div class="col-md-1 action">
            <button type="button" class="btn btn-success" id="btnDelete">
                <i class="fa fa-trash" aria-hidden="true"></i> <?= __('Xóa') ?>
            </button>
        </div>
        <div class="col-md-7 filter">
            <form class="form-inline" action="" method="get">
                <div class="form-group">
                    <span class="input-group date" id="fromDate">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" name="fromDate" value="<?= $this->request->query('fromDate') ?>" placeholder="<?= __('Từ ngày') ?>" class="form-control" />
                    </span>
                    <span class="input-group date" id="toDate">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" name="toDate" value="<?= $this->request->query('toDate') ?>" placeholder="<?= __('Đến ngày') ?>" class="form-control" />
                    </span>
                    <select class="form-control" name="cat">
                        <option value="0"><?= __('Tất cả danh mục') ?></option>
                        <?php foreach ($catOptions as $id => $name) :?>
                        <option value="<?= $id ?>" <?php echo ($this->request->query('cat')==$id)?"selected":"" ?>><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-filter" aria-hidden="true"></i> <?= __('Lọc') ?>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4 fsearch">
            <form class="form-inline" action="" method="get">
                <div class="form-group pull-right">
                    <div class="input-group">
                        <input type="text" name="s" id="textSearch" class="form-control" placeholder="<?= __('Gõ từ khóa...') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i> <?= __('Tìm') ?>
                            </button>
                        </span>
                    </div><!-- /input-group -->
                </div>
            </form>
        </div>
    </div>
    <form id="frmTable" action="" method="get">
        <input type="hidden" name="_action" value="bulk_trash" />
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 34px"><input type="checkbox" id="btnCheckAll"/></th>
                        <th style="width:60px">ID</th>
                        <th style="width:80px"><?= __('Ảnh') ?></th>
                        <th><?= __('Tiêu đề') ?></th>
                        <th style="width:152px"><?= __('Ngày đăng') ?></th>
                        <th style="width:122px;"><?= __('Tùy chọn') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) : ?>
                    <tr class="background-tr">
                        <th class="checkbox-center"><input type="checkbox" class="chk" name="ids[]" value="<?= $post->id ?>" /></th>
                        <td><?= $post->id ?></td>
                        <td><img class="size-img-thumbnail" src="<?= $post->image ?>"/></td>
                        <td class="left">
                            <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'edit', $post->id]) ?>"><?= $post->title ?></a>
                            <?php
                            if($post->status == 'draft'){
                                echo "<strong> &HorizontalLine; " . __('Bản nháp') . "</strong>";
                            }
                            ?>
                        </td>
                        <td class="left"><?= date('d/m/Y H:i:s', strtotime($post->created_date)) ?></td>
                        <td>
                            <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Posts', 'action' => 'view', $post->slug]) ?>" 
                               class="btn btn-primary btn-xs" title="<?= __('Xem bài viết') ?>" target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'edit', $post->id]) ?>" class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'duplicate', $post->id]) ?>" class="btn btn-primary btn-xs" title="<?= __('Nhân bản') ?>">
                                <i class="fa fa-clone"></i>
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'trash', $post->id]) ?>" 
                               onclick="return confirm('<?= __('Bạn có chắc chắn muốn xóa không?') ?>')" class="btn btn-danger btn-xs" title="<?= __('Xóa') ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
    
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