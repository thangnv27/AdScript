<?php $this->layout = 'admin'; ?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="button-customer pull-right">
            <ul>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'trashed']) ?>">
                        <i class="fa fa-trash"></i> <?= __('Thùng rác') ?>
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
                    <th><?= __('Tiêu đề') ?></th>
                    <th style="width:152px"><?= __('Ngày đăng') ?></th>
                    <th style="width:122px;"><?= __('Tùy chọn') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page) : ?>
                <tr class="background-tr">
                    <td><?= $page->id ?></td>
                    <td align="left">
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'edit', $page->id]) ?>"><?= $page->title ?></a>
                        <?php
                        if($page->status == 'draft'){
                            echo "<strong> &HorizontalLine; " . __('Bản nháp') . "</strong>";
                        }
                        ?>
                    </td>
                    <td align="left"><?= date('d/m/Y H:i:s', strtotime($page->created_date)) ?></td>
                    <td>
                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Pages', 'action' => 'view', $page->slug]) ?>" 
                           class="btn btn-primary btn-xs" title="<?= __('Xem trang') ?>" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'edit', $page->id]) ?>" class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'duplicate', $page->id]) ?>" class="btn btn-primary btn-xs" title="<?= __('Nhân bản') ?>">
                            <i class="fa fa-clone"></i>
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'trash', $page->id]) ?>" 
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