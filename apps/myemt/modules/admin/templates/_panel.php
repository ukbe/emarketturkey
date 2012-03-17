<div class="column span-142">
<div class="column span-90">
<?php $member_num = UserPeer::countRecentMembers($sf_user->getUser()->getLastLoginDate());
echo format_number_choice('[0]No new users.|[1]<b>1 new member.</b>|(1,+Inf]<b>%1 new members.</b>', 
                 array('%1' => $member_num), $member_num) ?>
</div>
<div class="column span-51 prepend-1">
<ol id="actions">
<li><?php echo link_to(__('E-mail Transactions'), 'admin/emailTransactions') ?></li>
<li><?php echo link_to(__('Customer Messages'), 'admin/messages') ?></li>
<li><?php echo link_to(__('Manage Users'), 'admin/users') ?></li>
</ol>
</div>
</div>
