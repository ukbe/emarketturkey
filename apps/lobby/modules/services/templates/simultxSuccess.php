<div class="column span-196 pad-2">
<h1><?php echo __('Simultane Translator Directory') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">
<p>
Simültane tercüme, özel eğitimli tercümanlar tarafından verilen eş zamanlı çeviri hizmetidir.  Simültane çeviri oldukça zorlu ve yorucu bir işlemdir. Dil bilgisi ne kadar iyi olursa olsun, her çevirmen simültane çeviri hizmeti veremez. Bunu yapabilmesi için gerekli simültane çeviri eğitimine, deneyime ve çalışma disiplinine ihtiyacı vardır.
</p><p>
eMarketTurkey özel sektör kuruluşlarına, ulusal ve uluslararası ticaret ve sanayi örgütlerine ve kamuya simültane çeviri hizmeti verebilecek şahıs ve firmalar hakkında detaylı bilgileri paylaşmaktadır.
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