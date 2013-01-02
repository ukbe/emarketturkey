<emtAjaxResponse>
<emtInit>
<?php echo "
$('#termjob').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });
" ?>

</emtInit>
<emtHeader><?php echo __('Please Confirm') ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_tag("@myjobs-applied-view?guid={$job->getGuid()}&act=term", 'id=termjob') ?>
<div class="pad-2 t_black">
    <p class="t_larger"><?php echo __('You are about to terminate your job application for <b>%1</b>', array('%1' => $job)) ?></p>
    <em><?php echo __('Attention! This action cannot be undone.') ?></em>
    <div class="hrsplit-1"></div>
<?php echo input_hidden_tag('do', 'commit') ?>
<?php echo input_hidden_tag('has', $confirmterm) ?>
</div>
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Yes, Terminate!'), "", 'id=termjob-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>