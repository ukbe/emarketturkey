<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>
    <div class="hrsplit-1"></div>
    <div class="col_180">
<?php include_partial('leftmenu', array('company' => $company, 'groups' => $groups, 'categories' => $categories))?>

        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Try Buyer Tools') ?></h3>
            <div>
            </div>
        </div>

    </div>


        <div class="box_762 _titleBG_Transparent">
            <h4><?php echo $group ? $group : (count($groups) ? __('Ungrouped') : ($category ? $category : __('Products'))) ?></h4>
            <div class="productGallery _noBorder">
                <ul>
                    <li class="pageNumButtons">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </li>
                    <li><?php echo form_tag(myTools::remove_querystring_var($sf_request->getUri(), 'ipp'), 'method=get') ?>
                    <?php echo __('%1 items per page', array('%1' => select_tag('ipp', options_for_select(array_combine($ipps['thumbs'], $ipps['thumbs']), $ipp), array('onchange' => "$(this).closest('form').submit();")))) ?>
                    <noscript><?php echo submit_tag(__('refresh')) ?></noscript>
                    </form></li>
                </ul>
                <dl>
                    <dt><?php echo __('Products') ?></dt>
                    <?php foreach ($pager->getResults() as $product): ?>
                    <dd>
                        <?php echo link_to(image_tag($product->getThumbUri()) . "<em>$product</em>", $product->getUrl()) ?>
                    </dd>
                    <?php endforeach ?>
                </dl>
                <ul>
                    <li class="pageNumButtons">
                    <?php echo pager_links($pager, array('pname' => 'page'))?>
                    </li>
                    <li><?php echo form_tag(myTools::remove_querystring_var($sf_request->getUri(), 'ipp'), 'method=get') ?>
                    <?php echo __('%1 items per page', array('%1' => select_tag('ipp', options_for_select(array_combine($ipps['thumbs'], $ipps['thumbs']), $ipp), array('onchange' => "$(this).closest('form').submit();")))) ?>
                    <noscript><?php echo submit_tag(__('refresh')) ?></noscript>
                    </form></li>
                </ul>
            </div>
        </div>


</div>