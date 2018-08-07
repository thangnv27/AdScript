<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;
?>
<div class="slide-header">
    <div class="container">
        <h1 class="title-slide">Trao đổi mua bán wex</h1>
        <p class="title-slide-child">Nơi mua bán trao đổi ngoại tệ an toàn và nhanh chóng</p>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-price-buy">
                            <p class="price-buy">Giá bán</p>
                            <p class="price">22,371 VNĐ</p>
                            <a class="btn-now btn-now-1" href="#">
                                Mua ngay
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-price-buy">
                            <p class="price-buy">Giá Mua</p>
                            <p class="price">22,331 VNĐ</p>
                            <a class="btn-now btn-now-2" href="#">
                                Bán ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8"></div>
        </div>
    </div>
</div><!--/.slide-header-->

<?= $this->element('notification') ?>

<div class="main-content">
    <div class="container">
        <div class="title-list-user">
            <div class="row">
                <div class="col-md-6">
                    <div class="list-user-sell">
                        <div class="pull-left">
                            <h2 class="text-user-sell">Danh sách người bán</h2>
                        </div>
                        <div class="pull-right">
                            <?= $this->Html->image('frontend/arrow-left.png', ['class' => 'arrow-left']) ?>
                            <?= $this->Html->image('frontend/arrow-right.png', ['class' => 'arrow-right']) ?>
                        </div>
                    </div>
                    <div class="sell-container">
                        <?php foreach($offersSell as $offer): ?>
                        <div class="wrap-list-user-sell" id="offer_<?= $offer->id ?>">
                            <div class="wrap-name-user-sell">
                                <span class="name-user-sell name-user-sell-no-active"><?=$offer->user->username?></span>
                            </div>
                            <div class="notifi-price">
                                <span class="price"><?php echo number_format($offer->price_view, 2) ?> VNĐ/USD</span>
                                <span class="notifi-bank notifi-bank-no-active">Tối đa: <?php echo number_format($offer->max_amount, 2) ?> USD</span>
                            </div>
                            <!--<div class="change-usd">Tối đa: 0.058237 USD</div>-->
                            <div class="btn-sell" data-id="<?= $offer->id ?>" data-url="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'trade', $offer->id])?>">
                                Mua
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="list-user-buy">
                        <div class="pull-left">
                            <h2 class="text-user-buy">Danh sách người mua</h2>
                        </div>
                        <div class="pull-right">
                            <?= $this->Html->image('frontend/arrow-left.png', ['class' => 'arrow-left']) ?>
                            <?= $this->Html->image('frontend/arrow-right.png', ['class' => 'arrow-right']) ?>
                        </div>
                    </div>
                    <div class="buy-container">
                        <?php foreach($offersBuy as $offer): ?>
                        <div class="wrap-list-user-sell wrap-list-user-buy" id="offer_<?= $offer->id ?>">
                            <div class="wrap-name-user-sell">
                                <span class="name-user-sell name-user-sell-no-active"><?=$offer->user->username?></span>
                            </div>
                            <div class="notifi-price">
                                <span class="price"><?php echo number_format($offer->price_view, 2) ?> VNĐ/USD</span>
                                <span class="notifi-bank notifi-bank-no-active">Tối đa: <?php echo number_format($offer->max_amount, 2) ?> USD</span>
                            </div>
                            <!--<div class="change-usd">Tối đa: 0.058237 USD</div>-->
                            <div class="btn-buy" data-id="<?= $offer->id ?>" data-url="<?=$this->Url->build(['controller' => 'Offers', 'action' => 'trade', $offer->id])?>">
                                Bán
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

