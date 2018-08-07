<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller\Component\CommonsComponent;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admin/Pages/edit.ctp with your own version.');
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
                    <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Pages', 'action' => 'view', $page->slug]) ?>" target="_blank">
                        <i class="fa fa-eye"></i> <?= __('Xem trang') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <?php if($page->status == 'trash'): ?>
                <li class="trash">
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'delete', $page->id]) ?>" 
                       onclick="return confirm('<?= __('Trang này sẽ bị xóa vĩnh viễn!\nBạn có muốn tiếp tục không?') ?>')">
                        <i class="fa fa-trash"></i> <?= __('Xóa') ?>
                    </a>
                </li>
                <?php else: ?>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'duplicate', $page->id]) ?>">
                        <i class="fa fa-clone"></i> <?= __('Nhân bản') ?>
                    </a>
                </li>
                <li class="trash">
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'trash', $page->id]) ?>" 
                       onclick="return confirm('<?= __('Bạn có chắc chắn muốn xóa không?') ?>')">
                        <i class="fa fa-trash"></i> <?= __('Xóa') ?>
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'index']) ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?= __('Quay lại') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-wrap">
        <?php
        echo $this->Form->create("Pages", array(
            'url' => ''
        ));
        $this->Form->templates([
            'input' => '<div class="col-sm-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
            'inputContainer' => '<div class="form-group row input {{type}}{{required}}">{{content}}</div>',
            'textarea' => '<div class="col-sm-10"><textarea name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
        ]);
        echo $this->Form->input('title', array(
            'required' => true,
            'class' => 'form-control',
            'label' => array(
                'text' => __('Tiêu đề trang'),
                'class' => 'col-sm-2'
            ),
            'placeholder' => __('Nhập tiêu đề tại đây'),
            'value' => $page->title
        ));
        echo $this->Form->input('slug', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Slug'),
                'class' => 'col-sm-2'
            ),
            'placeholder' => __('chuoi-duong-dan-tinh'),
            'value' => $page->slug
        ));
        ?>
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="content"><?= __('Nội dung đầy đủ') ?></label>
            </div>
            <?php
            echo $this->Form->textarea('content', array(
                'id' => 'post_content',
                'class' => 'form-control',
                'rows' => 20,
                'value' => $page->content
            ));
            ?>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="excerpt"><?= __('Mô tả ngắn') ?></label>
                <small class="help-block"><?= __('Độ dài không quá 156 ký tự.') ?></small>
            </div>
            <?php
            echo $this->Form->textarea('excerpt', array(
                'id' => 'excerpt',
                'class' => 'form-control',
                'rows' => 3,
                'maxlength' => 156,
                'value' => $page->excerpt
            ));
            ?>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"><?= __('Ảnh đại diện') ?></label>
            <div class="col-sm-10">
                <input type="hidden" name="image" id="featured_image" value="<?= $page->image ?>" />
                <div class="featured_image">
                    <?php if(empty($page->image)): ?>
                    <div class="placeholder">IMAGE</div>
                    <?php else: ?>
                    <img alt="<?= $page->title ?>" src="<?= $page->image ?>" />
                    <?php endif; ?>
                </div>
                <div>
                    <a href="javascript://" id="addFeaturedImage"><?= __('Chọn ảnh đại diện') ?></a>
                    <a href="javascript://" id="removeFeaturedImage" style="display: none"><?= __('Xóa ảnh đại diện') ?></a>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-2"><?= __('Trạng thái') ?></label>
            <div class="col-sm-3">
                <?php
                echo $this->Form->select('status', CommonsComponent::getPostStatus(), array(
                    'required' => true,
                    'id' => 'status',
                    'default' => 'publish',
                    'class' => 'form-control',
                    'value' => $page->status
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"><?= __('Ngày đăng') ?></label>
            <div class="col-sm-3">
                <?php echo date('d/m/Y H:i:s', strtotime($page->created_date)); ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"><?= __('Chỉnh sửa') ?></label>
            <div class="col-sm-3">
                <?php echo date('d/m/Y H:i:s', strtotime($page->updated_date)); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-2">
                <?php
                echo $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . __('Lưu thay đổi'), array(
                    'class' => 'btn btn-success',
                    'type' => 'submit'
                ));
                ?>
                <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'index']) ?>" class="btn btn-default">
                    <i class="fa fa-ban" aria-hidden="true"></i> <?= __('Hủy') ?>
                </a>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    </div>