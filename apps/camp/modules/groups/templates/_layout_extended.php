<?php use_helper('Date') ?>
<?php if (!isset($is_ajax) || !$is_ajax): ?>
<table class="data-table extended" id="pymk">
<?php endif ?>
<?php if (count($results = $pager->getResults())): ?>

<?php foreach ($results as $group): ?>
    <tr class="_d">
        <td><?php echo link_to(image_tag($group->getProfilePictureUri()), $group->getProfileUrl()) ?></td>
        <td><strong><?php echo link_to($group, $group->getProfileUrl()) ?></strong>
            <em><b><?php echo $group->getGroupType() ?></b></em>
            <em><?php echo format_number_choice('[0]No members.|[1]1 member|(1,+Inf]%1 members', 
                 array('%1' => array_sum($group->getMembers(null, true))), array_sum($group->getMembers(null, true))) ?></em>
            </td>
        <td><?php if (isset($group->relevel)): ?>
            <div>
                <?php if ($group->relevel == 0): ?>
                <?php echo link_to(__('Connect'), "@join-group?group={$group->getPlug()}", "class=action-button margin-r1 ajax-enabled id=c{$group->getPlug()}") ?>
                <?php echo link_to(__('Ignore'), "@join-group?group={$group->getPlug()}", "class=action-button ajax-enabled id=r{$group->getPlug()}") ?>
                <?php else: ?>
                <div class="txtCenter">
                <?php echo link_to(__('Send Message'), "@myemt.compose-message?_s={$sesuser->getPlug()}&_r={$group->getPlug()}&_ref=$_here", "id=snm{$group->getPlug()} class=ajax-enabled style=background: url(/images/layout/icon/led-icons/email.png) no-repeat 1px center; padding-left: 22px;") ?>
                <div class="hrsplit-1"></div>
                <span class="relevel"><?php echo $group->relevel ?></span></div>
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