<ol class="search-results">
<?php if (count($friends)): ?>
<?php foreach ($friends as $friend): ?>
<li><?php echo link_to(str_ireplace($keyword, '<span class="focus-excerpt">'.$keyword.'</span>', $friend), $friend->getProfileUrl()) ?></li>
<?php endforeach ?>
<?php else: ?>
<li>Not Found</li>
<?php endif ?>
</ol>