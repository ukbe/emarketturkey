<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('companies') ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Find a Company') ?></h4>
            <?php echo form_tag("@companies-action?action=results") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('company-keyword', __('Search Company')) ?></dt>
                <dd><?php echo input_tag('company-keyword', $sf_params->get('company-keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('industry', __('Industry'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_tag('industry', options_for_select(BusinessSectorPeer::getOrderedNames(), $sf_params->get('industry')), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('country', $sf_params->get('country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('busstype', __('Business Type'))?></dt>
                <dd class="adv-switch ghost two_columns" style="width: 300px">
                    <?php $btypes = $sf_params->get('btype', array()) ?>
                    <?php foreach (BusinessTypePeer::getOrderedNames() as $btyp): ?>
                    <?php echo checkbox_tag('btype[]', $btyp->getId(), in_array($btyp->getId(), $btypes) === true, "id=btype_{$btyp->getId()}") ?>
                    <?php echo emt_label_for("btype_{$btyp->getId()}", $btyp, 'class=checkbox-label') ?>
                    <?php endforeach ?>
                    </dd>
            </dl>
            </form>
        </div>
        
        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Featured Companies') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($featured_companies as $company): ?>
                <?php include_partial('company/company', array('company' => $company)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Featured Companies'), "@companies-action?action=featured", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Companies in Your Network') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($net_companies as $company): ?>
                <?php include_partial('company/company', array('company' => $company)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Companies in My Network'), "@companies-action?action=connected", 'class=clear inherit-font hover bluelink margin-t1') ?>
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