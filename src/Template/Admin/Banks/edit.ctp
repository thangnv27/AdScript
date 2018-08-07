<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admin/Banks/edit.ctp with your own version.');
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
                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'add']) ?>">
                        <i class="fa fa-plus"></i> <?= __('Thêm mới') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'setActive', $bank->id]) ?>">
                        <i class="fa fa-check"></i> <?= __('Kích hoạt') ?>
                    </a>
                </li>
                <li class="trash">
                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'delete', $bank->id]) ?>">
                        <i class="fa fa-trash"></i> <?= __('Xóa') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'index']) ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?= __('Quay lại') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-wrap">
        <?php echo $this->Form->create("Banks", array('url' => '')); ?>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label"><?= __('Tên ngân hàng') ?></label>
                <div class="col-sm-10">
                    <input type="text" value="<?= $bank->name ?>" class="form-control" id="name" name="name" aria-describedby="nameHelp" required />
                    <small id="nameHelp" class="form-text text-muted">Ví dụ: Ngân hàng TMCP Ngoại thương Việt Nam - Vietcombank</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="branch" class="col-sm-2 col-form-label"><?= __('Chi nhánh ngân hàng') ?></label>
                <div class="col-sm-10">
                    <input type="text" value="<?= $bank->branch ?>" class="form-control" id="branch" name="branch" aria-describedby="branchHelp" required />
                    <small id="branchHelp" class="form-text text-muted">Ví dụ: Chi nhánh Thành Công</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-2 col-form-label"><?= __('Số tài khoản') ?></label>
                <div class="col-sm-10">
                    <input type="text" value="<?= $bank->account_number ?>" class="form-control" id="account_number" name="account_number" aria-describedby="account_numberHelp" required />
                    <small id="account_numberHelp" class="form-text text-muted">Ví dụ: 0011004130164</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="account_name" class="col-sm-2 col-form-label"><?= __('Tên tài khoản') ?></label>
                <div class="col-sm-10">
                    <input type="text" value="<?= $bank->account_name ?>" class="form-control" id="account_name" name="account_name" aria-describedby="account_nameHelp" required />
                    <small id="account_nameHelp" class="form-text text-muted">Ví dụ: NGUYEN VAN BINH</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2"><?= __('Ngày tạo') ?></label>
                <div class="col-sm-3">
                    <?php echo date('d/m/Y H:i:s', strtotime($bank->created_date)); ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2"><?= __('Ngày sửa') ?></label>
                <div class="col-sm-3">
                    <?php echo date('d/m/Y H:i:s', strtotime($bank->updated_date)); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?= __('Lưu thay đổi') ?></button>
                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'index']) ?>" class="btn btn-default">
                        <i class="fa fa-ban" aria-hidden="true"></i> <?= __('Hủy') ?>
                    </a>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>