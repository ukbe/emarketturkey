<emtAjaxResponse>
<emtInit>
<?php echo "
$('#rem-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });
" ?>
</emtInit>
<emtHeader><?php echo __('Please Confirm') ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_tag($postUrl, 'id=rem-form') ?>
<div class="pad-2 t_black">
    <p class="t_larger"><?php echo __($message) ?></p>
    <em><?php echo __('Attention! This action cannot be undone.') ?></em>
    <div class="hrsplit-1"></div>
<?php echo isset($object) ? input_hidden_tag('id', $object->getId()) : '' ?>
<?php echo input_hidden_tag('act', isset($act) ? $act : 'rem') ?>
<?php echo input_hidden_tag('do', 'commit') ?>
</div>
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
    <?php echo link_to_function(__('Yes, Delete!'), "", 'id=rem-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>