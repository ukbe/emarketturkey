<ol class="column" style="margin: 0px;">
    <li class="column pad-1 append-1" style="border: solid 1px #CCCCCC;">
    <?php echo image_tag(isset($user)?$user->getProfilePictureUri():$sf_user->getUser()->getProfilePictureUri()) ?>
    </li>
    <li class="column pad-1">
    <div style="font: bold 15px tahoma;"><?php echo isset($user) ? $user : $sf_user->getUser() ?></div>
    <div class="hrsplit-2"></div>
    <div style="font: bold 11px tahoma;">
    <?php $m = array() ?>
    <?php foreach ($map as $label => $link): ?>
    <?php $m[] = $link ? link_to($label, is_array($link)?$link[0]:$link, is_array($link)?$link[1]:null . ' class=sibling') : '<span class="sibling">'.$label.'</span>' ?>
    <?php endforeach ?>
    <?php echo implode('', $m) ?></div>
    </li>
</ol>