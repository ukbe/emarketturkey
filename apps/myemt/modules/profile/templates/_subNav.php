    <header>
<?php slot('pageHeader') ?>
        <hgroup class="_comSel">
            <?php echo link_to(image_tag($sesuser->getProfilePictureUri()), "@edit-profile-picture", "class=_comMng_logo") ?>
            <ul class="_horizontal">
                <li><?php echo link_to(__('Go to Profile'), $sesuser->getProfileUrl()) ?></li>
                <li><?php echo link_to($sesuser->getProfilePicture() ? __('Change Photo') : __('Upload Photo'), "@edit-profile-picture") ?></li>
                <li class="_last_item"><?php echo link_to(__('Messages'), "@messages") ?></li>
            </ul>
            <dl>
                <dt>
                    <em><?php echo $sesuser ?></em>
                </dt>
                <dd>
                    <ul>
                        <?php $props = $sf_user->getUser()->getOwnerships() ?>
                        <?php foreach ($props as $prop): ?>
                        <?php if ($prop->getObjectTypeId()!=PrivacyNodeTypePeer::PR_NTYP_USER): ?>
                        <li><?php echo link_to($prop.'<span>switch</span>', $prop->getManageUrl()) ?></li>
                        <?php endif ?>
                        <?php endforeach ?>
                        <li class="_bottom_comMng_links">
                            <?php echo link_to(__('Register Company'), "@register-comp", 'class=_right') ?>
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
                <dd class="ui-corner-tl<?php echo checkActivePage('@homepage', null, false, '_selected') ?>"><?php echo link_to(__('Overview'), "@homepage") ?></dd>
                <dd<?php echo checkActivePage('module=contacts', null, true, '_selected') ?>><?php echo link_to(__('Contacts'), "@contacts") ?></dd>
                <?php /*?><dd<?php echo checkActivePage('@calender', null, true, '_selected') ?>><?php echo link_to(__('Calendar'), "@calendar") ?></dd> */ ?>
                <dd<?php echo checkActivePage('@mycareer', null, true, '_selected') ?>><?php echo link_to(__('My Career'), "@mycareer") ?></dd>
                <dd class="ui-corner-tr<?php echo checkActivePage('module=account', null, false, '_selected') ?>"><?php echo link_to(__('Account'), "@account") ?></dd>
                <dd class="_sp <?php echo checkActivePage('@invite-friend', null, false, ' _selected') ?>"><?php echo link_to(__('INVITE FRIENDS'), "@invite-friend") ?></dd>
            </dl>
        </nav>
<script type="text/javascript">
$(function() {
    
    $('._comSel dt em').click(function(){
        $('._comSel dl').toggleClass('_open');
        return false;
    });
});
</script>
    </header>