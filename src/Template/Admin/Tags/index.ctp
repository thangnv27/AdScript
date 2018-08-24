<?php $this->layout = 'admin'; ?>
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
            <form method="post" accept-charset="utf-8" action="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'add']) ?>">
                <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                <div class="form-group">
                    <label for="name"><?= __('Tên thẻ') ?></label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" required />
                    <small id="nameHelp" class="form-text text-muted">The name is how it appears on your site.</small>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" aria-describedby="slugHelp"/>
                    <small id="slugHelp" class="form-text text-muted">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</small>
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
                    <input type="hidden" name="_action" value="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'add']) ?>" />
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <div class="catalog-wrap" style="max-height: 620px">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th class="left"><?= __('Tên thẻ') ?></th>
                                <th class="left">Slug</th>
                                <th style="width:94px"><?= __('Tùy chọn') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tags as $cat) : ?>
                            <tr class="background-tr">
                                <td><?= $cat->id ?></td>
                                <td class="left">
                                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'edit', $cat->id]) ?>" title="<?= __('Chỉnh sửa') ?>">
                                        <?= $cat->name ?>
                                    </a>
                                </td>
                                <td class="left"><?= $cat->slug ?></td>
                                <td>
                                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Tags', 'action' => 'view', $cat->slug]) ?>" 
                                       class="btn btn-primary btn-xs" title="<?= __('Xem chuyên mục') ?>" target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'edit', $cat->id]) ?>" 
                                       class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'Tags', 'action' => 'delete', $cat->id]) ?>" 
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
    </div>
</div>