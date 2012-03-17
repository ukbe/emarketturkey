<div class="column span-196 pad-2">
<h1><?php echo __('emTrust') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">
<p>
<?php echo __('eMarketTurkey visits member companines  (headquaters , manufacturing areas, branch office etc.) every year and confirms that the information accurately entered into the system by members.  So that a product, material or any services who request the opportunity, in this point we  create a safer trade must have.') ?>
</p> 	
<p>
<h3> 
<?php echo __('What is emTrust Certificate?') ?> </h3> 

<?php echo __('All of the information in eMarketTurkey.com has been approved by company officials, <br /> The firm is residing at the address specified in eMarketTurkey,<br /> Confirms that launching the products and services produced, manufactured or supplied by member <br /> Company authorized by The government agency  (Accuracy of the Certificate of Authorization) <br /> The fact that the company is certified (ISO, Financial Appraisal Report)') ?>
</div>
<div class="column span-49 pad-2 divbox">
<h2><?php echo __('Start using!') ?></h2>
<ol class="column span-48 pad-1">
<li class="column span-48">
<?php echo link_to(__('Register your company, if you have not done yet.'), '@signup', array('query_string' => 'keepon='.url_for('@myemt.register-comp'))) ?></li>
<li class="column span-48">
<?php echo link_to(__('Publish your products, if you have already registered your company.'), '@myemt.manage-products') ?></li>
</ol> 
</div>
</div>