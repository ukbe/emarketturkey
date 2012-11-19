<?php use_helper('Date') ?>
<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('E-mail Transactions'), 'admin/emailTransactions') ?></li>
<li class="last"><?php echo __('Transaction Details') ?></li>
</ol>
<ol class="column" style="margin: 0px;">
</ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-156 last">
<div class="column span-156">
<h3><?php echo __('E-mail Transaction #%1', array('%1' => $transaction->getId())) ?></h3>
<div class="column span-152 pad-2">
<ol class="column span-152">
<li class="column span-40 right append-2 first"><b><?php echo __('Transaction ID') ?></b></li>
<li class="column span-110"><?php echo $transaction->getId() ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Recipient E-mail') ?></b></li>
<li class="column span-110"><?php echo $transaction->getEmail() ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Recipient Account') ?></b></li>
<li class="column span-110"><?php echo ($transaction->getUser()||$transaction->getCompany())?($usr = $transaction->getUser())?link_to($usr, $usr->getProfileUrl()):link_to($transaction->getCompany(), 'admin/company', array('query_string' => $transaction->getCompany()->getId())) : 'NA'  ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Namespace') ?></b></li>
<li class="column span-110"><?php echo link_to($transaction->getEmailTransactionNamespace()->getName(), 'admin/emailTransactionNs', array('query_string' => 'id='.$transaction->getNamespaceId())) ?>
<br />
<em><?php echo $transaction->getEmailTransactionNamespace()->getDefinition() ?></em></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Status') ?></b></li>
<li class="column span-110"><?php echo EmailTransactionPeer::$statusNames[$transaction->getStatus()] . '&nbsp;&nbsp;' . link_to('[' . ($transaction->getStatus()==EmailTransactionPeer::EML_TR_STAT_DELIVERED ? __('Re-send') : __('Send')) . ']', 'admin/emailTransaction', array('query_string' => 'id='.$transaction->getId().'&act=deliver')) ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Created At') ?></b></li>
<li class="column span-110"><?php echo format_datetime($transaction->getCreatedAt('U')) ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Updated At') ?></b></li>
<li class="column span-110"><?php echo format_datetime($transaction->getUpdatedAt('U')) ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Preferred Language') ?></b></li>
<li class="column span-110"><?php echo format_language($transaction->getPreferredLang()) ?></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Data') ?></b></li>
<li class="column span-110">
<div style="background-color: #f0f0f0; border: solid 1px #c0c0c0;padding: 5px;">
<?php foreach (unserialize($transaction->getClob(EmailTransactionPeer::DATA)) as $key => $datum): ?>
<b><?php echo $key ?></b>: <?php echo $datum ?><br />
<?php endforeach ?></div></li>
<li class="column span-40 right append-2 first"><b><?php echo __('Content') ?></b></li>
<li class="column span-110"><?php echo link_to(__('Click to see mail content'), 'admin/emailTransactionContent', array('query_string' => 'act=template&id='.$transaction->getId(), 'target' => '_blank')) ?></li>
</div>
</div>
</div>