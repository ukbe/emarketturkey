<div class="column span-196 pad-2">
<h1><?php echo __('Embedded HR Interface') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">

<p>
Çağımızın zorunlu kıldığı  iş bölümü ve uzmanlaşma neticesinde İnsan Kaynakları yönetimi başlıbaşına bir iş sürecinin takibini gerektirmektedir. eMarketTurkey, İK alanında  kurumları büyük bir iş yükünden kurtarmaktadır. Firmalar web sitelerinde yapacakları küçük bir eklentiyle  eMarketTurkey'in Gömülü İK arayüzünü kullanabilmekte, güncel bilgiye zamandan ve paradan tasarruf ederek ulaşabilmektedirler. 
</p><P>
<B>Gömülü İK Arayüzü ne avantaj sağlıyor ? </B>
</p><P>
<ol>
<li>Şirketlerin güncel cvlere ulaşması, doğru adayların belirlenmesi ve adayların değerlendirilmesi gibi  bir çok İK ihtiyacını karşılamaktadır, </li>
<li>Adayların CV girişleri istenilen bir düzende toplanmasını sağlamakta, </li>
<li>eMarketTurkey'de CV'si mevcut olan bir adayın üye firmaya bir kaç saniye içersinde başvuru yapması mümkün kılmakta, böylece adayların firmalarla daha rahat iletişim kurması sağlanmaktadır, </li> 
<li>Şirkete yapılan tüm başvurular bir portföyde toplanmakta ve istenildiği zaman geriye dönük inceleme imkanı sunulmaktadır,  </li>
<li>Zamanla ortaya çıkabilecek genel ihtiyaçları eMarketTurkey, firmalar için gidermekte, özel istekleri her zaman göz önünde tutmaktadır... </li>
</ol>
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