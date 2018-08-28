<?php $this->layout = 'default'; ?>

<div class="main-content">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a href="<?=$this->Url->build(['controller' => 'Ads', 'action' => 'add'])?>" class="btn btn-success">Add New</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped tbl-ads-list">
                        <thead>
                            <tr>
                                <th>Name/Size</th>
                                <th>Description</th>
                                <th>Embed Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ads as $ad): ?>
                            <tr id="ad_<?=$ad->id?>">
                                <td>
                                    <p><?=$ad->title?></p>
                                    <p>Size: <?=$ad->width?>x<?=$ad->height?> px</p>
                                    <div class="actions" data-id="<?=$ad->id?>">
                                        <a href="<?= $this->Url->build(['controller' => 'Banners', 'action' => 'preview', $ad->id]) ?>" class="btn btn-info" target="_blank">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Pewview
                                        </a>
                                        <?php if($ad->status == 0): ?>
                                        <span class="btn btn-active"><i class="fa fa-play" aria-hidden="true"></i> Activate</span>
                                        <span class="btn btn-inactive hide"><i class="fa fa-pause" aria-hidden="true"></i> Pause</span>
                                        <?php else: ?>
                                        <span class="btn btn-active hide"><i class="fa fa-play" aria-hidden="true"></i> Activate</span>
                                        <span class="btn btn-inactive"><i class="fa fa-pause" aria-hidden="true"></i> Pause</span>
                                        <?php endif; ?>
                                        <a href="<?= $this->Url->build(['controller' => 'Ads', 'action' => 'edit', $ad->id]) ?>" class="btn btn-edit">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                        </a>
                                        <span class="btn btn-del"><i class="fa fa-times" aria-hidden="true"></i> Delete</span>
                                    </div>
                                </td>
                                <td><?=$ad->description?></td>
                                <td>
                                    <textarea style="width: 100%;height: 100px;max-width: 100%" onfocus="this.select()" class="form-control"><?php
                                    $src = SITE_URL . $this->Url->build(['controller' => 'Banners', 'action' => 'display', $ad->id]);
                                    echo <<<HTML
<iframe width="{$ad->width}" height="{$ad->height}" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no" allowfullscreen="true" style="width:{$ad->width}px;height:{$ad->height}px;" src="{$src}"></iframe>
HTML;
                                    ?></textarea>
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
                        <?php
                        echo $this->Paginator->first('←');
                        echo $this->Paginator->prev('«');
                        echo $this->Paginator->numbers();
                        echo $this->Paginator->next('»');
                        echo $this->Paginator->last('→');
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

