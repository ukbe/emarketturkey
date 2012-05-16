<!DOCTYPE html>
<html>
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/boxmodel-admin.css" />
<?php include_partial('global/google-analytics') ?>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
</head>
<body class="_admin">
<header<?php echo $sf_user->isLoggedIn() ? ' class="login"' : '' ?>>
<?php include_partial('global/header_noAdmin') ?>
</header>
<section id="container" class="ui-corner-bottom ui-corner-tr app_tx">
<?php if (has_slot('subNav')): ?>
<?php include_slot('subNav') ?>
<?php else: ?>
<?php include_partial('global/subNav') ?>
<?php endif ?>
<div class="container">
<?php echo $sf_data->getraw('sf_content') ?>
</div>
</section>

<section id="lowerContainer"><?php include_partial('global/footer_noAdmin') ?></section>
</body>
</html>
