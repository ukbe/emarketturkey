<emtAjaxResponse>
<emtInit>
function shutclose() { $.ui.dynabox.openBox.close(); } setTimeout(shutclose, 1800);
$('#r<?php echo $plug ?>').closest('tr').hide();
$.ui.dynabox.openBox.hideHeaderFooter();
</emtInit>
<emtBody>
<div class="dynaboxMsg"><?php echo $message ?></div>
</emtBody>
</emtAjaxResponse>