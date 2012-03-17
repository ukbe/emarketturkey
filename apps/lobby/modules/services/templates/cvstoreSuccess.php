<div class="column span-196 pad-2">
<h1><?php echo __('CV Store') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">

<p>
Her şirket kendine has yapısı itibariyle farklı insan kaynakları gücüne ihtiyaç duymakta ve  personel yapısını genellikle özel kriterlere göre belirlemektedir. eMarketTurkey güncel ve zengin cv veritabanını kurumların hizmetine açmakta, böylece firmaların personel istihdamında etkili ve doğru kararlar almasına yardımcı olmaktadır. Niceliksel ve niteliksel olarak çok fazla insan gücüne ihtiyaç duyuyorsanız eMarketTurkey İnsan Kaynakları ile;
</p>
<ol>
<li>Aradığınız doğru adaylara ulaşın,</li>
<li>Zaman, emek ve paradan tasarruf edin,</li> 
<li>Tüm CV´leri aynı formatta takip edin,</li>
<li>Potansiyel adayları gruplara ayırarak veya işaretleyerek ihtiyaç olduğu an hızlı bir şekilde üzerinde çalışabileceğiniz bir İK platformuna sahip olun. </li>
</ol>


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