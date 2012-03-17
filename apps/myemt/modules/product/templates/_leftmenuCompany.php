<div class="column span-39 append-1">
<?php $categories = $company->getProductCategories();
$list = array();
foreach ($categories as $category)
{
    $list[$category->getName()] = "product/company?id=".$company->getId()."&cat=".$category->getId();
}
?>
<?php echo generateMenu($list) ?>
</div>