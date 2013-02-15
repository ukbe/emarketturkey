<!DOCTYPE HTML>
<html<?php emt_include_itemtype() ?>>
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php emt_include_object_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<?php include_partial('global/google-analytics') ?>
<!--[if lt IE 9]>
<script src="/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
</head>
<body class="_noJS">
<header>
 <?php include_partial('global/header', array('urls' => $sf_user->getCultureLinks())) ?>
</header>
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
<section class="app_b2b">
 <?php if (has_slot('subNav')): ?>
 <?php include_slot('subNav') ?>
 <?php else: ?>
 <?php include_partial('global/subNav') ?>
 <?php endif ?>
 <?php echo $sf_data->getraw('sf_content') ?>
</section>
</div>
<section id="lowerContainer">
 <?php if (has_slot('footer')): ?>
 <?php include_slot('footer') ?>
 <?php else: ?>
 <?php include_partial('global/footer') ?>
 <?php endif ?>
</section>

</body>
</html>
