<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 transitional//EN" "http://www.w3.org/tr/xhtml1/Dtd/xhtml1-transitional.dtd">
<html>
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<?php include_partial('global/google-analytics') ?>
</head>
<body>
<div class="container">
<?php include_partial('global/topbar') ?>
<?php include_partial('global/toolbar') ?>
<div class="hrsplit-1"></div>
<?php include_partial('global/message-bar') ?>
<div class="hrsplit-1"></div>
<div class="column prepend-1 content">
<div class="column span-198">
<div class="column span-31 append-2">
<?php if (has_slot('leftcolumn')): ?>
<?php include_slot('leftcolumn') ?>
<?php endif ?>
</div>
<div class="column span-114 append-2">
<?php echo $sf_data->getraw('sf_content') ?>
</div>
<div class="column span-49">
<?php if (has_slot('rightcolumn')): ?>
<?php include_slot('rightcolumn') ?>
<?php endif ?>
</div>
</div>
</div>
<?php include_partial('global/bottombar') ?>
</div>
</body>
</html>