<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Ads/index.ctp with your own version.');
endif;
?>

<div class="main-content">
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h1 class="title"><?=$title?></h1>
            </div>
            <form class="form" id="frmAddAds" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class=""></div>
                </div>
            </form>
        </div>
    </div>
</div>

