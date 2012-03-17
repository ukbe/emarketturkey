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
<?php if (has_slot('uppermenu')): ?>
<div class="column span-198 uppermenu">
	<?php include_slot('uppermenu') ?>
	<div class="hrsplit-1"></div>
</div>
<?php endif ?>
<?php if (has_slot('mappath') || has_slot('pagecommands')): ?>
<div class="column span-198">
<div class="column<?php if(!has_slot('mappath')) echo " span-40" ?>">
<?php if (has_slot('mappath')): ?>
<?php include_slot('mappath') ?>
<?php endif ?>
</div>
<?php if (has_slot('pagecommands')): ?>
<?php include_slot('pagecommands') ?>
<?php endif ?>
<div class="hrsplit-1"></div>
</div>
<?php endif ?>
<div class="column span-198">
<div class="column span-146 append-2">
<?php echo $sf_data->getraw('sf_content') ?>
</div>
<?php if(has_slot('rightcolumn')): ?>
<div class="column span-49 last">
<?php include_slot('rightcolumn') ?>
</div>
<?php endif ?>
</div>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('global/bottombar') ?>
</div>
</body>
</html>