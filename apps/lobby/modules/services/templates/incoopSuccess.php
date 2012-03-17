<div class="column span-196 pad-2">
<h1><?php echo __('Investment and Cooperation Directory') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">

<p>
<?php echo __('eMarketTurkey continues its activities in many countries. Many exclusive information services  are offered to our Gold and Premium members. Investment Opportunities and Partnerships Directory  is a service tool that offering special deals to members about investment opportunities, tax exemptions and grants in different countries.  Addtionally Gold and Premium members also share among themselves is that they want to allow very specific opportunities.') ?>
</p>


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