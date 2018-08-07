<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Offers/create_buy.ctp with your own version.');
endif;
?>
<div class="slide-header pdt41">
</div><!--/.slide-header-->

<?= $this->element('notification') ?>

<div class="main-content">
    <div class="container">
        <?= $this->element('dashboard-nav-list') ?>
        
        <div class="dashboard-btns">
            <a class="btn btn-sell" href="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'createSell'])?>">Tạo QC Bán</a>
            <a class="btn btn-buy" href="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'createBuy'])?>">Tạo QC Mua</a>
        </div>
        <div class="dashboard-content">
            <h1>TÔI MUỐN MUA WEX (USD)</h1>
            <form class="form" id="frmCreateOfferBuy" action="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'createBuy'])?>" method="post">
                <fieldset>
                    <legend>GIÁ MUA</legend>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-6" for="price">Giá bạn thực trả</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" name="price" id="price" value="" class="form-control" placeholder="0" />
                                        <span class="input-group-addon">VNĐ/USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description mt5">Giá 1 USD theo VNĐ</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-6" for="price_view">Giá người bán thấy</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" name="price_view" id="price_view" value="" class="form-control" placeholder="0" />
                                        <span class="input-group-addon">VNĐ/USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description mt5">Giá đã bao gồm phí giao dịch do người bán chịu.</div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>GIỚI HẠN</legend>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-6" for="min_amount">Tối thiểu</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" name="min_amount" id="min_amount" value="5" class="form-control" placeholder="5" />
                                        <span class="input-group-addon">USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description mt5">Số USD tối thiểu trong một giao dịch. (ít nhất là 5 USD)</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-6" for="max_amount">Tối đa</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" name="max_amount" id="max_amount" value="100,000" class="form-control" placeholder="100,000" />
                                        <span class="input-group-addon">USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description">Số USD tối đa trong một giao dịch. Số dư ví USD của bạn cũng có thể hạn chế số tiền này. (tối đa 100,000 USD).</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-6" for="limit_time">Thời gian thanh toán</label>
                                <div class="col-sm-6">
                                    <select name="limit_time" id="limit_time" class="form-control">
                                        <option value="15">15 phút</option>
                                        <option value="30">30 phút</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description">Nếu người mua không hoàn thành thanh toán trong thời gian này, giao dịch sẽ bị huỷ tự động.</div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button type="submit" class="btn btn-lg btn-primary btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin '></i> ĐANG XỬ LÝ">TẠO QUẢNG CÁO</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

