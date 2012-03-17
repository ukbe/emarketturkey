<div class="col_948">
<div class="col_180">
    <div class="box_180 _title_Base">
        <h3><?php echo __('Product Categories') ?></h3>
        <div class="listContent">
            <ul>
            <?php foreach ($categories as $category): ?>
            <li><?php echo link_to($category->getName(), '@product-category?stripped_category='.$category->getStrippedCategory()) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>

<?php use_stylesheet('jquery-tools/scrollable-navigator.css') ?>
<?php use_stylesheet('jquery-tools/scrollable-vertical.css') ?>
<div class="col_576">
    <div class="box_576 _title_BoldColor">
        <h3><?php echo __('<strong>Trade</strong> Leads') ?></h3>
        <div class="pad-0">
            <div class="box_285 _drySpotBox pad-0 margin-0 margin-r1">
                <h3><?php echo __('Selling Leads') ?></h3>
                <div class="margin-2">
                    <ul class="pad-0 margin-b2">
                    <?php foreach ($selling_leads as $slead): ?>
                    <li><?php echo link_to($slead, $slead->getUrl(), 'class=inherit-font t_blue t_small hover') ?>
                        <div class="t_grey t_smaller"><?php echo $slead->getCompany() ?></div></li>
                    <?php endforeach ?>
                    </ul>
                    <?php echo link_to(__('Browse all Selling Leads'), '@homepage', 'class=t_blue t_underline trail-right-11px') ?>
                </div>
            </div>
            <div class="box_285 _drySpotBox pad-0 margin-0">
                <h3><?php echo __('Buying Leads') ?></h3>
                <div class="margin-2">
                    <ul class="pad-0 margin-b2">
                    <?php foreach ($buying_leads as $blead): ?>
                    <li><?php echo link_to($blead, $blead->getUrl(), 'class=inherit-font t_blue t_small hover') ?>
                        <div class="t_grey t_smaller"><?php echo $blead->getCompany() ?></div></li>
                    <?php endforeach ?>
                    </ul>
                    <?php echo link_to(__('Browse all Buying Leads'), '@homepage', 'class=t_blue t_underline trail-right-11px') ?>
                </div>
            </div>
        
        </div>
    </div>
    <hr class="margin-b2" />

    <?php if (count($featured_companies)): ?>
    <div class="box_576 _title_BoldColor">
        <h3><?php echo __('<strong>Featured</strong> Companies') ?></h3>
        <div>
    <?php $i = 0 ?>
    <div class="scrollable vertical">
    
    <div class="items">
    
    <?php foreach ($featured_companies as $company): ?>
    <?php $i++ ?>
    <?php if (($i % 4) == 1): ?>
    <div>
    <?php endif ?>
    <div class="item">
        <?php echo link_to(image_tag($company->getProfilePictureUri(), array('title' => $company)), $company->getProfileUrl()) ?>
        <div class="cname"><? echo link_to($company->getName(), $company->getProfileUrl()) ?></div>
        <div class="industry"><? echo $company->getBusinessSector() ?></div>
    </div>
    <?php if (($i % 4) == 0): ?>
    </div>
    <?php endif ?>
    <?php endforeach ?> 
    </div>
    </div>
    <div class="navi"></div>
        </div>
    </div>
<?php echo javascript_tag("
   $(function(){
        $('.scrollable').scrollable({vertical: true, circular: true, mousewheel: true}).navigator().autoscroll({interval: 15000});
   });
") ?>
    <?php endif ?>

    <hr class="margin-b2" />
    
    <?php if (count($featured_products)): ?>
    <div class="box_576 _title_BoldColor">
        <h3><?php echo __('<strong>Featured</strong> Products') ?></h3>
        <div>
    <?php $i = 0 ?>
    <table class="recentcomps" cellspacing="1" cellpadding="0" border="0" width="576">
    <?php foreach ($featured_products as $product): ?>
    <?php $i++ ?>
    <?php if (($i % 2) == 1): ?>
    <tr>
    <?php endif ?>
    <td class="logo"><?php echo link_to(image_tag($product->getThumbUri(), array('title' => $product)), $product->getUrl()) ?></td>
    <td class="cname">
        <span><? echo link_to($product, $product->getUrl()) ?></span>
        <em><?php echo link_to($product->getCompany(), $product->getUrl()) ?></em>
        </td>
    <?php if (($i % 2) == 0): ?>
    </tr>
    <?php endif ?>
    <?php endforeach ?> 
    <?php if (($i % 2) == 1): ?>
    <td></td>
    </tr>
    <?php endif ?>
    </table>
        </div>
    </div>
    <?php endif ?>
</div>

<div class="col_180">
    <div class="box_180 _title_BaseXor">
        <h3><?php echo __('Upcoming Events') ?></h3>
        <div class="pad-0">
    <?php echo link_to(image_tag("content/event/automechanika.png", array('title' => __('Automechanika Middle East - Messe Frankfurt, 7-9 June 2011, Dubai'), 'width' => 178, 'style' => 'display:block;')), 'http://www.automechanikame.com', 'target=blank') ?>
        </div>
    </div>
    <style>.b2bad img { max-width: 170px; margin: 4px; } </style>
    <div class="b2bad box_180 pad-0">
    <?php echo get_ad_for_ns('/b2b/homepage') ?>
    </div>
    <div class="box_180 _title_BaseXor">
        <h3><?php echo __('TRADE Experts <sup>®</sup>') ?></h3>
        <div>
        <?php $texp = UserPeer::retrieveByPKs(array(15, 19)) ?>
        <dl class="">
            <dt class="_left margin-r1 clear"><?php echo link_to(image_tag($texp[0]->getProfilePictureUri(), array('title' => $texp[0])), $texp[0]->getProfileUrl()) ?></dt>
            <dd class="_left" style="width:90px;"><?php echo link_to($texp[0], $texp[0]->getProfileUrl()) ?><br />
                              <span class="t_grey t_smaller"><?php echo count($wrk = $texp[0]->getWorkHistory()) ? $wrk[0]->getCompany() : '' ?></span></dd>
            <dt class="_left margin-r1 clear "><?php echo link_to(image_tag($texp[1]->getProfilePictureUri(), array('title' => $texp[1])), $texp[1]->getProfileUrl()) ?></dt>
            <dd class="_left" style="width:90px;"><?php echo link_to($texp[1], $texp[1]->getProfileUrl()) ?><br />
                              <span class="t_grey t_smaller"><?php echo count($wrk = $texp[1]->getWorkHistory()) ? $wrk[0]->getCompany() : '' ?></span></dd>
        </dl>
        <div class="clear"></div>
        </div>
    </div>
</div>
<br class="clear" />
</div>