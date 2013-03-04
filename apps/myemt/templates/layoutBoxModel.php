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
<script src="/js/es5-shim.min.js" type="text/javascript"></script>
<![endif]-->
</head>
<body class="_admin">
<header>
 <?php include_partial('global/header') ?>
</header>
<div id="pop-holder"><?php include_partial('global/pop_message') ?>
<?php if (has_slot('pageHeader')): ?>
<div class="centralBlock">
<?php include_slot('pageHeader') ?>
<div class="clear"></div>
</div>
<?php endif ?>
</div>
<?php if ($sf_user->getMessage()): ?>
<div class="ghost">
<?php if ($sf_user->getMessageHeader()): ?>
<div id="page-user-message-header"><?php echo $sf_user->getMessageHeader(true) ?></div>
<?php endif ?>
<div id="page-user-message"><div class="dynaboxMsg"><?php echo $sf_user->getMessage(true) ?></div></div>
</div>
<?php endif ?>
<div id="section-bg">
<section class="app_myemt">
 <?php if (has_slot('subNav')): ?>
 <?php include_slot('subNav') ?>
 <?php else: ?>
 <?php include_partial('global/subNav') ?>
 <?php endif ?>
 <?php echo $sf_data->getraw('sf_content') ?>
</section>
</div>
<section id="lowerContainer">
 <?php include_partial('global/footer') ?>
</section>
</body>
</html>