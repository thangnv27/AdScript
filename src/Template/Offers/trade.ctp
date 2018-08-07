<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Offers/trade.ctp with your own version.');
endif;
?>
<div class="slide-header pdt41">
</div><!--/.slide-header-->

<?= $this->element('notification') ?>

<div class="main-content">
    <div class="container">
        <div class="row mt30">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <h1 class="uppercase mb30"><?=$title?></h1>
                <?php if(!empty($message)): ?>
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?=$message?>
                </div>
                <?php else: ?>
                <form class="form" id="frmTradeCreate" action="<?=$this->Url->build(['controller' => 'Trades', 'action' => $action, $offer->id])?>" method="post">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="amount">Số lượng USD</label>
                            <div class="input-group">
                                <input type="text" name="amount" id="amount" value="" class="form-control" placeholder="0" />
                                <span class="input-group-addon">USD</span>
                            </div>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="fiat_amount">Số lượng VNĐ</label>
                            <div class="input-group">
                                <input type="text" name="fiat_amount" id="fiat_amount" value="" class="form-control" placeholder="0" disabled />
                                <span class="input-group-addon">VNĐ</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb30">
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-primary btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin '></i> ĐANG XỬ LÝ">
                                <?php
                                if($action == "sell"){
                                    echo 'BÁN WEX';
                                } else {
                                    echo 'MUA WEX';
                                }
                                ?>
                            </button>
                        </div>
                    </div>
                </form>
                <?php endif; ?>

                <div class="panel panel-info trade-info">
                    <div class="panel-heading">
                        Thông tin chi tiết quảng cáo
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="40%">
                                    <?php
                                    if($action == "sell"){
                                        echo 'Bán cho';
                                    } else {
                                        echo 'Mua từ';
                                    }
                                    ?>
                                </th>
                                <th><a href="<?=$this->Url->build(['controller' => 'Users', 'action' => 'profile', $offer->user->username])?>"><u><?=$offer->user->username?></u></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Giá</td>
                                <td><strong class="offer-price text-success">
                                        <span><?php echo number_format($offer->price_view, 2) ?> VNĐ</span>/<span class="text-btc-color">USD</span>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td>Lượng giới hạn:</td>
                                <td><span class="currency-amount">
                                        <span class="label label-success usd"><?php echo number_format($offer->min_amount, 2) ?> USD</span>
                                    </span>-
                                    <span class="currency-amount">
                                        <span class="label label-success usd"><?php echo number_format($offer->max_amount, 2) ?> USD</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center text-warning" colspan="2">
                                    <span class="label label-warning">
                                        <em class="icon-lock"></em><span>Yêu cầu người <?php echo ($action == "sell")?"bán":"cho"; ?> xác minh tài khoản</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="price_view" value="<?= $offer->price_view?>" />