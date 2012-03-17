<?php slot('pagetop') ?>
<?php include_partial('company/company_pagetop', array('company' => $company,
                                                       'map' => array(__('Manage Company') => "@company-manage?hash={$company->getHash()}",
                                                                      __('Media') => null)
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('company/leftmenuMedia', array('company' => $company)) ?>
<?php end_slot() ?>
<div class="column span-107 append-1 divbox">
<div class="inside">
</div>
</div>