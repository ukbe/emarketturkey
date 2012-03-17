<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map' => array(__('MyEMT') => '@homepage', 
                                                                   __('Network') => '@cm.network',
                                                                   __('Request Sent') => null)
                                                   )) ?> 
<?php end_slot() ?>
<div class="column dialog">
<ol class="column span-102">
<li class="column span-100 pad-1"><h2><?php echo __('Request was successfuly sent.') ?></h2></li>
<li class="column span-100"><?php echo __("Your request was sent to %1%", array('%1%' => $contact)) ?></li>
</ol>
</div>