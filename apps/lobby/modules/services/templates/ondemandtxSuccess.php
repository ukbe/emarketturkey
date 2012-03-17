<div class="column span-196 pad-2">
<h1><?php echo __('On-Demand Translation') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">

<p>
eMarketTurkey genel tercüme hizmetleri ile her türlü çeviri internet üzerinden gerçekleştirilmekte
ve tüm süreçler online olarak takip edilebilmektedir.
Tercüme başvurusu yapıldığında çeviri ücreti eMarketTurkey tarafından otomatik 
olarak hesaplanmakta,  üyelerimiz ödemelerini kredi kartı, havale veya adrese teslim edildiği 
anda gerçekleştirebilmektediler.</p>
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