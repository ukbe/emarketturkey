<?php use_helper('Date') ?>
<?php if (!isset($is_ajax) || !$is_ajax): ?>
<table class="data-table extended" id="pymk">
<?php endif ?>
<?php if (count($results = $pager->getResults())): ?>

<?php foreach ($results as $user): ?>
    <tr class="_d">
        <td><?php echo link_to(image_tag($user->getProfilePictureUri()), $user->getProfileUrl()) ?></td>
        <td><strong><?php echo link_to($user, $user->getProfileUrl()) ?></strong>
            <em><?php echo implode('<br />', array_filter($user->getCareerLabel())) ?></em>
            <b><?php echo $user->getLocationLabel() ?></b></td>
        <td><?php if (isset($user->relevel)): ?>
            <div>
                <?php if ($user->relevel == 0): ?>
                <?php echo link_to(__('Connect'), "@connect-user?user={$user->getPlug()}", "class=action-button margin-r1 ajax-enabled id=c{$user->getPlug()}") ?>
                <?php echo link_to(__('Ignore'), "@pymk-ignore?user={$user->getPlug()}", "class=action-button ajax-enabled id=r{$user->getPlug()}") ?>
                <?php else: ?>
                <div class="txtCenter">
                <?php echo link_to(__('Send Message'), "@myemt.compose-message?_s={$sesuser->getPlug()}&_r={$user->getPlug()}&_ref=$_here", "id=snm{$user->getPlug()} class=ajax-enabled style=background: url(/images/layout/icon/led-icons/email.png) no-repeat 1px center; padding-left: 22px;") ?>
                <div class="hrsplit-1"></div>
                <span class="relevel"><?php echo $user->relevel ?></span></div>
                <?php endif ?>
            </div>
            <?php endif ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
<?php if (!isset($is_ajax) || !$is_ajax): ?>
    <tr class="_d no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
<?php endif ?>
<?php if (!isset($is_ajax) || !$is_ajax): ?>
</table>
<?php endif ?>