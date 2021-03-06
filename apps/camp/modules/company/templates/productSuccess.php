<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>
    <div class="hrsplit-1"></div>
    <div class="col_180">

<?php include_partial('leftmenu', array('company' => $company, 'groups' => $groups, 'categories' => $categories))?>

    </div>

    <div class="col_762 b2bProduct">

        <h3 class="pname"><?php echo ($product->getAbsBrandName() ? $product->getAbsBrandName() . ' - ' : '' ) . $product->__toString() ?></h3>
        <div>
            <?php if ($photo = $product->getPhoto()): ?>
            <div class="col_180">
                <div class="box_180 txtCenter">
                    <?php echo link_to(image_tag($photo->getMediumUri(), array('alt' => $product->__toString())), $photo->getOriginalFileUri(), array('rel' => 'shadowbox[product-photos]', 'title' => $product->__toString())) ?>
                </div>
                <div class="box_180 txtCenter">
                    <div class="_noBorder">
                        <?php echo link_to(__('Contact Supplier'), $company->getProfileActionUrl('contact'), array('query_string' => "rel={$product->getPlug()}", 'class' => 'contactlink'))?>
                    </div>
                </div>
                <div class="box_180 txtCenter">
                    <div class="_noBorder">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style" style="display: inline-block;">
                            <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact"><?php echo __('Bookmark/Share')?></a>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
                        <!-- AddThis Button END -->
                        <div class="hrsplit-2"></div>
                        <?php echo like_button($product) ?>
                    </div>
                </div>
            </div>
            <?php endif ?>
            
            <div class="col_576">
                <div class="box_576">
                    <div class="_noBorder pad-0">
                    <?php if ($introduction): ?>
                    <div class="pad-2">
                        <?php echo myTools::format_text($introduction) ?>
                    </div>
                    <?php endif ?>
                    <div>
                        <h4<?php echo !$introduction ? '  class="margin-t0"' : '' ?>><?php echo __('Specifications') ?></h4>
                        <table class="infoTable margin-2" style="width: 542px;">
                            <tr><th><?php echo __('Category') ?></th>
                                <td><?php echo link_to($product->getProductCategory()->__toString(), "@products-dir?substitute={$product->getProductCategory()->getStrippedCategory()}") ?></td></tr>
                            <tr><th><?php echo __('Model No') ?></th>
                                <td><?php echo $product->getModelNo() ?></td></tr>
                            <?php if ($product->getProductGroup()): ?>
                            <tr><th><?php echo __('Product Group') ?></th>
                                <td><?php echo link_to($product->getProductGroup()->__toString(), $company->getProfileActionUrl('products'), array('query_string' => "group={$product->getProductGroup()->getStrippedName()}")) ?></td></tr>
                            <?php endif ?>
                            <tr><th><?php echo __('Origin') ?></th>
                                <td><?php echo CountryPeer::retrieveByISO($product->getOrigin()) ?></td></tr>
                            <tr><th><?php echo __('Brand Name') ?></th>
                                <td><?php echo $product->getAbsBrandName() ?></td></tr>
                            <?php foreach($attr['qualified'] as $as): ?>
                            <tr><th><?php echo $as->getProductAttrOption()->getProductAttrDef() ?></th>
                                <td><?php echo $as->getProductAttrOption()->getValue() ?></td></tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <div>
                        <h4><?php echo __('Payment and Shipping') ?></h4>
                        <dl class="_table _noInput">
                            <dt><?php echo emt_label_for('none', __('Payment Terms')) ?></dt>
                            <dd class="two_columns" style="width: 400px;">
                                <?php foreach ($payment_terms as $term): ?>
                                <div><?php echo $term->__toString() ?></div>
                                <?php endforeach?>
                            </dd>
                            <dt><?php echo emt_label_for('none', __('Minimum Order Quantity')) ?></dt>
                            <dd><?php echo $product->getMinOrderQuantity() . ' ' . ($product->getProductQuantityUnitRelatedByQuantityUnit() ? $product->getProductQuantityUnitRelatedByQuantityUnit()->__toString() : '') ?></dd>
                            <dt><?php echo emt_label_for('none', __('Price')) ?></dt>
                            <dd><?php echo $product->getPriceText() ?></dd>
                            <?php if ($product->getCapacity()): ?>
                            <dt><?php echo emt_label_for('none', __('Production Capacity')) ?></dt>
                            <dd><?php echo __('%1amount %2unit per %3period', array('%1amount' => $product->getCapacity(), '%2unit' => $product->getProductQuantityUnitRelatedByCapacityUnit(), '%3period' => $product->getTimePeriod())) ?></dd>
                            <?php endif ?>
                            <dt><?php echo emt_label_for('none', __('Packaging')) ?></dt>
                            <dd><?php echo $product->getPackaging() ?></dd>
                        </dl>
                    </div>
                    
                    <div>
                        <h4><?php echo __('Product Photos') ?></h4>
                        <?php if (count($photos) > 1): ?>
                        <?php 	array_shift($photos) ?>
                        <div class="photoGallery _noBorder">
                            <dl>
                                <dt><?php echo __('Product Photos') ?></dt>
                                <?php foreach ($photos as $ph): ?>
                                <dd>
                                    <?php echo link_to(image_tag($ph->getThumbnailUri(), array('alt' => $product->__toString())), $ph->getOriginalFileUri(), array('rel' => 'shadowbox[product-photos]', 'title' => $product->__toString())) ?>
                                </dd>
                                <?php endforeach ?>
                            </dl>
                        </div>
                        <?php else: ?>
                        <div class="pad-2">
                        <?php echo __('No photos') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    
                    </div>
                </div>
            </div>
            <?php if (!$photo): ?>
            <div class="col_180">
                <div class="box_180 txtCenter">
                    <div class="_noBorder">
                        <?php echo link_to(__('Contact Supplier'), $company->getProfileActionUrl('contact'), array('query_string' => "rel_type={$product->getObjectTypeId()}&rel={$product->getId()}", 'class' => 'contactlink'))?>
                    </div>
                </div>
                <div class="box_180 txtCenter">
                    <div class="_noBorder">
                        <?php echo like_button($product) ?>
                    </div>
                </div>
            </div>
            <?php endif ?>
            
            <div class=clear hrpslit-1"></div>
        </div>
            
    </div>
<?php use_javascript('/sf/shadowbox-build-3.0rc1/shadowbox.js') ?>
<?php use_stylesheet('/sf/shadowbox-build-3.0rc1/shadowbox.css') ?>
<?php echo javascript_tag('Shadowbox.init();') ?>

</div>