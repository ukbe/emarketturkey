<?php use_helper('Date') ?>
<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('Employers'), '@homepage') ?></li>
            <li><span><?php echo $group ?></span></li>
        </ul>
    </div>

    <div class="col_180">
    <?php if ($group->getLogo()): ?>
        <div class="box_180 txtCenter">
            <?php echo link_to(image_tag($group->getLogo()->getMediumUri()), "@group-jobs?hash={$group->getHash()}") ?>
        </div>
    <?php endif ?>
        <div class="box_180 txtCenter">
            <?php echo like_button($group) ?>
        </div>

<?php include_partial('leftmenu_group', array('group' => $group, 'sesuser' => $sesuser))?>
    </div>

    <div class="col_576 b2bProduct">

        <h3 class="pname"><?php echo $group ?><div class="t_grey" style="font-size: 14px;"><?php echo __('Jobs') ?></div></h3>
        <div class="box_576">
            <div class="_noBorder pad-0">
                <table class="job-list">
                    <tr><th><?php echo __('Job Title') ?></th>
                        <th><?php echo __('Deadline') ?></th></tr>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?php echo link_to($job, $job->getUrl(), 'class=inherit-font bluelink hover') ?><?php echo $sesuser->getUserJob($job->getId(), UserJobPeer::UJTYP_FAVOURITE) ? '<em class="bookmarked" title="'.__('Bookmarked').'"></em>' : '' ?>
                            <?php echo count($tx = $job->getTopSpecsText(true, null)) ? "<span>".implode(', ', $tx)."</span>" : "" ?></td>
                        <td><?php echo format_date($job->getDeadline('U'), 'D') ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('How are you connected?') ?></h3>
            <div>
                <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $group)) ?>
            </div>
        </div>
    </div>
</div>
<?php if ($act): ?>
<div id="action-success" class="ghost">
<div class="dynaboxMsg check"><?php echo __($messages[$act]) ?></div>
</div>
<a id="hidden-trigger" class="ghost"></a>
<?php echo javascript_tag("
$(function(){
    $('#hidden-trigger').dynabox({clickerMethod: 'click', loadMethod: 'static', loadType: 'html', sourceElement: '#action-success', fillType: 'copy', position: 'window', autoUpdate: false, showHeader: false, showFooter: false}).bind('dynaboxopened', function(){ setTimeout(function(){ $.ui.dynabox.openBox.close(); }, 1800)});
    $('#hidden-trigger').data('dynabox').open();
});
") ?>
<?php endif ?>
