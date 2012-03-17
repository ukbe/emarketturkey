<?php use_helper('Cryptographp') ?>
<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('about_menu') ?>
<?php end_slot() ?>
<div class="column span-110 pad-2">
<h2><?php echo __('Contact Us') ?></h2>
<p><?php echo __('Please do not hessitate to contact us on any subject.') ?></p>
<br />
<h3><?php echo __('Postal Address:') ?></h3>
<p><?php echo __('EMTPORT Bilgi Teknolojileri A.Ş.') ?></p>
<p><?php echo __('Mansuroğlu Mah. Cumhuriyet Cad. No:15/1<br />Bayraklı 35040 Izmir<br />TURKEY') ?></p>
<br />
<h3><?php echo __('E-mail:') ?></h3>
<p>info@emarketturkey.com</p>
<div class="hrsplit-3"></div>
<?php if (isset($successtext)): ?>
<p style="color: #006600"><b><?php echo __($successtext) ?></b></p>

<?php else: ?>
<?php echo __('You may send us your message using the contact form below.') ?>
<br />

<?php if (isset($errortext)): ?>
<p style="color: #660000"><b><?php echo __($errortext) ?></b></p>
<?php endif ?>

<?php if (form_errors()): ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php endif ?>

<?php echo form_tag('corporate/contactus') ?>
<ol class="column span-55" style="padding: 0px;">
<li class="column span-55"><?php echo emt_label_for('topic_id', __('Topic :')) ?></li>
<li class="column span-55"><?php echo select_tag('topic_id', options_for_select($subject_list, $sf_params->get('topic_id'))) ?></li>
<li class="column span-55"><?php echo emt_label_for('sender_name', __('Your Name and Lastname :')) ?></li>
<li class="column span-55"><?php echo input_tag('sender_name', $sf_params->get('sender_name'), 'size=45') ?></li>
<li class="column span-55"><?php echo emt_label_for('sender_email', __('Your E-mail Address :')) ?></li>
<li class="column span-55"><?php echo input_tag('sender_email', $sf_params->get('sender_email'), 'size=45') ?></li>
<li class="column span-55"><?php echo emt_label_for('message_text', __('Your Message :')) ?></li>
<li class="column span-55"><?php echo textarea_tag('message_text', $sf_params->get('message_text'), 'cols=50 rows=4') ?></li>
<?php if (!$user): ?>
<li class="column span-55"><?php echo cryptographp_picture(); ?>&nbsp;
<?php echo cryptographp_reload(); ?></li>
<li class="column span-55"><?php echo emt_label_for('verify_code', __('Please type the verification code seen above:')) ?></li>
<li class="column span-55"><?php echo input_tag('verify_code', '') ?></li>
<?php endif ?>
<li class="column span-55"><?php echo submit_tag(__('Send Message')) ?></li>
</ol>
<?php endif ?>
</div>