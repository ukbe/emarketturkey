<ol class="search-results">
<?php if (count($friends)): ?>
<?php foreach ($friends as $friend): ?>
<li ><?php echo link_to_function(
    str_ireplace($keyword, '<span class="focus-excerpt">'.$keyword.'</span>', $friend), 
    update_element_function('lastli', array(
                    'content' => '<li id="fu'.$friend->getId().'" class="column span-69" style="padding: 3px;border-bottom: dotted 1px #CCCCCC;" onmouseover="this.style.backgroundColor=\'#99AAAA\'" onmouseout="this.style.backgroundColor=\'#FFFFFF\'">'.input_hidden_tag('recipients[]', $friend->getId()).'<span class="column span-65">'.$friend.'</span><span class="column span-4">'.link_to_function(image_tag('layout/icon/delete-icon.png', 'width=15'), '$(\'fu'.$friend->getId().'\').outerHTML=\'\';').'</span></li>', 
                    'position' => 'before')) .
    '$(\'type_rcpnt\').value=\'\';'. visual_effect('BlindUp', 'type_rcpnt', array('duration' => 0.2))) ?></li>
<?php endforeach ?>
<?php else: ?>
<li>Not Found</li>
<?php endif ?>
</ol>