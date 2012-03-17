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
                <h4 style="border-bottom: none;"><?php echo __('Job Post: <span class="t_green">%1</span>', array('%1' => $job->getTitle())) ?></h4>
                <ul class="tabmenu clear">
                    <li><?php echo link_to(__('Job Preview'), "$jobroute&action=details") ?></li>
                    <li><?php echo link_to(__('Applicants'), "$jobroute&action=applicants", "class=selected") ?></li>
                    <li><?php echo link_to_function(__('Statistics'), "", 'class=t_grey') ?></li>
                </ul>
                <div class="hrsplit-1"></div>

                <div id="list-buttons" class="_left">
                    <span class="ui-smaller">
                    <?php foreach (UserJobPeer::$statusLabels as $stat => $label): ?>
                        <?php echo link_to(__($label) . (isset($appcount[$stat]) ? " ({$appcount[$stat]})" : ''), "$jobroute&action=applicants&page=$page&ipp=$ipp&view=$view&status=$stat", $status == $stat ? 'class=ui-state-selected' : '') ?>
                    <?php endforeach ?>
                    </span>
                </div>
                
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "$jobroute&action=applicants&status=$status&page=$page&ipp=$ipp&view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$jobroute&action=applicants&status=$status&page=$page&ipp=$ipp&view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$jobroute&action=applicants&status=$status&page=$page&ipp=$ipp&view=thumbs", array('title' => __('Thumbnails View'), 'class' => 'thumbs-view frmhelp' . ($view == 'thumbs' ? ' _selected' : ''))) ?>
                </div>
                <div class="hor-filter">
                </div>
                <div class="hrsplit-1"></div>
                <div class="clear">
                    <?php include_partial("layout_app_{$view}", array('pager' => $pager, 'route' => $route, 'job' => $job, 'query' => "status=$status&page=$page&ipp=$ipp&view=$view")) ?>
                    <?php if ($status != UserJobPeer::UJ_STAT_TYP_IGNORED): ?>
                    <em class="ln-example _right" style="clear: left;"><?php echo __('* Ignored applicants were not listed.') ?></em>
                    <?php endif ?>
                </div>
            </section>
        </div>
    </div>

    <div class="col_180">
    </div>
    
</div>
<?php echo javascript_tag("
$(function() {
    $('#list-buttons').buttonset();
});
") ?>