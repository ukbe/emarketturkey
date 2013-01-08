<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>

<div class="hrsplit-1"></div>

    <div class="col_180">
<?php include_partial('leftmenu', array('company' => $company))?>
    </div>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576">
                <h4><?php echo __("Company's Connections") ?></h4>
                <div class="_noBorder">
                    <span class="btn_container _right" style="position: relative; right: auto; top: auto;">
                        <?php echo link_to(__('Partner Companies'), $company->getProfileActionUrl('connections'), array('query_string' => 'relation=partner', 'class' => $role_name=='partner' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Groups'), $company->getProfileActionUrl('connections'), array('query_string' => 'relation=group', 'class' => $role_name=='group' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Followers'), $company->getProfileActionUrl('connections'), array('query_string' => 'relation=follower', 'class' => $role_name=='follower' ? 'ui-state-selected' : ''))?>
                    </span>
                    <div class="hrsplit-1"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="clear">
                        <?php include_partial("layout_extended_$partial_name", array('pager' => $pager)) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                
                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if ($own_company): ?>
            <?php include_partial('owner_actions', array('company' => $company)) ?>
            <?php else: ?>
            <?php include_partial('connect_box', array('company' => $company, 'nums' => $nums)) ?>
            <?php endif ?>
            
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $company)) ?>
                </div>
            </div>

        </div>

    </div>


</div>