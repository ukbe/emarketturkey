<?php use_helper('EmtAjaxTable', 'Object', 'Number', 'DateForm') ?>
<?php slot('pagetop') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/company_pagetop', array('company' => $owner)) ?> 
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/group_pagetop', array('group' => $owner)) ?> 
<?php endif ?>
<?php end_slot() ?>
<?php slot('pageheader', __('Post Job')) ?>
<?php slot('pageactions', link_to(__('Cancel'), "@company-jobs-action?action=home&hash=$own", 'class=cancel-13px')) ?>
<?php slot('leftcolumn') ?>
<?php include_partial('company/leftmenu', array('company' => $owner)) ?>
<?php end_slot() ?>
<div class="pad-1">
<div class="blockfield">
<div class="section">
<h2><span class="circle green">3</span><?php echo __('Select Additional Services') ?></h2>
<div class="hrsplit-1"></div>
<?php echo form_tag("@company-jobs-action?action=addServices&hash=$own&job={$job->getGuid()}") ?>
    <ol class="ls-select-service clear">
        <li class="ls-service">
            <?php echo radiobutton_tag('upgrade_listing', 'none', true, 'id=option_1 class=ls-selector styled') ?>
            <?php echo emt_label_for('option_1', __('No Thanks')) ?>
        </li>
        <?php $srv_spot = $services[ServicePeer::STYP_JOB_SPOT_LISTING] ?>
        <?php $pkg_spot = $srv_spot->getActive() ? $srv_spot->getBasePackage(1) : null ?>
        <?php if ($pkg_spot && $pkg_spot->getActive()): ?>
        <li class="ls-service clear">
            <?php echo radiobutton_tag('upgrade_listing', 'spot', false, 'id=option_2 class=ls-selector') ?>
            <?php echo link_to_function(__('more info'), '', 'class=ls-moreinfo-link') ?>
            <?php echo emt_label_for('option_2', __("Upgrade to %1 for only %2<em class='tip'>*</em> per day", array('%1' => $srv_spot->getName(), '%2' => format_currency($pkg_spot->getPriceFor($owner)->getPrice(), $pkg_spot->getPriceFor($owner)->getCurrency())))) ?>
            <div class="ls-moreinfo-block">
                <?php echo image_tag('layout/background/jobs/job-upgrade-spot-listing.png', 'class=ls-visual') ?>
                <div class="ls-slogan">
                <?php echo __('Unveil your corporate identity via Spot Listing') ?><br />
                </div>
                <?php echo __('Spot Listing allows companies have their jobs listed on eMarketTurkey Career homepage.') ?>
            </div>
            <div class="ls-form ghost">
                <table border="0" width="100%"><tr>
                    <td><?php echo emt_label_for('select_spot_days', __('Please select the number of days to go ')) ?></span>
                        <?php $days = array('0' => 'select'); for ($i=1; $i <31; $i++) $days[$i] = $i; ?>
                        <?php echo select_tag('select_spot_days', 
                                        options_for_select($days),
                                                    array('onchange' => "jQuery(this).closest('tr').find('span.total').html(jQuery(this).val()*jQuery(this).closest('tr').find('span.price').text());jQuery(this).closest('tr').find('span.quantity').html(jQuery(this).val());")) ?></td>
                    <td align="right" class="calc"><span class="price"><?php echo $pkg_spot->getPriceFor($owner)->getPrice() ?></span><?php echo $pkg_spot->getPriceFor($owner)->getCurrency() ?>&nbsp;x<span class="quantity">0</span><?php echo __('days') ?>&nbsp;=<span class="total">0</span><?php echo $pkg_spot->getPriceFor($owner)->getCurrency() ?>&nbsp;Total</td>
                    </tr></table>
            </div>
        <?php endif ?></li>
        <?php $srv_platinum = $services[ServicePeer::STYP_JOB_PLATINUM_LISTING] ?>
        <?php $pkg_platinum = $srv_platinum->getActive() ? $srv_platinum->getBasePackage(1) : null ?>
        <?php if ($pkg_platinum && $pkg_platinum->getActive()): ?>
        <li class="ls-service clear">
            <?php echo radiobutton_tag('upgrade_listing', 'platinum', false, 'id=option_3 class=ls-selector') ?>
            <?php echo link_to_function(__('more info'), '', 'class=ls-moreinfo-link') ?>
            <?php echo emt_label_for('option_3', __("Upgrade to %1 for only %2<em class='tip'>*</em> per day", array('%1' => $srv_platinum->getName(), '%2' => format_currency($pkg_platinum->getPriceFor($owner)->getPrice(), $pkg_platinum->getPriceFor($owner)->getCurrency())))) ?>
            <div class="ls-moreinfo-block">
                <?php echo image_tag('layout/background/jobs/job-upgrade-spot-listing.png', 'class=ls-visual') ?>
                <div class="ls-slogan">
                <?php echo __('Give your company what it deserves by upgrading to Platinum Listing') ?><br />
                </div>
                <?php echo __('Sure, your company deserves the ultimate turn back of a prestigous representation of job listings. This way, your company will also be showing up in good shape.') ?>
            </div>
            <div class="ls-form ghost">
                <table border="0" width="100%"><tr>
                    <td><?php echo emt_label_for('select_platinum_days', __('Please select the number of days to go ')) ?></span>
                        <?php $days = array('0' => 'select'); for ($i=1; $i <31; $i++) $days[$i] = $i; ?>
                        <?php echo select_tag('select_platinum_days', 
                                        options_for_select($days),
                                                    array('onchange' => "jQuery(this).closest('tr').find('span.total').html(jQuery(this).val()*jQuery(this).closest('tr').find('span.price').text());jQuery(this).closest('tr').find('span.quantity').html(jQuery(this).val());")) ?></td>
                    <td align="right" class="calc"><span class="price"><?php echo $pkg_platinum->getPriceFor($owner)->getPrice() ?></span><?php echo $pkg_platinum->getPriceFor($owner)->getCurrency() ?>&nbsp;x<span class="quantity">0</span><?php echo __('days') ?>&nbsp;=<span class="total">0</span><?php echo $pkg_platinum->getPriceFor($owner)->getCurrency() ?>&nbsp;Total</td>
                    </tr></table>
            </div>
        <?php endif ?></li>
    </ol>
    <div><em class="tip"><?php echo __('* VAT included') ?></em></div>
    <div class="center-block right"><?php echo submit_tag(__('Continue'), 'class=green-button') ?></div>
</form>
</div>
</div>
</div>
<?php echo javascript_tag("
jQuery.fn.selectOption = function(){
    var o = jQuery(this[0]);
    jQuery.extend(o, {options: o.find('li.ls-service'), selected: jQuery.inArray(o.find('input.ls-selector:checked').closest('.ls-service'), o.options),
        broadcastCN : function(bl) {},
        setupBlock: function(li){
            li = jQuery(li);
            jQuery.extend(li, {index: '', selector: li.find('input.ls-selector'), value: this.selector.value, moreinfolink: li.find('.ls-moreinfo-link'), moreinfoblock: li.find('.ls-moreinfo-block'), formblock: li.find('.ls-form'), visual: li.find('.ls-visual'), 
            });
            li.moreinfolink.click(function(){
                li.toggleClass('expend');
            });
            li.selector.click(function(){
                o.options[o.selected].find('.ls-hide').show();
                o.options[o.selected].moreinfoblock.addClass('ghost');
                o.options[o.selected].formblock.addClass('ghost');
                o.options[o.selected].removeClass('highlight');
                jQuery(li).find('.ls-hide').hide();
                li.formblock.removeClass('ghost');
                o.selected = jQuery.inArray(li, o.options);
                o.options[o.selected].addClass('highlight');
            });
            if (jQuery.inArray(li, o.options) < 0) o.options.push(li);
            li.index = jQuery.inArray(li, o.options);
            if (o.find('.ls-selector:checked').val() == li.selector.val()) {o.selected = li.index;li.addClass('highlight')}
        }
    });
    o.options.each(function(i,k){o.setupBlock(k)});
}
jQuery('ol.ls-select-service').selectOption();
") ?>