<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'admin';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Admins/index.ctp with your own version.');
endif;
?>
<div class="content-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="info-content-top">
                    <div class="title">
                        <h2>Kết quả bán hàng hôm nay</h2>
                    </div>
                    <div class="report-content-top">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="report-content-top1">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <i class="fa fa-usd"></i>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="report1">
                                                <span class="report1-1">0 Hóa đơn</span><br/>
                                                <span class="report1-2">0</span><br/>
                                                <span class="report1-3">Doanh số</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="report-content-top1">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <i class="fa fa-reply-all"></i>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="report2">
                                                <span class="report2-1">0 phiếu</span><br/>
                                                <span class="report2-2">0</span><br/>
                                                <span class="report2-3">Trả hàng</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="report-content-top1">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <i class="fa fa-arrow-down"></i>
                                        </div>
                                        <div class="col-lg-11">
                                            <div class="report3">
                                                <span class="report3-1">-36.46%</span><br/>
                                                <span class="report3-2">So với cùng kỳ tháng trước</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="img-content-top">
                    <a href="#">
                        <?= $this->Html->image('backend/image-sidebar.png', ['alt' => 'Image Sidebar']) ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>