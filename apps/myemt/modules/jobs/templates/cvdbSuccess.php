<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('CV Database') ?></h4>
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "$route&action=vault&channel=$channel&fid=$folderid&page=$page&ipp=$ipp&view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&action=vault&channel=$channel&fid=$folderid&page=$page&ipp=$ipp&view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&action=vault&channel=$channel&fid=$folderid&page=$page&ipp=$ipp&view=thumbs", array('title' => __('Thumbnails View'), 'class' => 'thumbs-view frmhelp' . ($view == 'thumbs' ? ' _selected' : ''))) ?>
                </div>
                <div class="hor-filter">
                    <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "$route&action=vault&channel=$channel&fid=$folderid&page=$page&ipp=$ipp&view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Resume Filter'))) : "" ?>
                    <?php echo $folder ? __('Folder:') . ' ' . link_to($folder, "$route&action=vault&channel=$channel&page=$page&ipp=$ipp&view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Resume Filter'))) : "" ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_vault_{$view}", array('pager' => $pager, 'route' => $route, 'job' => $job, 'query' => "channel=$channel&fid=$folderid&page=$page&ipp=$ipp&view=$view", 'profile' => $profile)) ?>
                </div>
            </section>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_Transparent">
            <h3><?php echo __('Credits') ?></h3>
            <div class="smalltext">
                <?php echo __('Your Credits: %1', array('%1' => $credits)) ?>
                <?php if ($credits < 10): ?>
                <div class="hrsplit-1"></div>
                <?php echo link_to(__('Buy Credits'), "$route&action=purchase&act=cvdb") ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    
</div>
<?php echo javascript_tag("
$(function() {
    $('#channel').change(function(){ $(this).closest('form')[0].submit();});
});
") ?>