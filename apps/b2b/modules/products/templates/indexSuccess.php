<div class="col_948">
    <div class="col_180">

<?php include_partial('products') ?>

    </div>
    
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Find a Product') ?></h4>
            <?php echo form_tag("@search-products", 'method=get') ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('keyword', __('Search Product')) ?></dt>
                <dd><?php echo input_tag('keyword', $sf_params->get('keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('category', __('Category'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_tag('category', options_for_select(ProductCategoryPeer::getBaseCategories(), $sf_params->get('category')), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('country', $sf_params->get('country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
            </dl>
            </form>
        </div>
        
        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Products Spotlight') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($spot_products as $product): ?>
                <?php include_partial('product/product', array('product' => $product)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Products in the spot'), "@products-action?action=spotlight", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Products from Your Network') ?></h5>
            <div class="_noBorder smalltext tiny">
                <?php foreach ($net_products as $product): ?>
                <?php include_partial('product/product', array('product' => $product)) ?>
                <?php endforeach ?>
                <?php echo link_to(__('List all Products from My Network'), "@products-action?action=network", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>
        
    </div>

    <div class="col_180">
    </div>

</div>