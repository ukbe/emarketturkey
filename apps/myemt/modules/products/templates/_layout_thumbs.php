<div>
<?php $i = 0; ?>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $product): ?>
    <?php $i++; ?>
    <div class="ui-corner-all" style="float: left; width: 100px; height: 100px; border: solid 1px #eaeced; margin: 0px <?php echo $i % 5 == 0 ? '0x' : '9px' ?> 7px 0px; text-align: center; padding: 5px 3px;">
        <?php echo link_to(image_tag($product->getThumbUri()), $product->getEditUrl()) ?><br />
        <?php echo link_to($product->getName($product->getDefaultLang()), $product->getEditUrl()) ?>
    </div>
<?php endforeach ?>
<?php else: ?>
    <div class="no-items"><?php echo __('No items') ?></div>
<?php endif ?>
</div>