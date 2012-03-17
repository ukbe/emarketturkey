<div class="col_948">
    <div class="col_180">

<?php include_partial('venues') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Find a Venue Show') ?></h4>
            <?php echo form_tag("@venues-action?action=results") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('venue-keyword', __('Search Venue')) ?></dt>
                <dd><?php echo input_tag('venue-keyword', $sf_params->get('venue-keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('placetype', __('Venue Type'))?></dt>
                <dd class="adv-switch ghost two_columns" style="width: 300px">
                    <?php $vtypes = $sf_params->get('placetype', array()) ?>
                    <?php foreach (PlaceTypePeer::getOrderedNames(PlaceTypePeer::$bussTypes) as $vtyp): ?>
                    <?php echo checkbox_tag('placetype[]', $vtyp->getId(), in_array($vtyp->getId(), $vtypes) === true, "placetype_{$vtyp->getId()}") ?>
                    <?php echo emt_label_for("placetype_{$vtyp->getId()}", $vtyp, 'class=checkbox-label') ?>
                    <?php endforeach ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('country', $sf_params->get('country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
            </dl>
            </form>
        </div>
        
        <div class="box_576">
            <h5 class="margin-0"><?php echo __('Featured Venues') ?></h5>
            <div class="_noBorder">
                <?php include_partial('layout_extended', array('results' => $featured_venues)) ?>
                <?php echo link_to(__('List all Featured Venues'), "@venues-action?action=featured", 'class=clear inherit-font hover bluelink margin-t1') ?>
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