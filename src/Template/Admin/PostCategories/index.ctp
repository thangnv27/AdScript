<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admin/PostCategories/index.ctp with your own version.');
endif;
?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="button-customer pull-right"></div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <?php echo $this->Form->create("PostCategories", ['id' => 'category_form_add']); ?>
            <div class="form-group">
                <label for="name"><?= __('Tên danh mục') ?></label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" required />
                <small id="nameHelp" class="form-text text-muted">The name is how it appears on your site.</small>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" aria-describedby="slugHelp"/>
                <small id="slugHelp" class="form-text text-muted">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</small>
            </div>
            <div class="form-group">
                <label for="parent"><?= __('Danh mục cha') ?></label>
                <select class="form-control" id="parent" name="parent" aria-describedby="parentHelp">
                    <?php foreach ($catOptions as $id => $name) :?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
                <small id="parentHelp" class="form-text text-muted">Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.</small>
            </div>
            <div class="form-group">
                <label for="description"><?= __('Mô tả') ?></label>
                <textarea class="form-control" id="description" name="description" rows="5" aria-describedby="descriptionHelp"></textarea>
                <small id="descriptionHelp" class="form-text text-muted">The description is not prominent by default; however, some themes may show it.</small>
            </div>
            <div class="form-group">
                <label for="featured_image"><?= __('Hình ảnh') ?></label>
                <input type="text" name="image" id="featured_image" value="" class="form-control mb10" placeholder="Enter URL or click choose image" />
                <div class="featured_image">
                    <div class="placeholder">IMAGE</div>
                </div>
                <div>
                    <a href="javascript://" id="addFeaturedImage"><?= __('Chọn ảnh đại diện') ?></a>
                    <a href="javascript://" id="removeFeaturedImage" style="display: none"><?= __('Xóa ảnh đại diện') ?></a>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <?= __('Thêm mới') ?></button>
                <input type="hidden" name="_action" value="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'add']) ?>" />
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="col-md-7">
            <div class="catalog-wrap">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th class="left"><?= __('Tên danh mục') ?></th>
                                <th class="left">Slug</th>
                                <th style="width:94px"><?= __('Tùy chọn') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($catRowsTable as $cat) : ?>
                            <tr class="background-tr">
                                <td><?= $cat->id ?></td>
                                <td class="left">
                                    <a href="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'edit', $cat->id]) ?>" title="<?= __('Chỉnh sửa') ?>">
                                        <?= $cat->name ?>
                                    </a>
                                </td>
                                <td class="left"><?= $cat->slug ?></td>
                                <td>
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'PostCategories', 'action' => 'view', $cat->slug]) ?>" 
                                       class="btn btn-primary btn-xs" title="<?= __('Xem chuyên mục') ?>" target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'edit', $cat->id]) ?>" 
                                       class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'PostCategories', 'action' => 'delete', $cat->id]) ?>" 
                                       class="btn btn-danger btn-xs" title="<?= __('Xóa') ?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>