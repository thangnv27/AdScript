<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Dashboard/trades_closed.ctp with your own version.');
endif;
?>
<div class="slide-header pdt41">
</div><!--/.slide-header-->

<?= $this->element('notification') ?>

<div class="main-content">
    <div class="container">
        <?= $this->element('dashboard-nav-list') ?>
        
        <div class="dashboard-content">
            <h1>Giao dịch đã đóng</h1>
            <p>Chưa có giao dịch nào</p>
        </div>
    </div>
</div>

