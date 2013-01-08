<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('tradeexperts') ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Find a Trade Expert') ?></h4>
            <?php echo form_tag("@tradeexperts-action?action=results") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('tradeexperts-keyword', __('Search Trade Expert')) ?></dt>
                <dd><?php echo input_tag('tradeexperts-keyword', $sf_params->get('tradeexperts-keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('te_industry', __('Industry'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_tag('te_industry', options_for_select(BusinessSectorPeer::getOrderedNames(), $sf_params->get('te_industry')), array('size' => 5, 'multiple' => 'multiple', 'style' => 'min-width:260px;')) ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('te_country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('te_country', $sf_params->get('te_country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
            </dl>
            </form>
        </div>
        
        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Featured Trade Experts') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($featured_tradeexperts as $tradeexpert): ?>
                <?php include_partial('tradeexpert/tradeexpert', array('tradeexpert' => $tradeexpert)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Featured Trade Experts'), "@tradeexperts-action?action=featured", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Trade Experts in Your Network') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($net_tradeexperts as $tradeexpert): ?>
                <?php include_partial('tradeexpert/tradeexpert', array('tradeexpert' => $tradeexpert)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Trade Experts in My Network'), "@tradeexperts-action?action=connected", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>
    </div>

    <div class="col_180">
    </div>

<?php use_javascript('jquery.customCheckbox.js') ?>
<?php echo javascript_tag("
    $('dl._table input').customInput();
") ?>
    
</div>