<?php if($ad->status == 1): ?>
<a href="<?=$ad->target_url?>?<?=$ad->utm_params?>" target="_blank">
    <img src="<?=$ad->image_url?>" alt="<?=$ad->title?>" width="<?=$ad->width?>" height="<?=$ad->height?>" />
</a>
<?php else: ?>
<a href="<?=SITE_URL?>?utm_campaign=placeholder&utm_source=adscript.net&utm_medium=banner&utm_term=placeholder&utm_content=demo" target="_blank">
    <img src="https://via.placeholder.com/<?=$ad->width?>x<?=$ad->height?>" alt="<?=$ad->title?>" width="<?=$ad->width?>" height="<?=$ad->height?>" />
</a>
<?php endif; ?>