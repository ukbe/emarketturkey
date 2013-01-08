<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('leads', array('type_code' => $type_code, 'type_id' => $type_id)) ?>

    </div>
    
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo $type_id==B2bLeadPeer::B2B_LEAD_BUYING ? __('Search Buying Leads') : __('Search Selling Leads') ?></h4>
            <?php echo form_tag("@leads-action?action=results&type_code=$type_code") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('lead-keyword', __('Search Lead')) ?></dt>
                <dd><?php echo input_tag('lead-keyword', $sf_params->get('lead-keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('category', __('Category'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_tag('category', options_for_select(ProductCategoryPeer::getBaseCategories(), $sf_params->get('category')), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('country', $sf_params->get('country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
            </dl>
            </form>
        </div>
        
        <div class="box_285">
            <h5 class="margin-0"><?php echo $type_id == B2bLeadPeer::B2B_LEAD_BUYING ? __('Latest Buying Leads') : __('Latest Selling Leads') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($latest as $lead): ?>
                <?php include_partial('lead/lead', array('lead' => $lead)) ?>
                <?php endforeach ?>
                <?php echo link_to($type_id==B2bLeadPeer::B2B_LEAD_BUYING ? __('List all Latest Leads') : __('List  All Selling Leads'), "@leads-action?action=latest&type_code=$type_code", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo $type_id == B2bLeadPeer::B2B_LEAD_BUYING ? __('Buying Leads from Your Network') : __('Selling Leads from Your Network') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($network_leads as $lead): ?>
                <?php include_partial('lead/lead', array('lead' => $lead)) ?>
                <?php endforeach ?>
                <?php echo link_to($type_id==B2bLeadPeer::B2B_LEAD_BUYING ? __('List all Buying Leads from My Network') : __('List all Selling Leads from My Network'), "@leads-action?action=network&type_code=$type_code", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>
        
    </div>

    <div class="col_180">
    </div>

</div>