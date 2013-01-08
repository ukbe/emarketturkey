<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_657 clear _center">
        <div class="box_657">
            <h4><div class="_right t_orange"><? echo __('Step 2') ?></div>
                <?php echo __('Apply for Trade Experts') ?></h4>
            <div class="pad-3 _noBorder">
            <?php echo form_tag('@tradeexperts-action?action=apply') ?>
            <?php echo input_hidden_tag('step', 2) ?>
            <?php if ($sesuser->isNew()): ?>
            <?php else: ?>
            <?php echo __('Please provide additional information for Trade Experts profile:') ?>
            <div class="hrsplit-3"></div>
            <?php echo form_errors() ?>
            <?php if (isset($error)): ?>
            <div class="t_red"><?php echo __($error) ?></div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('account', __('Selected Account')) ?></dt>
                <dd class="t_larger"><span class="t_green t_bold"><?php echo $account ?></span>&nbsp;&nbsp;<?php echo link_to(__('(change)'), "@tradeexperts-action?action=apply", 'class=inherit-font bluelink hover') ?>
                        <div class="hrsplit-3"></div></dd>
                <dt class="_req"><?php echo emt_label_for('tradeexpert_industries', __('Expertised Areas')) ?></dt>
                <dd><?php echo select_tag('tradeexpert_industries', options_for_select(BusinessSectorPeer::getOrderedNames(true), $sf_params->get('tradeexpert_industries'), array('include_custom' => __('Select Industry'))), array('size' => 8, 'style' => 'width:400px;', 'multiple' => 'multiple')) ?>
                    <em class="ln-example"><?php echo $account->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('Select industries which your company is experienced on.') : __('Select industries which you are experienced on.') ?></em></dd>
                <dt class="_req"><?php echo emt_label_for('tradeexpert_introduction', __('Introduction')) ?></dt>
                <dd><?php echo textarea_tag('tradeexpert_introduction', $sf_params->get('tradeexpert_introduction'), array('style' => 'width: 400px;', 'cols' => 50, 'rows' => 6)) ?>
                    <em class="ln-example"><?php echo __('Describe your trading services clearly.<br /> This information will be displayed to visitors on Trade Experts profile page.') ?></em></dd>
                <dt class="_req"><?php echo emt_label_for('tradeexpert_markets', __('Expertised Markets')) ?></dt>
                <dd><?php echo select_tag('tradeexpert_markets', options_for_select(CountryPeer::getOrderedNames(true), $sf_params->get('tradeexperts_markets'), array('include_custom' => __('Select Country'))), array('size' => 8, 'style' => 'width:400px;', 'multiple' => 'multiple')) ?>
                    <em class="ln-example"><?php echo $account->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('Select target markets which your company is experienced in.') : __('Select target markets which you are experienced in.') ?></em></dd>
            </dl>
            <div class="clear _right">
                <?php echo submit_tag(__('Apply'), 'class=dark-button') ?>
            </div>
            <?php endif ?>
            </form>
            </div>
        </div>

    </div>

</div>
<?php use_javascript('jquery.customCheckbox.js') ?>
<?php use_javascript('emt-location-1.0.js') ?>
<?php echo javascript_tag("
    $('#company_country').location({url: '".url_for('@myemt.location-query')."'});
    
    $('ul.select-step input').customInput();
    
    $('input[name=account]').click(function(){ $(this).closest('li').find('.activate').slideDown('fast'); $(this).closest('li').siblings().find('.activate').slideUp('fast'); });
")?>
