<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<?php include_partial('company/company_pagetop', array('map' => array(__('Manage Company') => '@company-manage',
                                                                      __('Products') => 'products/list', 
                                                                      __('Photos') => null)
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenu') ?>
<?php end_slot() ?>