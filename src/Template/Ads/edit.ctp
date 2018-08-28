<?php $this->layout = 'default'; ?>

<div class="main-content">
    <div class="container">
        <form class="form" id="frmEditAds" action="" method="post" enctype="multipart/form-data">
            <div class="panel panel-info mb0">
                <div class="panel-heading">
                    <h1 class="title"><?=$title?></h1>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <label class="col-sm-3" for="title">Title</label>
                        <div class="col-sm-9">
                            <input type="text" id="title" name="title" value="<?=$ad->title?>" class="form-control" placeholder="eg: 728x90" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="description">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" class="form-control"><?=$ad->description?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="image_url">Image URL</label>
                        <div class="col-sm-9">
                            <p><input type="text" id="image_url" name="image_url" value="<?=$ad->image_url?>" class="form-control" placeholder="https://i.imgur.com/ram51Wy.jpg" /></p>
                            <p class="small">You can upload image to <a href="https://imgur.com/" target="_blank" rel="nofollow">Imgur.com</a> and paste direct link here.</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="target_url">Target URL</label>
                        <div class="col-sm-9">
                            <input type="text" id="target_url" name="target_url" value="<?=$ad->target_url?>" class="form-control" placeholder="https://your_domain.com/page-link" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="utm_params">UTM Parameters</label>
                        <div class="col-sm-9">
                            <p><input type="text" id="utm_params" name="utm_params" value="<?=$ad->utm_params?>" class="form-control" placeholder="utm_campaign=name&utm_source=adscript.net&utm_medium=banner&utm_term=keyword&utm_content=website" /></p>
                            <p class="small">Urchin Tracking Modules – UTM tags or UTM tracking parameters are ways to properly categorize where your website visitors came from! When Google introduced Google Analytics, they also created the 
                                <a title="URL Builder Tool" href="https://support.google.com/analytics/answer/1033867?hl=en" target="_blank" rel="nofollow">URL Builder Tool</a>&nbsp;, which helps you tag your URLs properly. 
                                It allows you to add up to 5 arguments to your website URL, which will help you track that specific ad/post/article within Google Analytics.</p>
                            <p class="small">
                                Campaign Name (utm_campaign)<br/>
                                Campaign Source (utm_source)<br/>
                                Campaign Medium (utm_medium)<br/>
                                Campaign Term (utm_term)<br/>
                                Campaign Content (utm_content)
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Size</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-xs-6 row">
                                    <div class="col-xs-3 pdt5">Width:</div>
                                    <div class="col-xs-9"><input type="number" name="width" value="<?=$ad->width?>" placeholder="728" class="form-control" /></div>
                                </div>
                                <div class="col-xs-6 row">
                                    <div class="col-xs-3 pdt5">Height:</div>
                                    <div class="col-xs-9"><input type="number" name="height" value="<?=$ad->height?>" placeholder="90" class="form-control" /></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <label for="status_1" class="normal mr15">
                                <input type="radio" id="status_1" name="status" value="1" <?php echo ($ad->status==1)?"checked":"" ?> /> Active
                            </label>
                            <label for="status_0" class="normal">
                                <input type="radio" id="status_0" name="status" value="0" <?php echo ($ad->status==0)?"checked":"" ?> /> Inactive
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-primary btn-lg btn-submit">SAVE CHANGES</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

