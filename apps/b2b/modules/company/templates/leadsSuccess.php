<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>
    <div class="hrsplit-1"></div>
    <div class="col_180">

<?php include_partial('leftmenu', array('company' => $company))?>

        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Try Buyer Tools') ?></h3>
            <div>
            </div>
        </div>

    </div>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576">
                <h4><?php echo $type_id ? __(B2bLeadPeer::$typeNames[$type_id]) : __('Trade Leads') ?></h4>
                <div class="_noBorder">
                    <span class="btn_container _right" style="position: relative; right: auto; top: auto;">
                        <?php echo link_to(__('All'), $company->getProfileActionUrl('leads'), array('class' => !$type ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Buying Leads'), $company->getProfileActionUrl('leads'), array('query_string' => 'type=buying', 'class' => $type=='buying' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Selling Leads'), $company->getProfileActionUrl('leads'), array('query_string' => 'type=selling', 'class' => $type=='selling' ? 'ui-state-selected' : ''))?>
                    </span>
                    <div class="hrsplit-1"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="clear">
                        <?php include_partial("layout_extended_lead", array('pager' => $pager)) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</div>