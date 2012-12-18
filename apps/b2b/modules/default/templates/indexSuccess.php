<div class="col_948">
<div class="col_180">
    <div class="box_180 _title_Base">
        <h3><?php echo __('Product Categories') ?></h3>
        <div class="listContent">
            <ul>
            <?php foreach ($categories as $category): ?>
            <li><?php echo link_to($category->getName(), "@products-dir?substitute={$category->getStrippedCategory()}") ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>

<div class="col_576">

    <div class="box_576 spot_banner">
        <div class="slider">
            <div class="items">
                <img src="http://www.emarketturkey.com/images/content/banner/b2b-banner-fashion.jpg" alt="Fashionable, Quality Clothing Suppliers" />
                <img src="http://www.emarketturkey.com/images/content/banner/b2b-banner-furniture.jpg" alt="Find Elegant Furniture Products" />
                <img src="http://www.emarketturkey.com/images/content/banner/b2b-banner-grain.jpg" alt="Healthy Grain Producers" />
            </div>
            <div class="nav_placer"><div class="navi"></div></div>
        </div>
    </div>

    <hr class="margin-b2" />

    <?php if (count($selling_leads) > 3): ?>
    <div class="box_576 _title_BoldColor">

        <h3>
        <div class="_right"><?php echo link_to(__('See All'), '@selling-leads', 'class=bluelink hover') ?></div>
        <?php echo __('<strong>Selling</strong> Leads') ?></h3>
        <div>
            <div class="scrollable vertical">

                <div class="items">
                
                <?php foreach ($selling_leads as $i => $lead): ?>
                    <?php if (($i % 4) == 0): ?>
                    <div>
                    <?php endif ?>
                        <div class="item">
                            <?php echo link_to(image_tag($lead->getPhotoUri(), array('title' => $lead->__toString())), $lead->getUrl()) ?>
                            <div class="cname"><?php echo link_to($lead->__toString(), $lead->getUrl(), 'class=bluelink hover') ?></div>
                            <div class="industry"><?php echo link_to($lead->getCompany()->__toString(), $lead->getCompany()->getProfileUrl()) ?></div>
                        </div>
                    <?php if (($i % 4) == 3 || $i == (count($selling_leads)-1)): ?>
                    </div>
                    <?php endif ?>
                <?php endforeach ?> 
                </div>
            </div>
            <div class="navi"></div>
        </div>
    </div>

    <hr class="margin-b2" />
    <?php endif ?>

    <?php if (count($buying_leads) > 3): ?>
    <div class="box_576 _title_BoldColor">
        <h3><?php echo __('<strong>Buying</strong> Leads') ?></h3>
        <div>
            <div class="scrollable vertical">
            
                <div class="items">
                
                <?php foreach ($buying_leads as $i => $lead): ?>
                    <?php if (($i % 4) == 0): ?>
                    <div>
                    <?php endif ?>
                    <div class="item">
                        <?php echo link_to(image_tag($lead->getPhotoUri(), array('title' => $lead->__toString())), $lead->getUrl()) ?>
                        <div class="cname"><?php echo link_to($lead->__toString(), $lead->getUrl(), 'class=bluelink hover') ?></div>
                        <div class="industry"><?php echo link_to($lead->getCompany()->__toString(), $lead->getCompany()->getProfileUrl()) ?></div>
                    </div>
                    <?php if (($i % 4) == 3 || $i == (count($buying_leads) - 1)): ?>
                    </div>
                    <?php endif ?>
                <?php endforeach ?> 
                </div>
            </div>
            <div class="navi"></div>
        </div>
    </div>

    <hr class="margin-b2" />
    <?php endif ?>

    <?php if (count($featured_companies) > 3): ?>
    <div class="box_576 _title_BoldColor">
        <h3><?php echo __('<strong>Featured</strong> Companies') ?></h3>
        <div>
            <div class="scrollable vertical">
            
                <div class="items">
                <?php foreach ($featured_companies as $i => $company): ?>
                    <?php if (($i % 4) == 0): ?>
                    <div>
                    <?php endif ?>
                    <div class="item">
                        <?php echo link_to(image_tag($company->getLogo()->getThumbnailUri(), array('title' => $company->__toString())), $company->getProfileUrl()) ?>
                        <div class="cname"><?php echo link_to($company->getName(), $company->getProfileUrl()) ?></div>
                        <div class="industry"><?php echo $company->getBusinessSector()->__toString() ?></div>
                    </div>
                    <?php if (($i % 4) == 3 || $i == (count($featured_companies) - 1)): ?>
                    </div>
                    <?php endif ?>
                <?php endforeach ?>
                </div>
            </div>
            <div class="navi"></div>
        </div>
    </div>

    <hr class="margin-b2" />
    <?php endif ?>

    <?php if (count($featured_products) > 3): ?>
    <div class="box_576 _title_BoldColor">
        <h3><?php echo __('<strong>Featured</strong> Products') ?></h3>
        <div>
            <div class="scrollable vertical">
            
                <div class="items">
                
                <?php foreach ($featured_products as $i => $product): ?>
                    <?php if (($i % 4) == 0): ?>
                    <div>
                    <?php endif ?>
                    <div class="item">
                        <?php $photo = $product->getPhoto() ?>
                        <?php echo link_to(image_tag($photo->getThumbnailUri()), $product->getUrl()) ?>
                        <div class="cname"><?php echo link_to($product->__toString(), $product->getUrl()) ?></div>
                        <div class="industry"><?php echo link_to($product->getCompany()->__toString(), $product->getCompany()->getProfileUrl()) ?></div>
                    </div>
                    <?php if (($i % 4) == 3 || $i == (count($featured_products) - 1)): ?>
                    </div>
                    <?php endif ?>
                <?php endforeach ?> 
                </div>
            </div>
            <div class="navi"></div>
        </div>
    </div>
    <?php endif ?>
</div>
<div class="col_180">
    <?php if (count($featured_shows)): ?>
    <div class="box_180 _title_BaseXor">
        <h3><?php echo __('Upcoming Events') ?></h3>
        <div class="pad-0" style="width: 178px; padding: 0px -1px;">
            <div class="hrsplit-1"></div>
        <?php foreach ($featured_shows as $show): ?>
            <?php if ($show->getLogo()): ?>
            <?php echo link_to(image_tag($show->getLogo()->getMediumUri(), array('title' => $show->__toString(), 'width' => 180, 'style' => 'display:block;')), $show->getUrl(), 'target=blank') ?>
            <?php endif ?>
        <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>
    <style>.b2bad img { max-width: 170px; margin: 4px; } </style>
    <div class="b2bad box_180 pad-0">
    <?php echo get_ad_for_ns('/b2b/homepage/right/middle') ?>
    </div>
    <?php if (count($featured_experts)): ?>
    <div class="box_180 _title_BaseXor">
        <h3><?php echo __('Trade Experts') ?></h3>
        <div>
        <?php $texp = UserPeer::retrieveByPKs(array(15, 19)) ?>
        <dl class="trade-experts">
        <?php foreach ($featured_experts as $expert): ?>
            <dt><?php echo link_to(image_tag($expert->getProfilePictureUri(), array('title' => $expert->__toString())), $expert->getProfileUrl()) ?></dt>
            <dd><?php echo link_to($expert->__toString(), $expert->getProfileUrl()) ?></dd>
        <?php endforeach ?>
        </dl>
        <div class="hrsplit-1"></div>
        <div class="pad-1"><?php echo link_to(__('Find Trade Experts'), '@tradeexperts-action?action=find', 'class=bluelink hover')?></div>
        </div>
    </div>
    <?php endif ?>
</div>
<br class="clear" />
</div>
<?php use_stylesheet('jquery-tools/scrollable-navigator.css') ?>
<?php use_stylesheet('jquery-tools/scrollable-vertical.css') ?>
<?php echo javascript_tag("
   $(function(){
        $('.scrollable').scrollable({vertical: true, circular: true, mousewheel: true}).navigator().autoscroll({interval: 15000});
   });
") ?>
<?php use_javascript('emt-slider-1.0.js') ?>
<?php echo javascript_tag("
    $('.slider').emtslider({nav: '.navi'});
")?>