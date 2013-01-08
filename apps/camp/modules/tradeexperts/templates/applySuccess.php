<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_657 clear _center">
        <div class="box_657">
            <h4><div class="_right t_orange"><? echo __('Step 1') ?></div>
            <?php echo __('Apply for Trade Experts') ?></h4>
            <div class="pad-3 _noBorder">
            <?php echo form_tag('@tradeexperts-action?action=apply') ?>
            <?php echo input_hidden_tag('step', 1) ?>
            <?php echo $sf_request->hasError('account') ? form_errors() : '' ?>
            <?php if ($sesuser->isNew()): ?>
            <?php else: ?>
            <?php echo __('Please select the account you want to use while applying for Trade Experts:') ?>
            <ul class="select-step">
            <?php foreach ($accounts as $acc):?>
            <?php $tx = TradeExpertPeer::retrieveAccountFor(array(TradeExpertPeer::TX_STAT_APPROVED, TradeExpertPeer::TX_STAT_PENDING, TradeExpertPeer::TX_STAT_SUSPENDED), $acc) ?>
            <li<?php echo $tx ? ' class="disabled"' : ''?>>
                <?php echo emt_label_for("account_{$acc->getPlug()}", $acc) ?>
                <?php if ($tx): ?>
                    <?php echo radiobutton_tag('account', $acc->getPlug(), $sf_params->get('account') == $acc->getPlug(), "id=account_{$acc->getPlug()} disabled=disabled")  ?>
                    <p><?php echo __('There is an existing Trade Expert account associated with this account.') ?><br />
                    <?php if ($tx->getStatus() == TradeExpertPeer::TX_STAT_APPROVED): ?>
                    <?php echo __('Follow %1 to configure this Trade Expert account.', array('%1' => link_to(__('<span class="followthis">this link</span>'), "@myemt.manage-trade-expert?hash={$acc->getPlug()}", 'class=inherit-font bluelink hover'))) ?>
                    <?php endif ?>
                    </p>
                <?php else:?>
                    <?php echo radiobutton_tag('account', $acc->getPlug(), $sf_params->get('account') == $acc->getPlug(), "id=account_{$acc->getPlug()}")  ?>
                    <?php if ($acc instanceof User): ?>
                    <p><?php echo __('Select this if you would like to apply for an individual Trade Experts account.') ?><br />
                    <em class="t_grey"><?php echo __('This way you will be listed as Trade Expert(Professional).') ?></em></p>
                    <?php else: ?>
                    <p><?php echo __('Select this if you would like to apply for a corporate Trade Experts account.') ?><br />
                    <em class="t_grey"><?php echo __('If accepted, your company will be listed as Trade Expert(Corporation).') ?></em></p>
                    <?php endif ?>
                <?php endif ?>
                </li>
            <?php endforeach ?>
                <li><?php echo radiobutton_tag('account', 'new_company', $sf_params->get('account') == 'new_company', 'id=account_new_company') ?>
                    <?php echo emt_label_for('account_new_company', __('Register a new Company for Trade Experts')) ?>
                    <div class="activate <?php echo $sf_params->get('account') == 'new_company' ? '' : 'ghost' ?>">
                        <?php echo $sf_request->hasError('account') ? '' : form_errors() ?>
                        <dl class="_table">
                            <dt><?php echo emt_label_for('company_name', __('Company Name')) ?></dt>
                            <dd><?php echo input_tag('company_name', $sf_params->get('company_name')) ?></dd>
                            <dt><?php echo emt_label_for('company_industry', __('Industry')) ?></dt>
                            <dd><?php echo select_tag('company_industry', options_for_select(BusinessSectorPeer::getOrderedNames(true), $sf_params->get('company_industry'), array('include_custom' => __('Select Industry')))) ?></dd>
                            <dt><?php echo emt_label_for('company_business_type', __('Business Type')) ?></dt>
                            <dd><?php echo select_tag('company_business_type', options_for_select(BusinessTypePeer::getOrderedNames(true), $sf_params->get('company_business_type'), array('include_custom' => __('Select Business Type')))) ?></dd>
                            <dt><?php echo emt_label_for('company_introduction', __('Introduction')) ?></dt>
                            <dd><?php echo textarea_tag('company_introduction', $sf_params->get('company_introduction'), array('cols' => 40, 'rows' => 4)) ?></dd>
                            <dt><?php echo emt_label_for('company_products', __('Products and Services')) ?></dt>
                            <dd><?php echo textarea_tag('company_products', $sf_params->get('company_products'), array('cols' => 40, 'rows' => 4)) ?></dd>
                            <dt><?php echo emt_label_for('company_country', __('Country')) ?></dt>
                            <dd><?php echo select_tag('company_country', options_for_select(CountryPeer::getOrderedNames(true), $sf_params->get('company_country'), array('include_custom' => __('Select Country')))) ?></dd>
                            <dt><?php echo emt_label_for('company_street', __('Street Address')) ?></dt>
                            <dd><?php echo input_tag('company_street', $sf_params->get('company_street'), 'maxlength=250 style=width:300px;') ?></dd>
                            <dt><?php echo emt_label_for('company_state', __('State/Province')) ?></dt>
                            <dd><?php echo select_tag('company_state', options_for_select($states, $sf_params->get('company_state'), array('include_custom' => __('Select State/Province')))) ?></dd>
                            <dt><?php echo emt_label_for('company_city', __('City/Town')) ?></dt>
                            <dd class="floattail"><?php echo input_tag('company_city', $sf_params->get('company_city'), 'maxlength=50 style=width:200px;') ?></dd>
                            <dt class="floattail"><?php echo emt_label_for('company_postalcode', __('ZIP/Postal Code')) ?></dt>
                            <dd class="floattail"><?php echo input_tag('company_postalcode', $sf_params->get('company_postalcode'), 'maxlength=20 style=width:70px;') ?></dd>
                            <dt><?php echo emt_label_for('company_phone', __('Phone')) ?></dt>
                            <dd><?php echo input_tag('company_phone', $sf_params->get('company_phone'), 'maxlength=30 style=width:150px;') ?></dd>
                        </dl>
                        <div class="clear"></div>
                    </div>
                    </li>
            </ul>
            <div class="clear _right">
                <?php echo submit_tag(__('Continue'), 'class=dark-button') ?>
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
