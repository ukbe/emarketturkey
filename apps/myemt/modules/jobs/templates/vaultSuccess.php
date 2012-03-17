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
                <h4>
                <?php echo __('CV Vault') ?></h4>
                </h4>
                <span class="btn_container" style="margin-top: 8px;">
                    <?php echo form_tag("$route&action=vault", 'method=get') ?>
                    <?php echo emt_label_for('channel', __('Channel:')) ?>&nbsp;
                    <?php echo select_tag('channel', options_for_select(DatabaseCVPeer::$channelLabels, $channel, array('include_custom' => __('Overview')))) ?>
                    </form>
                </span>
                <?php if (!($channel || $folder || $sf_params->get('vault_keyword') != '')): ?>
                <div id="chart_div" class="_right">
                </div>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Channel');
        data.addColumn('number', 'Number of CVs');
        data.addRows(5);
        data.setValue(0, 0, 'Job Applications');
        data.setValue(0, 1, <?php echo $cvcounts[DatabaseCVPeer::CHANNEL_APPLICATION] ?>);
        data.setValue(1, 0, 'Referral Signup');
        data.setValue(1, 1, <?php echo $cvcounts[DatabaseCVPeer::CHANNEL_REFERRAL] ?>);
        data.setValue(2, 0, 'CV Database Service');
        data.setValue(2, 1, <?php echo $cvcounts[DatabaseCVPeer::CHANNEL_SERVICE] ?>);

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 300, height: 140, legend: 'right', chartArea: {left: 0, top: 20, width: 300, height: 100}, pieSliceText: 'value'});
      }
    </script>
                <div>
                    <?php echo __('There are %1 records in your CV Vault channels.', array('%1' => array_sum($cvcounts))) ?>
                    <br /><br />
                    <?php echo __('You may browse the vault by selecting channel on the right corner.') ?>
                    <br /><br />
                    <?php echo emt_label_for('vault_keyword', __('Search in your vault:')) ?>
                    <br />
                    <?php echo form_tag("$route&action=vault", 'method=get') ?>
                    <?php echo input_tag('vault_keyword', $sf_params->get('vault_keyword'), 'style=width:150px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    </form>
                </div>
                <?php else: ?>
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
                <?php endif ?>
            </section>
        </div>
        <div class="hrsplit-2"></div>
        <div class="box_285">
            <h5 style="margin-bottom: 0px;"><?php echo __('Browse by folder') ?></h5>
            <table class="data-table">
            <?php foreach ($profile->getResumeFolders() as $folder): ?>
            <tr><td><?php echo link_to($folder->getName(), "$route&action=vault&fid={$folder->getId()}") ?></td><td class="txtRight"><?php echo $folder->getResumes(true) ?></td></tr>
            <?php endforeach ?>
            </table>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_Transparent">
            <h3><?php echo __('Browse CV Database') ?></h3>
            <div class="smalltext">
                <?php echo __('You may view any CVs in eMarketTurkey Database by searching or browsing via: %1', array('%1' => '<div class="t_orange frmhelp" title="' . __("CV Database Service, allows you to browse and unlock any CVs you consider as a potential candidate in eMarketTurkey CV Database.\n\n\nYou need to buy credits in order to use this service.") . '">'.__('CV Database Service') . image_tag('layout/icon/led-icons/help.png', 'class=margin-l1') . '</div>')) ?>
                <div class="hrsplit-2"></div>
                <?php echo __('Your Credits: %1', array('%1' => $credits)) ?>
                <?php if ($credits < 10): ?>
                <div class="hrsplit-1"></div>
                <?php echo link_to(__('Buy Credits'), "$route&action=purchase&act=cvdb", 'class=bluelink') ?>
                <?php endif ?>
                <div class="hrsplit-2"></div>
                <?php echo link_to(__('Launch CV Database'), "$route&action=cvdb", 'class=green-button') ?>
            </div>
        </div>
    </div>
    
</div>
<?php echo javascript_tag("
$(function() {
    $('#channel').change(function(){ $(this).closest('form')[0].submit();});
});
") ?>