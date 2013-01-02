<div class="col_948">
    <div class="col_180">

<?php include_partial('leads', array('type_code' => $type_code, 'type_id' => $type_id)) ?>

    </div>
    
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __($isbuying ? 'Browse Buying Leads by Category' : 'Browse Selling Leads by Category') ?></h4>
            <div class="_noBorder two_columns linkfield">
            <?php foreach ($categories as $category): ?>
            <div><?php echo link_to($category, "@leads-dir?type_code=$type_code&substitute={$category->getStrippedCategory()}") ?>
                <?php foreach ($category->getSubCategories() as $subcat): ?>
                <?php echo link_to($subcat, "@leads-dir?type_code=$type_code&substitute={$subcat->getStrippedCategory()}", 'class=margin-l2') ?>
                <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
        
    </div>

    <div class="col_180">
    </div>

</div>