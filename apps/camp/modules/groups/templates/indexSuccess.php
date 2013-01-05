<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('groups') ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Find a Group') ?></h4>
            <?php echo form_tag("@search-groups", 'method=get') ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('keyword', __('Search')) ?></dt>
                <dd><?php echo input_tag('keyword', $sf_params->get('keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('country', $sf_params->get('country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('grouptype', __('Group Type'))?></dt>
                <dd class="adv-switch ghost two_columns">
                    <?php $gtypes = $sf_params->get('gtype[]', array()) ?>
                    <?php foreach (GroupTypePeer::getOrderedNames() as $gtyp): ?>
                    <?php echo checkbox_tag('gtype[]', $gtyp->getId(), in_array($gtyp->getId(), $gtypes) === true, "id=gtype_{$gtyp->getId()}") ?>
                    <?php echo emt_label_for("gtype_{$gtyp->getId()}", $gtyp, 'class=checkbox-label') ?>
                    <?php endforeach ?>
                    </dd>
            </dl>
            </form>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Featured Groups') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($featured_groups as $group): ?>
                <?php include_partial('groups/group', array('group' => $group)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Featured Groups'), "@groups-action?action=featured", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Groups in Your Network') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($net_groups as $group): ?>
                <?php include_partial('groups/group', array('group' => $group)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Groups in My Network'), "@groups-action?action=connected", 'class=clear inherit-font hover bluelink margin-t1') ?>
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