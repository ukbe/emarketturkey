<?php echo 'Gönderilen : '.count($resenttrs) ?>
<br />
<table>
<?php foreach ($resenttrs as $resenttr): ?>
<tr><td>
<?php echo $resenttr->getId() ?></td><td>
<?php echo $resenttr->getEmail() ?></td></tr>
<?php endforeach ?>
</table>