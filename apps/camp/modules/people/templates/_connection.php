<?php use_helper('Object') ?>
<emtAjaxResponse>
<emtInit>
$('#con-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });

window.initElementsScript('#TB_window');
</emtInit>
<emtHeader><?php echo __('Connection between you and %1', array('%1' => $user)) ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag(url_for("@connect-user?user={$user->getPlug()}", true), 'id=con-form') ?>
<?php echo input_hidden_tag('_ref', $_ref) ?>
<dl class="_table">
    <dt><?php echo image_tag($user->getProfilePictureUri()) ?></dt>
    <dd><strong><?php echo $user ?></strong></dd>
    <dt></dt>
    <dd><div><?php echo emt_label_for('mod_chanrel', __('Update Relationship')) ?></div>
        <div class="_left margin-r2">
        <?php echo select_tag('relation', _get_options_from_objects(RolePeer::getRolesRelatedTo(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_USER))) ?>
        </div>
        <div><?php echo submit_tag(('Update'), 'class=green-button') ?></div>
        </dd>
    <dt></dt>
    <dd><?php echo __('or') ?></dd>
    <dt></dt>
    <dd><?php echo link_to(__('Remove from Friends'), "@connect-user?user={$user->getPlug()}&mod=remove", 'class=dark-button') ?></dd>
</dl>
</form>
<div class="clear"></div>
</section>
</emtBody>
</emtAjaxResponse>