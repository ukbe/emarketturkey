<?php use_helper('Number') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_576" style="margin: 0px 90px;">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4 class="cart-icon">
                    <div class="_right parent actions grey-border"><?php echo link_to_function(__('Actions'), "$('.actions').toggleClass('on');", 'class=t_grey expcoll grey-border') ?>
                    <div class="child grey-border actions">
                        <?php echo link_to(__('Empty Cart'), '@homepage', 'class=nowrap trash') ?>
                        <?php //echo link_to(__('Save Cart'), '@homepage', 'class=nowrap floppy') ?>
                    </div></div>
                    <?php echo __('Your Cart') ?></h4>
                <div class="hrsplit-1"></div>
                <?php $totals = array(); ?>
                <?php $itemcount = 0; ?>
                <table class="cart">
                <?php foreach ($cart as $custyp => $custs): ?>
                    <?php foreach ($custs as $cusid => $items): ?>
                    <tr><th colspan="2"><?php echo __('Items for %1', array('%1' => PrivacyNodeTypePeer::retrieveObject($cusid, $custyp))) ?></th></tr>
                    <?php $subtotals = array(); ?>
                    <?php foreach ($items as $item): ?>
                    <?php $itemcount++; ?>
                    <tr><td>
                        <?php $pack = MarketingPackagePeer::validatePackageFor($item, $custyp) ?>
                        <?php echo $pack->getName() ?></td>
                        <td class="price"><?php $price = $pack->getPriceFor($custyp) ?>
                            <?php if ($price): ?>
                                <?php echo format_currency($price->getPrice(), $price->getCurrency()) ?>
                                <?php if (!isset($subtotals[$price->getCurrency()])) $subtotals[$price->getCurrency()] = 0 ?>
                                <?php if (!isset($totals[$price->getCurrency()])) $totals[$price->getCurrency()] = 0 ?>
                                <?php $subtotals[$price->getCurrency()] += $price->getPrice() ?>
                                <?php $totals[$price->getCurrency()] += $price->getPrice() ?>
                            <?php else: ?>
                            <span class="t_red"><?php echo __('ERROR! No Price. DO NOT CONTINUE!') ?></span>
                            <?php endif ?>
                        </td></tr>
                    <?php endforeach ?>
                    <tr class="subtotal"><td><?php echo __('Sub Total:') ?></td><td class="price">
                        <?php foreach ($subtotals as $curr => $amount): ?>
                        <?php echo format_currency($amount, $curr) ?>
                        <?php endforeach ?></td></tr>
                    <tr class="seperator"><td colspan="2"></td></tr>
                    <?php endforeach ?>
                <?php endforeach ?>
                <?php if ($itemcount > 0): ?>
                    <tr class="total"><td><?php echo __('Total:') ?></td><td class="price">
                        <?php foreach ($totals as $curr => $amount): ?>
                        <?php echo format_currency($amount, $curr) ?>
                        <?php endforeach ?></td></tr>
                <?php else: ?>
                    <tr><td colspan="2"><?php echo __("Your cart is empty.") ?>
                            <div class="hrsplit-2"></div>
                            <?php echo __("You may browse the service packages add items to your cart by clicking the link below.") ?>
                            <div class="hrsplit-2"></div>
                            <?php echo link_to(__('Add Items'), '@add-items', 'class=green-button') ?>
                            </td></tr>
                <?php endif ?>
                </table>
                <?php if ($itemcount > 0): ?>
                <div class="margin-t2 txtRight">
                <?php echo form_tag("@checkout") ?>
                <?php echo input_hidden_tag('step', 'init') ?>
                <?php echo __('%1  or  %2', array('%1' => link_to(__('Add More Items'), '@add-items', 'class=inherit-font hover bluelink'), '%2' => submit_tag(__('Proceed to Check Out'), 'class=green-button'))) ?>
                </form>
                </div>
                <?php endif ?>
            </section>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
        <h3><?php echo __('Secure Check Out') ?></h3>
        <div class="smalltext t_grey">
            <?php echo image_tag('layout/ssl-your-safe.png') ?>
            <?php echo __('You are secured with high-level SSL encryption.') ?>
            <!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode" class="txtLeft"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=medium&amp;seal_color=blue&amp;new=1&amp;newmedium=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code -->
            <div class="hrsplit-3"></div>
            <div class="hrsplit-3"></div>
            <span class="t_smaller"><?php echo __('Privacy Certified by') ?></span>
            <a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_m" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_m.png" alt="TRUSTe online privacy certification"/></a>
        </div>
        </div>
    </div>
    
</div>
<?php use_javascript('emt-'); ?>