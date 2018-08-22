<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'default';

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Dashboard/index.ctp with your own version.');
endif;
?>

<div class="main-content">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a href="<?=$this->Url->build(['controller' => 'Ads', 'action' => 'add'])?>" class="btn btn-success">Add New</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name/Size</th>
                                <th>Description</th>
                                <th>Preview</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ads as $ad): ?>
                            <tr>
                                <td><?=$ad->title?></td>
                                <td><?=$ad->description?></td>
                                <td>
                                    <a href="<?=$ad->target_url?>" target="_blank" rel="nofollow">
                                        <img src="<?=$ad->image_url?>" alt="<?=$ad->title?>" />
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

