<!DOCTYPE html>
<html<?php emt_include_itemtype() ?> lang="<? echo $sf_user->getCulture() ?>">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php emt_include_object_metas() ?>
<?php include_title() ?>
<?php emt_include_link_metas() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<?php include_partial('global/google-analytics') ?>
<!--[if lt IE 9]>
<script src="/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
</head>
<body class="_noJS _island">
<div id="pop-holder"><?php include_partial('global/pop_message') ?>
<?php if (has_slot('pageHeader')): ?>
<div class="centralBlock">
<?php include_slot('pageHeader') ?>
<div class="clear"></div>
</div>
<?php endif ?>
</div>
<?php include_partial('global/page_user_message') ?>
<div id="section-bg">
<section class="app_lobby">
 <?php if (has_slot('subNav')): ?>
 <?php include_slot('subNav') ?>
 <?php else: ?>
 <?php include_partial('global/subNav') ?>
 <?php endif ?>
 <?php echo $sf_data->getraw('sf_content') ?>
<?php include_partial('global/island-footer') ?>
</section>
</div>
</body>
</html>
