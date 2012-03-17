<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map' => array(__('My Profile') => $sesuser->getProfileUrl(), 
                                                                   __('Network Activity') => null)
                                                   )) ?> 
<?php end_slot() ?>
<div class="network-panel">
<?php include_partial('network/network_activity', array('activities' => $activities)) ?>
</div>
<?php slot('rightcolumn') ?>
<div class="network-menu">
<ol>
<li class="active"><?php echo link_to(__('Network Activity'), '@network-activity') ?></li>
<li><?php echo link_to(__('My Network'), '@network') ?></li>
<li><?php echo link_to($sf_user->getUser()->getRequestCount()?__('Requests').'('.$sf_user->getUser()->getRequestCount().')':__('Requests'), '@requests') ?></li>
</ol>
</div>
<?php end_slot() ?>