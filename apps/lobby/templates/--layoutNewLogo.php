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
<div id="topbar" style="height: 50px;">
<div id="line"></div>
</div>
<div class="container-wrap">
<div class="container-margin"><?php echo image_tag('spacer.gif', 'width=25 height=1') ?></div>
<div class="container">
<div class="column prepend-1 content">
<div class="column span-198">
<?php echo $sf_data->getraw('sf_content') ?>
</div>
</div>
</div>
<div class="container-margin"><?php echo image_tag('spacer.gif', 'width=25 height=1') ?></div>
</div>
</body>
</html>