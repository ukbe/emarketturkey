<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180 _titleBG_Green">
            <h3><?php echo __('Quick Links') ?></h3>
            <div>
                <ul class="_linksVertical" style="padding: 0px;">
                    <li><?php echo link_to(__('Add New Product'), "@add-product?hash={$group->getHash()}") ?></li>
                    <li><?php echo link_to(__('Post Selling/Buying Lead'), "@post-lead?hash={$group->getHash()}") ?></li>
                    <li><?php echo link_to(__('Post New Job'), "@group-jobs-action?action=post&hash={$group->getHash()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_GROUP) ?></li>
                    <li><?php echo link_to(__('Create Event'), "@group-events-action?action=add&hash={$group->getHash()}") ?></li>
                </ul>
            </div>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576">
            <h4><?php echo __('Manage Company') ?></h4>
            <div class="_noBorder">
                <?php echo __('On this section you can manage your company account by following module links above.')?>
            </div>
        </div>

    </div>

    <div class="col_180">
        <?php include_partial('group/upgradeBox', array('group' => $group)) ?>

    </div>
    
</div>



<?php /* ?>

<?php slot('mappath') ?>
<?php end_slot() ?>
<?php slot('rightcolumn') ?>
<div>
<?php if (count($tips)): ?>
<div class="iconed-header">
<span><?php echo image_tag('layout/icon/tips-icon.png') ?></span>
<span><?php echo __('Tips') ?></span></div>
<div>
<ul class="circled-list">
<?php foreach ($tips as $label => $tip): ?>
<li><?php echo link_to(__($label), $tip[0]) . '<br />' . __($tip[1]) ?></li>
<?php endforeach ?>
</ul>
</div>
<?php endif ?>
</div>
<?php end_slot() ?>

<div class="column span-30 append-2">
<?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM), array('title' => $group->getDisplayName())), $group->getProfileUrl()) ?>
<ol>
<li class="iconed-header" style="height: 20px;">
<span class="span-4"><?php echo link_to(image_tag('layout/icon/pencil-icon.png'), '@group-manage?action=logo&stripped_name='.$group->getStrippedName()) ?></span>
<span><?php echo link_to($group->getLogo()?__('Change Logo'):__('Upload Logo'), '@group-manage?action=logo&stripped_name='.$group->getStrippedName()) ?></li>
<li class="iconed-header">
<span class="span-4"><?php echo link_to(image_tag('layout/icon/messages-empty-icon.png'), '@myemt.messages', array('query_string' => 'cls=inbox&mod=gr')) ?></span>
<span><?php echo link_to(__('Messages'), '@myemt.messages', array('query_string' => 'cls=inbox&mod=gr')) ?></li>
</ol>

</div>

<div class="column span-123">
<div style="font: bold 15px tahoma;"><?php echo $group->getDisplayName() ?></div>
<div class="hrsplit-2"></div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/tag-icon.png'), '@group-manage?action=edit&stripped_name='.$group->getStrippedName()) ?>
<ol>
<li><?php echo link_to(__('Group Information'), '@group-manage?action=edit&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Edit Information'), '@group-manage?action=basic&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Edit Contact Details'), '@group-manage?action=contact&stripped_name='.$group->getStrippedName()) ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/network-icon.png'), '@group-manage?action=members&stripped_name='.$group->getStrippedName()) ?>
<ol>
<li><?php echo link_to(__('Group Members'), '@group-manage?action=members&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('List Members'), '@group-manage?action=members&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Pending Memberships'), '@group-manage?action=members&stripped_name='.$group->getStrippedName().'&typ=pending') ?></li>
<li><?php echo link_to(__('Invite People'), '@group-manage?action=invite&stripped_name='.$group->getStrippedName()) ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/calender-icon.png'), '@group-manage?action=events&stripped_name='.$group->getStrippedName()) ?>
<ol>
<li><?php echo link_to(__('Calender'), '@group-manage?action=events&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Events'), '@group-manage?action=events&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Attendance Notice'), '@group-manage?action=attendance&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Add Event'), '@group-manage?action=new-event&stripped_name='.$group->getStrippedName()) ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/media-icon.png'), '@group-manage?action=events&stripped_name='.$group->getStrippedName()) ?>
<ol>
<li><?php echo link_to(__('Media'), '@group-manage?action=media&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Logo'), '@group-manage?action=logo&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Photos'), '@group-manage?action=photos&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Documents'), '@group-manage?action=documents&stripped_name='.$group->getStrippedName()) ?></li>
<li><?php echo link_to(__('Videos'), '@group-manage?action=videos&stripped_name='.$group->getStrippedName()) ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/jobs-icon.png'), "@myemt.group-jobs-action?action=home&own={$group->getId()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_GROUP) ?>
<ol>
<li><?php echo link_to(__('Jobs'), "@myemt.group-jobs-action?action=home&own={$group->getId()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_GROUP) ?></li>
<li><?php echo link_to(__('Edit Jobs'), "@myemt.group-jobs-action?action=list&own={$group->getId()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_GROUP) ?></li>
<li><?php echo link_to(__('Add Job'), "@myemt.group-jobs-action?action=new&own={$group->getId()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_GROUP) ?></li>
</ol>
</div>
</div>
<?php */ ?>