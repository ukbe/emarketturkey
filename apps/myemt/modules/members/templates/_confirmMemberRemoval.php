<emtAjaxResponse>
<emtInit>
<?php echo "
$('#remem-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });
" ?>

</emtInit>
<emtHeader><?php echo __('Confirm Member Removal') ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_tag("@group-members?action=member&act=rm&mid={$member->getPlug()}&hash={$group->getHash()}", 'id=remem-form') ?>
<div class="pad-2 t_black">
    <p class="t_larger"><?php echo __('You are about to REMOVE member <b>%1</b> from group <b>%2</b>', array('%1' => $member, '%2' => $group)) ?></p>
    <p class="t_larger"><?php echo __('Do you confirm the REMOVAL of the member from the group?') ?></p>
    <em><?php echo __('Attention! This action cannot be undone.') ?></em>
    <div class="hrsplit-1"></div>
<?php echo input_hidden_tag('do', 'commit') ?>
</div>
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Confirm Removal'), "", 'id=remem-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>