<emtAjaxResponse>
<emtInit>
<?php echo isset($redir) ?
"function shutredir() { window.location = '".url_for($redir, true)."' } setTimeout(shutredir, 1800);" :
"function shutclose() { $.ui.dynabox.openBox.close(); } setTimeout(shutclose, 1800);"
 ?>
 $.ui.dynabox.openBox.hideHeaderFooter();
</emtInit>
<emtBody>
<div class="dynaboxMsg"><?php echo $message ?></div>
</emtBody>
</emtAjaxResponse>