<emtAjaxResponse>
<emtInit>
<?php echo "
$('#select-net-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });
" ?>

</emtInit>
<emtHeader><?php echo __($title) ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag("@network-list-add?_l={$sf_params->get('_l')}&_g={$sf_params->get('_g')}&_t={$sf_params->get('_t')}", 'id=select-net-form') ?>
<ul class="select-grid">
<?php foreach ($items as $item): ?>
<li><?php echo image_tag($item->getProfilePictureUri()) ?>
    <?php echo $item ?></li>
<?php endforeach ?>
</ul>
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Complete Selection'), "", 'id=select-net-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>