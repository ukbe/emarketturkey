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
<?php include_partial('global/topbar') ?>
<div class="hrsplit-1"></div>
<?php include_partial('global/toolbar') ?>
<div class="container">
<div class="hrsplit-1"></div>
<div class="span-198 pad-1">
<div class="hrsplit-3" style="background: #FFEF7D;"></div>
</div>
<div class="column pad-1 content">
<?php echo $sf_data->getraw('sf_content') ?>
</div>
</div>
<?php include_partial('global/bottombar') ?>
</body>
</html>