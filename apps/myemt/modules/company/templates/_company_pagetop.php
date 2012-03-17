<ol class="column" style="margin: 0px;">
    <li class="column pad-1 append-2">
    <?php echo image_tag($company->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM), array('style' => 'max-width: 100px; max-height: 24px;')) ?>
    </li>
    <li class="column pad-1">
    <div style="font: bold 16px arial; line-height: 25px;"><?php echo $company ?></div>
    <?php if (isset($map)): ?>
    <div class="hrsplit-2"></div>
    <div style="font: bold 11px tahoma;">
    <?php $m = array() ?>
    <?php foreach ($map as $label => $link): ?>
    <?php $m[] = $link ? link_to($label, is_array($link)?$link[0]:$link, is_array($link)?array_merge($link[1], array('class' => 'sibling')) : 'class=sibling') : '<span class="sibling">'.$label.'</span>' ?>
    <?php endforeach ?>
    <?php echo implode('', $m) ?>
    </div>
    <?php endif ?>
    </li>
</ol>