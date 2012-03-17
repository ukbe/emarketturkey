<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('members/members', array('group' => $group)) ?>
        </div>
    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">

            <section>
                <h4><div class="_right">
                        <?php echo link_to(__('Back to Members'), "@group-members?action=list&hash={$group->getHash()}&page={$sf_params->get('page')}&ipp={$sf_params->get('ipp')}&typ={$sf_params->get('typ')}&view={$sf_params->get('view')}". ($sf_params->get('mkeyword') != '' ? "&mkeyword={$sf_params->get('keyword')}" : "") . ($sf_params->get('type')=='user' && $sf_params->get('gn') ? "&gn={$sf_params->get('gn')}" : "") . ($sf_params->get('type')=='company' && $sf_params->get('sct') ? "&sct={$sf_params->get('sct')}" : ""), "class=bluelink") ?>
                        </div>
                    <?php echo __('Member Permissions') ?>
                </h4>
                <div class="hrsplit-2"></div>
                <?php include_partial('member_top', array('member' => $member, 'group' => $group, 'membership' => $membership)) ?>
                <h5><?php echo __('Permissions') ?></h5>
                <?php echo __('Change member-specific permissions on %1 group.', array('%1' => $group)) ?>
                <div class="hrsplit-2"></div>
                <?php echo __('If you would rather prefer to make changes to default group permissions, you may do so through the %1 page.', array('%1' => link_to(__('Group Permissions'), "@group-account?action=privacy&hash={$group->getHash()}", 'class=inherit-font bluelink hover'))) ?>
                <div class="hrsplit-2"></div>
                <?php echo form_tag("@group-members?action=rights&mid={$member->getPlug()}&hash={$group->getHash()}") ?>
                <table class="prefs">
                <tr class="header">
                    <td></td>
                    <td class="region"><?php echo __('Group Default') ?><span></span></td>
                    <td class="region" colspan="2"><?php echo __('Member Specific') ?>&nbsp;*<span></span></td>
                </tr>
                <?php foreach ($prefs as $pref): ?>
                <?php $default = PrivacyPreferencePeer::retrieveByObject($group->getId(), $group->getObjectTypeId(), $pref->getActionId(), false, RolePeer::RL_GP_MEMBER, $member->getObjectTypeId(), null)  ?>
                <?php $is_default = is_null($pref->getSubjectId()) ?>
                
                <tr><th><?php echo $pref->getAction()->getName() ?></th>
                    <td><?php echo radiobutton_tag("pa_opt_{$pref->getActionId()}", 1, $is_default ? true : false, "id=pa_opt_{$pref->getActionId()}_1") ?>
                        <?php echo label_for("pa_opt_{$pref->getActionId()}_1", $default->getAllowed() ? __('Allow') : __('Deny'), ($is_default ? 'class=t_bold' : '')) ?></td>
                    <td><?php echo radiobutton_tag("pa_opt_{$pref->getActionId()}", 2, !$is_default && $pref->getAllowed(), "id=pa_opt_{$pref->getActionId()}_2") ?>
                        <?php echo label_for("pa_opt_{$pref->getActionId()}_2", __('Allow'),  (!$is_default && $pref->getAllowed() ? 'class=t_bold' : '')) ?></td>
                    <td><?php echo radiobutton_tag("pa_opt_{$pref->getActionId()}", 3, !$is_default && !$pref->getAllowed(), "id=pa_opt_{$pref->getActionId()}_3") ?>
                        <?php echo label_for("pa_opt_{$pref->getActionId()}_3", __('Deny'),  (!$is_default && !$pref->getAllowed() ? 'class=t_bold' : '')) ?></td>
                </tr>
                <?php endforeach ?>
                </table>
                <div class="hrsplit-2"></div>
                <em class="t_grey t_smaller">*&nbsp;<?php echo __('Member specific permission settings override group default settings.') ?></em>
                <div class="hrsplit-2"></div>
                <div class="_right"><?php echo submit_tag(__('Save Settings'), 'class=green-button') ?></div>
                </form>
            </section>
        </div>
    </div>
    
    <div class="col_180">
        <div class="box_180 _titleBG_White" style="margin-top: 42px;">
            <h3><?php echo __('Member Options') ?></h3>
            <div>
                <ul class="side-menu">
                    <li><?php echo link_to(__('Send Message'), "@compose-message?_s={$group->getPlug()}&_r={$member->getPlug()}&_ref=$_here", 'id=send-message style=background: url(/images/layout/icon/led-icons/email.png) no-repeat 1px center; padding-left: 22px;') ?></li>
<?php /*?>                    <li><?php echo link_to(__('Send SMS'), '@homepage', 'style=background: url(/images/layout/icon/sms_message.png) no-repeat 0px center; padding-left: 22px;') ?></li> <?php */ ?>
                    <li><?php echo link_to(__('Change Permissions'), "@group-members?action=rights&mid={$member->getPlug()}&hash={$group->getHash()}", 'style=background: url(/images/layout/icon/led-icons/lock.png) no-repeat 4px center; padding-left: 22px;') ?></li>
                    <li><?php echo link_to(__('Remove Member'), "@group-members?action=member&mid={$member->getPlug()}&act=rm&hash={$group->getHash()}", 'id=remove-member style=background: url(/images/layout/icon/cancel.png) no-repeat 2px center; padding-left: 22px;') ?></li>
                </ul>
            </div>
        </div>
    </div>
<div class="scripter"></div>
</div>
<?php echo javascript_tag("
$(function() {
$('#send-message, #remove-member').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, position: 'window'
    });
    
});

") ?>