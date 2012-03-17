<?php if (count($products)): ?>
<?php foreach ($products as $product): ?>
<tr>
<td class="check"><?php echo checkbox_tag('selected_items[]', $product->getId(), false, array('id' => 'checkRow'.$product->getId())) ?></td>
<td class="thumb"><?php echo link_to(image_tag($product->getThumbUri(), 'width=50'), 'products/new', array('query_string' => 'id='.$product->getId()."&do=".md5($product->getName().$product->getId().session_id()))) ?></td>
<td class="model"><?php echo link_to($product->getModelNo(), 'products/new', array('query_string' => 'id='.$product->getId()."&do=".md5($product->getName().$product->getId().session_id()))) ?></td>
<td class="name"><?php echo link_to($product->getName(), 'products/new', array('query_string' => 'id='.$product->getId()."&do=".md5($product->getName().$product->getId().session_id()))) ?></td>
<td class="category"><?php echo link_to($product->getProductCategory()->getName(), 'products/list?cat='.$product->getProductCategory()->getId()) ?></td>
<td class="actions">
<?php echo link_to(image_tag('layout/icon/edit-n.png', array('title' => __('Edit'))),'products/new', array('query_string' => 'id='.$product->getId()."&do=".md5($product->getName().$product->getId().session_id()))) ?>
<?php echo link_to(image_tag('layout/icon/delete-n.png', array('title' => __('Delete'))),'products/delete', array('query_string' => 'id='.$product->getId()."&do=".md5($product->getName().$product->getId().session_id()))) ?>
<span id="toggleActivateLink<?php echo $product->getId() ?>">
<?php echo emt_remote_link(
                image_tag('layout/icon/'.($product->getActive()?'active-n':'active-grey-n').'.png', array('title' => $product->getActive()?__('De-Activate'):__('Activate'))), 
                'toggleActivateLink'.$product->getId(), 
                'products/toggleActivate', 
                array('id' => $product->getId(), 'do' => md5($product->getName().$product->getId().session_id())
           )) ?></span>
<span id="toggleActivateLink<?php echo $product->getId() ?>error"></span>
</td>
</tr>
<?php endforeach ?>
<?php echo javascript_tag("
     jQuery('table.product-list').find('tr').hover(function(){jQuery(this).addClass('overthecell');}, function(){jQuery(this).removeClass('overthecell');}).click(function (){/*window.location=jQuery(this).find('a:first-child').attr('href')*/});
     jQuery(':check[id^=checkRow]').click(function(){if (this.checked){jQuery(this).parent().parent().addClass('selectedRow');} else {jQuery(this).parent().parent().removeClass('selectedRow');}});
") ?>
<?php else: ?>
<tr><td colspan="6">
<h3><?php echo __("No Products Found For \"$filter\"") ?></h3>
</td></tr>
<?php endif ?>

<? $form = "<li>".__('%1 items total', array('%1' => $pager->getNbResults()))."</li>";
$form .= "<li>".select_tag('max', options_for_select(array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), $max), "onchange=setPagerAttribute('max', this.value)") ."<span style=\"float: left;\">&nbsp;".__('per page')."</span></li>";
if ($pager->haveToPaginate()){
$form .= "<li>".link_to_function('&laquo;', "setPagerAttribute('st',".$pager->getFirstPage().")");
$form .= link_to_function('&lt;', "setPagerAttribute('st',".($pager->getFirstIndice()-1).")");
$links = $pager->getLinks();
foreach ($links as $page){
    $form .= ($page == $pager->getPage()) ? link_to_function($page, 'return false;', 'class=current') : link_to_function($page, "setPagerAttribute('st',".(($page-1)*$pager->getMaxPerPage()+1).")");
}
$form .= link_to_function('&gt;', "setPagerAttribute('st',".($pager->getLastIndice()+1).")");
$form .= link_to_function('&raquo;', "setPagerAttribute('st',".$pager->getNbResults().")");
$form .= "</li>";
}
 ?>
<?php echo javascript_tag("
           html = '".escape_javascript($form)."';
           jQuery('#pagerlinks').html(html);
           var items = {};
           items['filter'] = '$filter';
           items['st'] = '$start';
           items['cat'] = '$cat';
           items['sort'] = '$sort';
           items['dir'] = '$dir';
           updatePagerAttributes(items);
           jQuery('#progressing').hide();
           
           ") ?>