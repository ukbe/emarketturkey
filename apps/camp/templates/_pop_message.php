<?php if ($sf_user->hasPopMessage()): ?>
<div class="pop-message">
<?php
if (count($pop = $sf_user->getAttribute('pop_message', array(), '/user/page/default')))
{
    $current = array_pop($pop);
    include_partial($current['partial']);
} ?>
</div>
<?php endif ?>