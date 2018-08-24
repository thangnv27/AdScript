<?php $this->layout = 'admin'; ?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="button-customer pull-right">
            <ul>
                <li>
                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'PostCategories', 'action' => 'view', $category->slug]) ?>" target="_blank">
                        <i class="fa fa-eye"></i> <?= __('Xem danh mục') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'index']) ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?= __('Quay lại') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-wrap">
        <?php echo $this->Form->create("PostCategories", array('url' => '')); ?>
        <p><strong><?= __('Bạn muốn chuyển toàn bộ bài viết tới danh mục nào?') ?></strong></p>
        <div class="form-group row">
            <div class="col-sm-3">
                <select class="form-control" name="cat" aria-describedby="parentHelp">
                    <?php foreach ($catOptions as $id => $name) : ?>
                        <option value="<?= $id ?>"><?php
                        if($category->id == $id):
                            echo $name . __(' (Hiện tại)');
                        else:
                            echo $name;
                        endif;
                        ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-success"><i class="fa fa-trash" aria-hidden="true"></i> <?= __('Xóa') ?></button>
                <a href="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'index']) ?>" class="btn btn-default">
                    <i class="fa fa-ban" aria-hidden="true"></i> <?= __('Hủy') ?>
                </a>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>