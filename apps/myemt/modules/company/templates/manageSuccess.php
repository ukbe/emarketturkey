<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180 _titleBG_Green">
            <h3><?php echo __('Quick Links') ?></h3>
            <div>
                <ul class="_linksVertical" style="padding: 0px;">
                    <li><?php echo link_to(__('Add New Product'), "@add-product?hash={$company->getHash()}") ?></li>
                    <li><?php echo link_to(__('Post Selling/Buying Lead'), "@post-lead?hash={$company->getHash()}") ?></li>
                    <li><?php echo link_to(__('Post New Job'), "@company-jobs-action?action=post&hash={$company->getHash()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?></li>
                    <li><?php echo link_to(__('Create Event'), "@company-events-action?action=add&hash={$company->getHash()}") ?></li>
                </ul>
            </div>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent" style="background-color: #f0effb;">
            <h3 style="background-color: #f0effb;"><?php echo __("Share what's new about your company") ?></h3>
            <div style="background-color: #f0effb;">
            <?php echo textarea_tag('post-update', '', 'style="margin: 0 auto;width: 97%;"') ?>
            fdgfdgs
            </div>
        </div>

        <div class="box_576 _noTitle">
            
            <div id="chart_div">
            <?php /* ?>
            <h3><?php echo __('Product Views') ?></h3>
                <table width="100%">
                    <tr><td></td>
                        <td></td>
                        <td><?php echo __('Views') ?></td>
                        <td><?php echo __('Change') ?></td></tr>
                <?php foreach ($tmpproducts as $product): ?>
                    <tr><td><?php echo image_tag($product->getThumbUri(), 'width=15') ?></td>
                        <td><?php echo link_to($product->getName(), $product->getEditUrl()) ?></td>
                        <td><?php echo rand(1, 50) ?></td>
                        <td><?php echo rand(1, 100) ?>%</td></tr>
                <?php endforeach ?>
                </table>
*/?>
            </div>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Views');
        data.addColumn('number', 'Visitors');
        data.addRows(10);
        data.setValue(0, 0, 'Oca');
        data.setValue(0, 1, 1000);
        data.setValue(0, 2, 400);
        data.setValue(1, 0, 'Şub');
        data.setValue(1, 1, 1170);
        data.setValue(1, 2, 460);
        data.setValue(2, 0, 'Mar');
        data.setValue(2, 1, 860);
        data.setValue(2, 2, 580);
        data.setValue(3, 0, 'Nis');
        data.setValue(3, 1, 1030);
        data.setValue(3, 2, 540);
        data.setValue(4, 0, 'May');
        data.setValue(4, 1, 1030);
        data.setValue(4, 2, 730);
        data.setValue(5, 0, 'Haz');
        data.setValue(5, 1, 1050);
        data.setValue(5, 2, 650);
        data.setValue(6, 0, 'Tem');
        data.setValue(6, 1, 1060);
        data.setValue(6, 2, 690);
        data.setValue(7, 0, 'Ağu');
        data.setValue(7, 1, 990);
        data.setValue(7, 2, 620);
        data.setValue(8, 0, 'Eyl');
        data.setValue(8, 1, 1150);
        data.setValue(8, 2, 650);
        data.setValue(9, 0, 'Eki');
        data.setValue(9, 1, 1300);
        data.setValue(9, 2, 790);

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 560, height: 200, legend: 'bottom', chartArea: {left:'8%',top:'10%',width:'88%',height:'70%'}, pointSize: 5});
      }
    </script>
        </div>

    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_Transparent">
            <h3><?php echo __('Notifications') ?></h3>
            <div>
                <ul class="_linksVertical">
                    <li><?php echo link_to(__('+%1 Followers', array('%1' => $num_followers)), "@homepage", 'style=color:red;') ?></li>
                    <?php if ($num_messages > 0): ?><li><?php echo link_to(__('+%1 Messages', array('%1' => $num_messages)), "@homepage", 'style=color:red;') ?></li><?php endif ?>
                    <li><?php echo link_to(__('+%1 Likes', array('%1' => 12)), "@homepage", 'style=color:red;') ?></li>
                    <li><?php echo link_to(__('+%1 Job Candidates', array('%1' => 5)), "@homepage", 'style=color:red;') ?></li>
                </ul>
            </div>
        </div>

        <?php include_partial('company/upgradeBox', array('company' => $company)) ?>

    </div>
    
</div>

<script type="text/javascript">
$(function() {
    
    $('._comMng_select').click(function(){
        $('._comMng_select').toggleClass('_open');
        return false;
    });
    $("span.btn_container").buttonset();
});
</script>

<?php /* ?>
<div class="column span-123">

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/tag-icon.png'), "@edit-company-profile?hash={$company->getHash()}") ?>
<ol>
<li><?php echo link_to(__('Company Information'), "@edit-company-profile?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Edit Information'), "@company-corporate?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Edit Contact Details'), "@company-contact?hash={$company->getHash()}") ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/globe-icon.png'), "@manage-products?hash={$company->getHash()}") ?>
<ol>
<li><?php echo link_to(__('Products and Services'), "@manage-products?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Edit Products and Services'), "@manage-products?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Add New Product or Service'), "@add-product?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Post Selling Lead'), "@post-selling-lead?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Post Buying Lead'), "@post-buying-lead?hash={$company->getHash()}") ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/network-icon.png'), 'company/network') ?>
<ol>
<li><?php echo link_to(__('Network'), 'company/network') ?></li>
<li><?php echo link_to(__('Network Requests'), 'company/requests') ?></li>
<li><?php echo link_to(__('Friends'), 'company/network') ?></li>
</ol>
</div>

<div class="iconed-list-block first">
<?php echo link_to(image_tag('layout/icon/calender-icon.png'), "@company-events?hash={$company->getHash()}") ?>
<ol>
<li><?php echo link_to(__('Calender'), "@company-events?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Events'), "@company-events?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Attendance Notice'), "@company-events?hash={$company->getHash()}") ?></li>
<li><?php echo link_to(__('Add Event'), "@company-events?hash={$company->getHash()}") ?></li>
</ol>
</div>

<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/jobs-icon.png'), "@company-jobs-action?action=home&hash={$company->getHash()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
<ol>
<li><?php echo link_to(__('Jobs'), "@company-jobs-action?action=home&hash={$company->getHash()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?></li>
<li><?php echo link_to(__('Edit Jobs'), "@company-jobs-action?action=home&hash={$company->getHash()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?></li>
<li><?php echo link_to(__('Post Job'), "@company-jobs-action?action=post&hash={$company->getHash()}&otyp=".PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?></li>
</ol>
</div>
<?php /* ?>
<div class="iconed-list-block">
<?php echo link_to(image_tag('layout/icon/account-icon.png'), 'company/account') ?>
<ol>
<li><?php echo link_to(__('Account'), 'company/account') ?></li>
<li><?php echo link_to(__('Request New Service'), 'service/request') ?></li>
<li><?php echo link_to(__('Pending Requests'), 'service/pending') ?></li>
<li><?php echo link_to(__('Payment History'), 'service/paymentHistory') ?></li>
</ol>
</div>
<?php  ?>

</div>
<?php  /*
require_once 'Console/Color.php';

$lines1 = "Merhaba,

eMarketTurkey.com; ticaret, sanayi ve hizmet sektörlerine yönelik dizin servisleri, insan kaynakları, online tercüme, uluslararası ticaret ve yatırım danışmanlığı alanlarında bir çok servisi tek bir platformda barındıran yeni nesil ticaret portalıdır. Hedefimiz, Türkiye’nin en kapsamlı ticaret veritabanını hazırlayarak uluslararası pazarlarda Türk firmalarının bilinebilirliğini arttırmak, rekabet gücünü geliştirmek, ulusal ve uluslararası ticaretin yeni buluşma noktası olmaktır.

eMarketTurkey tüm ekonomik kesimleri kucaklayan, global bir anlayışa sahip, insan odaklı ve iş-alışveriş süreçlerinin hemen hepsinin internet üzerinden yapıldığı bir ekonomik platformdur.

eMarketTurkey, beş ana kısımdan oluşmaktadır.

B2B Servisleri,
İnsan Kaynakları,
Akademi,
Topluluk,
Tercüme
eMarketTurkey B2B : Firmaların birbirleriyle etkin diyalog kurabilecekleri ürün ve hizmetlerini yayınlayabilecekleri dizin hizmetleri topluluğudur. B2B hizmetleri, Dış Ticaret Uzmanları Desteği, Taşımacılık Dizini, Anadilde Yazışma, Yatırım ve İş Fırsatları Dizini gibi bir çok katma değerli hizmetleri kapsamaktadır.

eMarketTurkey İK : Bireyler özgeçmişlerini oluşturup, iş ilanlarını ve ilgi duydukları firmaları takip edebilmekte, iş fırsatları arasından kendilerine uyacak en iyi pozisyonları sorgulayabilmektedirler. Bununla birlikte iş verenler ve İK alanında danışmanlık yapan firmalar ise ilan yayınlayabilmekte, adayların başvurularını incelemekte, doğru adaylara ulaşabilmek için veritabanımızı ayrıntılı şekilde sorgulayabilmektedirler.

eMarketTurkey Akademi : Yürüttüğümüz faaliyetlere hem akademik boyut kazandırmak hem de bilimsel kriterlere uygun analiz ve uygulamaların ortaya konabilmesi, projeler geliştirilebilmesi adına üniversiteler ile yakın çalışmalar yürütmektedir. Bu dizin içinde, tanınmış köşe yazarlarının, akademisyenlerin ve ekonomistlerin makale ve araştırmalarının yayınlanacağı, çeşitli anket, haber ve istatistiklerin yer alacağı bir yapı oluşturulmustur.

eMarketTurkey Topluluk : Üyelerimiz çeşitli konularda faaliyet gösteren iş ve sosyal ağlara üye olabilir, global bir iletişim ağı kurarak kariyerlerini arzuladıkları doğrultuda ilerletmelerini sağlayacak fırsatları yakalayabilirler. Topluluk sayfalarında ücretsiz Seri İlanlar ve Etkinlik Takvimi gibi bir çok hizmet de yer almaktadır.

eMarketTurkey Tercüme : eMarketTurkey, üzerindeki tüm bilgilerin ve içeriğin farklı dillerde yayınlanabileceği şekilde inşa edilmiştir. Tercüman ağımız sayesinde firmalar, hizmet ve ürün bilgilerini istedikleri dillerde yayınlama imkanına sahip olacaklardır. Ayrıca eMarketTurkey Genel Tercüme Hizmetleri ile her türlü çeviri internet üzerinden gerçekleştirilmekte ve tüm süreçler online olarak takip edilebilmektedir.";
$lines2 = "Merhaba,

eMarketTurkey.com; ticaret, sanayi ve hizmet sektörlerine yönelik dizin servisleri, insan kaynakları, online tercüme, uluslararası ticaret ve yatırım danışmanlığı alanlarında bir çok servisi tek bir platformda barındıran yeni nesil ticaret portalıdır. Hedefimiz, Türkiye’nin en kapsamlı ticaret veritabanını hazırlayarak uluslararası pazarlarda Türk firmalarının bilinebilirliğini arttırmak, rekabet gücünü geliştirmek, ulusal ve uluslararası ticaretin yeni buluşma noktası olmaktır.

eMarketTurkey tüm ekonomik kesimleri kucaklayan, global bir anlayışa sahip, insan odaklı ve iş-alışveriş süreçlerinin hemen hepsinin internet üzerinden yapıldığı bir ekonomik platformdur.

eMarketTurkey, beş ana kısımdan oluşmaktadır.

B2B Servisleri,
İnsan Kaynakları,
Akademi,
Topluluk,
Tercüme
eMarketTurkey B2B : Firmaların birbirleriyle etkin diyalog kurabilecekleri ürün ve hizmetlerini yayınlayabilecekleri dizin hizmetleri topluluğudur. B2B hizmetleri, Dış Ticaret Uzmanları Desteği, Taşımacılık Dizini, Anadilde Yazışma, Yatırım ve İş Fırsatları Dizini gibi bir çok katma değerli hizmetleri kapsamaktadır.

eMarketTurkey İK : Yayınlanan iş ilanlarına başvuru yapabilir ve süreci takip edebilirsiniz.

eMarketTurkey Akademi : Yürüttüğümüz faaliyetlere hem akademik boyut kazandırmak hem de bilimsel kriterlere uygun analiz ve uygulamaların ortaya konabilmesi, projeler geliştirilebilmesi adına üniversiteler ile yakın çalışmalar yürütmektedir. Bu dizin içinde, tanınmış köşe yazarlarının, akademisyenlerin ve ekonomistlerin makale ve araştırmalarının yayınlanacağı, çeşitli anket, haber ve istatistiklerin yer alacağı bir yapı oluşturulmustur.

eMarketTurkey Topluluk : Üyelerimiz çeşitli konularda faaliyet gösteren iş ve sosyal ağlara üye olabilir, global bir iletişim ağı kurarak kariyerlerini arzuladıkları doğrultuda ilerletmelerini sağlayacak fırsatları yakalayabilirler. Topluluk sayfalarında ücretsiz Seri İlanlar ve Etkinlik Takvimi gibi bir çok hizmet de yer almaktadır.

eMarketTurkey Tercüme : eMarketTurkey, üzerindeki tüm bilgilerin ve içeriğin farklı dillerde yayınlanabileceği şekilde inşa edilmiştir. Tercüman ağımız sayesinde firmalar, hizmet ve ürün bilgilerini istedikleri dillerde yayınlama imkanına sahip olacaklardır. Ayrıca eMarketTurkey Genel Tercüme Hizmetleri ile her türlü çeviri internet üzerinden gerçekleştirilmekte ve tüm süreçler online olarak takip edilebilmektedir.";

$diff = diff_patch::diff($lines1, $lines2);

//$diff = xdiff_string_diff($lines1, $lines2);

echo "line1 - $lines1<br />";
echo "line2 - $lines2<br />";

echo "<br />";
var_dump($diff);
echo "<br />";
echo "<br />";

echo "patched: ". ($patch = diff_patch::patch($lines1, $diff)). "<br /><br />";
echo "unpatched: ". diff_patch::unpatch($patch, $diff);

/*
$diff     = @(new Text_Diff('auto', array($lines1, $lines2)));
$renderer = @(new Text_Diff_Renderer_inline(
    array(
        'ins_prefix' => '<span style="color:blue;">',
        'ins_suffix' => '</span>',
        'del_prefix' => '<span style="color:red;text-decoration:line-through">',
        'del_suffix' => '</span>',
    )
));
echo htmlspecialchars_decode(
        @$renderer->render($diff)
    );

*/
 ?>
