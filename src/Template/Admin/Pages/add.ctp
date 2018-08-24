<?php $this->layout = 'admin'; ?>
<div class="container">
    <div class="info-customer">
        <div class="title-customer pull-left">
            <h2><?= __('Thêm mới') ?></h2>
        </div>
        <div class="button-customer pull-right">
            <ul>
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
            'placeholder' => __('Nhập tiêu đề tại đây')
        ));
        echo $this->Form->input('slug', array(
            'class' => 'form-control',
            'label' => array(
                'text' => __('Slug'),
                'class' => 'col-sm-2'
            ),
            'placeholder' => __('chuoi-duong-dan-tinh')
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
                'rows' => 20
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
                'maxlength' => 156
            ));
            ?>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"><?= __('Ảnh đại diện') ?></label>
            <div class="col-sm-10">
                <input type="hidden" name="image" id="featured_image" value="<?= $page->image ?>" />
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
            <label for="status" class="col-sm-2"><?= __('Trạng thái') ?></label>
            <div class="col-sm-3">
                <?php
                echo $this->Form->select('status', CommonsComponent::getPostStatus(), array(
                    'required' => true,
                    'id' => 'status',
                    'default' => 'publish',
                    'class' => 'form-control',
                ));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-2">
                <?php
                echo $this->Form->button('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Thêm mới'), array(
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