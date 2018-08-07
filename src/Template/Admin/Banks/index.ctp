<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admin/Banks/index.ctp with your own version.');
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
            <form method="post" accept-charset="utf-8" action="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'add']) ?>">
                <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                <div class="form-group">
                    <label for="name"><?= __('Tên ngân hàng') ?></label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" required />
                    <small id="nameHelp" class="form-text text-muted">Ví dụ: Ngân hàng TMCP Ngoại thương Việt Nam - Vietcombank</small>
                </div>
                <div class="form-group">
                    <label for="branch"><?= __('Chi nhánh ngân hàng') ?></label>
                    <input type="text" class="form-control" id="branch" name="branch" aria-describedby="branchHelp" required />
                    <small id="branchHelp" class="form-text text-muted">Ví dụ: Chi nhánh Thành Công</small>
                </div>
                <div class="form-group">
                    <label for="account_number"><?= __('Số tài khoản') ?></label>
                    <input type="text" class="form-control" id="account_number" name="account_number" aria-describedby="account_numberHelp" required />
                    <small id="account_numberHelp" class="form-text text-muted">Ví dụ: 0011004130164</small>
                </div>
                <div class="form-group">
                    <label for="account_name"><?= __('Tên tài khoản') ?></label>
                    <input type="text" class="form-control" id="account_name" name="account_name" aria-describedby="account_nameHelp" required />
                    <small id="account_nameHelp" class="form-text text-muted">Ví dụ: NGUYEN VAN BINH</small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <?= __('Thêm mới') ?></button>
                    <input type="hidden" name="_action" value="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'add']) ?>" />
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <div class="catalog-wrap" style="max-height: 620px">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="hide hidden">ID</th>
                                <th class="left"><?= __('Ngân hàng') ?></th>
                                <th class="text-center"><?= __('Số tài khoản') ?></th>
                                <th style="width:94px"><?= __('Tùy chọn') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($banks as $bank) : ?>
                            <tr class="background-tr">
                                <td class="hide hidden"><?= $bank->id ?></td>
                                <td class="left">
                                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'edit', $bank->id]) ?>" title="<?= __('Chỉnh sửa') ?>">
                                        <?= $bank->name ?>
                                    </a>
                                    <?php if($bank->is_active == 1) : ?>
                                    <span class="status-active">
                                        <i class="fa fa-check-circle"></i>
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $bank->account_number ?></td>
                                <td>
                                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'setActive', $bank->id]) ?>" 
                                       class="btn btn-success btn-xs" title="<?= __('Kích hoạt') ?>">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'edit', $bank->id]) ?>" 
                                       class="btn btn-primary btn-xs" title="<?= __('Chỉnh sửa') ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'Banks', 'action' => 'delete', $bank->id]) ?>" 
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