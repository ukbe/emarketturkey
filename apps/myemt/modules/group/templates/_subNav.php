    <header>
<?php slot('pageHeader') ?>
        <hgroup class="_comSel">
            <?php echo link_to(image_tag($group->getProfilePictureUri()), "@upload-group-logo?hash={$group->getHash()}", "class=_comMng_logo") ?>
            <ul class="_horizontal">
                <li><?php echo link_to(__('Go to Profile'), $group->getProfileUrl()) ?></li>
                <li><?php echo link_to($group->getLogo() ? __('Change Logo') : __('Upload Logo'), "@upload-group-logo?hash={$group->getHash()}") ?></li>
                <li class="_last_item"><?php echo link_to(__('Messages'), "@messages") ?></li>
            </ul>
            <dl>
                <dt>
                    <em><?php echo $group->getName() ?></em>
                </dt>
                <dd>
                    <ul>
                        <?php $props = $sf_user->getUser()->getOwnerships() ?>
                        <?php foreach ($props as $prop): ?>
                        <?php if (!($prop->getObjectTypeId()==PrivacyNodeTypePeer::PR_NTYP_GROUP && $prop->getId() == $group->getId())): ?>
                        <li><?php echo link_to($prop.'<span>switch</span>', $prop->getManageUrl()) ?></li>
                        <?php endif ?>
                        <?php endforeach ?>
                        <li class="_bottom_comMng_links">
                            <?php echo link_to(__('Register Group'), "@group-start", 'class=_right') ?>
                            <br class="clear" />
                        </li>
                    </ul>
                </dd>
            </dl>
        </hgroup>
<?php end_slot() ?>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('myEMT'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo checkActivePage('@group-manage', null, false, '_selected') ?>"><?php echo link_to(__('Overview'), "@group-manage?action=manage&hash={$group->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=groupProfile', null, true, '_selected') ?>><?php echo link_to(__('Edit Group Profile'), "@edit-group-profile?action=edit&hash={$group->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=members', null, true, '_selected') ?><?php echo checkActivePage('module=leads', null, true, '_selected') ?>><?php echo link_to(__('Members'), "@group-members?action=summary&hash={$group->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=discussions', null, true, '_selected') ?><?php echo checkActivePage('module=leads', null, true, '_selected') ?>><?php echo link_to(__('Discussions'), "@group-discussions?action=review&hash={$group->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=events', null, true, '_selected') ?>><?php echo link_to(__('Events'), "@group-events-action?hash={$group->getHash()}&action=overview") ?></dd>
                <dd<?php echo checkActivePage('module=jobs', null, true, '_selected') ?>><?php echo link_to(__('Jobs'), "@group-jobs-action?hash={$group->getHash()}&action=overview") ?></dd>
                <dd class="ui-corner-tr<?php echo checkActivePage('@group-account', null, false, '_selected') ?>"><?php echo link_to(__('Account'), "@group-account?action=settings&hash={$group->getHash()}") ?></dd>
                <dd class="_sp<?php echo checkActivePage('group/upgrade', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), "@group-account?action=upgrade&hash={$group->getHash()}") ?></dd>
            </dl>
        </nav>
<script type="text/javascript">
$(function() {
    
    $('._comSel dt em').click(function(){
        $('._comSel dl').toggleClass('_open');
        return false;
    });
    $("span.btn_container").buttonset();
});
</script>
    </header>