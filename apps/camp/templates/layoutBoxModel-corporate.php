<!DOCTYPE html>
<html>
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<?php include_partial('global/google-analytics') ?>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
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
 <?php include_partial('global/subNav-corporate') ?>
 <?php endif ?>
 <?php echo $sf_data->getraw('sf_content') ?>
</section>
</div>

<section id="lowerContainer">
 <?php include_partial('global/footer') ?>
</section>

</body>
</html>
