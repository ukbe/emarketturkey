<?php if (count($categories)): ?>
<ol class="column span-72 first" style="margin: 0px;padding:0px;">
<li class="column span-72"><?php echo select_tag('category_id_'.$category->getId(), options_for_select($categories, $category->getId(), array('include_custom' => __('Please Select'), 'class' => 'column first'))) ?></li>
</ol>
<?php echo observe_field('category_id_'.$category->getId(), array('update' => 'category_'.$category->getId(),
                'url' => 'author/publicationCategories', 
                'with' => "'category_id=' + value",
                'script' => true,
                'method' => 'post'
            )) ?>
<div id="category_<?php echo $category->getId() ?>" class="column first">
<?php echo input_hidden_tag('acategory_id', $category->getId()) ?></div>
<?php else: ?>
<?php echo input_hidden_tag('acategory_id', $category->getId()) ?>
<?php endif ?>