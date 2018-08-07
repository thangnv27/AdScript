<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Dashboard/my_offers.ctp with your own version.');
endif;
?>
<div class="slide-header pdt41"></div><!--/.slide-header-->

<?= $this->element('notification') ?>

<div class="main-content">
    <div class="container">
        <?= $this->element('dashboard-nav-list') ?>
        
        <div class="dashboard-btns">
            <a class="btn btn-sell" href="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'createSell'])?>">Tạo QC Bán</a>
            <a class="btn btn-buy" href="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'createBuy'])?>">Tạo QC Mua</a>
        </div>
        <div class="dashboard-content">
            <h1>Quảng cáo của tôi</h1>
            <div class="title-list-user mt0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="list-user-sell">
                            <h2 class="text-user-sell">Bán WEX</h2>
                        </div>
                        <div class="my-offers">
                            <?php foreach ($offersSell as $offer): ?>
                            <div class="offer-item offer-sell" id="offer_<?= $offer->id ?>">
                                <p class="primary">Giá người mua thấy <span class="num-vnd"><?php echo number_format($offer->price, 2) ?> VNĐ/</span><span class="num-usd">USD</span></p>
                                <p class="secondary">Giá bạn thực nhận <span class="num-vnd"><?php echo number_format($offer->price_view, 2) ?> VNĐ/</span><span class="num-usd">USD</span></p>
                                <p class="secondary">Tối đa <span class="num-usd"><?php echo number_format($offer->max_amount, 2) ?> USD</span></p>
                                <p class="secondary">Trạng thái: 
                                    <?php if($offer->status == 1): ?>
                                    <span class="status active">Kích hoạt</span>
                                    <?php else: ?>
                                    <span class="status inactive">Tạm dừng</span>
                                    <?php endif; ?>
                                </p>
                                <div class="actions" data-id="<?= $offer->id ?>">
                                    <?php if($offer->status == 0): ?>
                                    <span class="btn btn-active"><i class="fa fa-play" aria-hidden="true"></i> Kích hoạt</span>
                                    <span class="btn btn-inactive hide"><i class="fa fa-pause" aria-hidden="true"></i> Tạm dừng</span>
                                    <?php else: ?>
                                    <span class="btn btn-active hide"><i class="fa fa-play" aria-hidden="true"></i> Kích hoạt</span>
                                    <span class="btn btn-inactive"><i class="fa fa-pause" aria-hidden="true"></i> Tạm dừng</span>
                                    <?php endif; ?>
                                    <span class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</span>
                                    <span class="btn btn-del"><i class="fa fa-times" aria-hidden="true"></i> Xóa</span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="list-user-buy">
                            <h2 class="text-user-buy">Mua WEX</h2>
                        </div>
                        <div class="my-offers">
                            <?php foreach ($offersBuy as $offer): ?>
                            <div class="offer-item offer-buy" id="offer_<?= $offer->id ?>">
                                <p class="primary">Giá bạn thực trả <span class="num-vnd"><?php echo number_format($offer->price, 2) ?> VNĐ/</span><span class="num-usd">USD</span></p>
                                <p class="secondary">Giá người mua thấy <span class="num-vnd"><?php echo number_format($offer->price_view, 2) ?> VNĐ/</span><span class="num-usd">USD</span></p>
                                <p class="secondary">Tối đa <span class="num-usd"><?php echo number_format($offer->max_amount, 2) ?> USD</span></p>
                                <p class="secondary">Trạng thái: 
                                    <?php if($offer->status == 1): ?>
                                    <span class="status active">Kích hoạt</span>
                                    <?php else: ?>
                                    <span class="status inactive">Tạm dừng</span>
                                    <?php endif; ?>
                                </p>
                                <div class="actions" data-id="<?= $offer->id ?>">
                                    <?php if($offer->status == 0): ?>
                                    <span class="btn btn-active"><i class="fa fa-play" aria-hidden="true"></i> Kích hoạt</span>
                                    <span class="btn btn-inactive hide"><i class="fa fa-pause" aria-hidden="true"></i> Tạm dừng</span>
                                    <?php else: ?>
                                    <span class="btn btn-active hide"><i class="fa fa-play" aria-hidden="true"></i> Kích hoạt</span>
                                    <span class="btn btn-inactive"><i class="fa fa-pause" aria-hidden="true"></i> Tạm dừng</span>
                                    <?php endif; ?>
                                    <span class="btn btn-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</span>
                                    <span class="btn btn-del"><i class="fa fa-times" aria-hidden="true"></i> Xóa</span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

