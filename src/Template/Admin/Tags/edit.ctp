<?php $this->layout = 'admin'; ?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="button-customer pull-right">
            <ul>
                <li>
                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Tags', 'action' => 'view', $tag->slug]) ?>" target="_blank">
                        <i class="fa fa-eye"></i> <?= __('Xem thẻ') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <li class="trash">
                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'delete', $tag->id]) ?>">
                        <i class="fa fa-trash"></i> <?= __('Xóa') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'index']) ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?= __('Quay lại') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-wrap">
        <?php echo $this->Form->create("Tags", array('url' => '', 'id' => 'category_form_edit')); ?>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label"><?= __('Tên thẻ') ?></label>
                <div class="col-sm-10">
                    <input type="text" value="<?= $tag->name ?>" class="form-control" id="name" name="name" aria-describedby="nameHelp" required />
                    <small id="nameHelp" class="form-text text-muted">The name is how it appears on your site.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                <div class="col-sm-10">
                    <input type="text" value="<?= $tag->slug ?>" class="form-control" id="slug" name="slug" aria-describedby="slugHelp"/>
                    <small id="slugHelp" class="form-text text-muted">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label"><?= __('Mô tả') ?></label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="5" aria-describedby="descriptionHelp"><?= $tag->description ?></textarea>
                    <small id="descriptionHelp" class="form-text text-muted">The description is not prominent by default; however, some themes may show it.</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="featured_image" class="col-sm-2 col-form-label"><?= __('Hình ảnh') ?></label>
                <div class="col-sm-10">
                    <input type="text" name="image" id="featured_image" value="<?= $tag->image ?>" class="form-control mb10" placeholder="Enter URL or click choose image" />
                    <div class="featured_image">
                        <div class="placeholder">IMAGE</div>
                    </div>
                    <div>
                        <a href="javascript://" id="addFeaturedImage"><?= __('Chọn ảnh đại diện') ?></a>
                        <a href="javascript://" id="removeFeaturedImage" style="display: none"><?= __('Xóa ảnh đại diện') ?></a>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?= __('Lưu thay đổi') ?></button>
                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'index']) ?>" class="btn btn-default">
                        <i class="fa fa-ban" aria-hidden="true"></i> <?= __('Hủy') ?>
                    </a>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>