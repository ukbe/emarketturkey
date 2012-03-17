<?php slot('uppermenu') ?>
<?php include_partial('network/uppermenu') ?>
<?php end_slot() ?>
<?php if(count($people)): ?>
<div class="network-panel">
<style>
.network-panel table td
{
    border-bottom: solid 1px #AAAAAA;
    padding: 5px;
}
</style>
<table cellspacing="0" cellpadding="5" border="0" width="100%">
<?php foreach ($people as $person): ?>
<tr>
<td><?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?></td>
<td width="90%">
<div><?php echo link_to($person, $person->getProfileUrl()) ?></div>
<div>
<?php $work = $person->getCurrentEmployments(true) ?>
<?php $school = $person->getCurrentEducations(true) ?>
<?php if ($school or $work): ?>
<?php echo $work ? __('%1p at %2c', array('%1p' => $work->getJobTitle(), '%2c' => $work->getCompanyName())) . "<br />" : "" ?>
<?php echo $school ? __('%1d student at %2s on %3m', array('%1d' => $school->getResumeSchoolDegree(), '%2s' => $school->getSchool(), '%3m' => $school->getMajor())) . "<br />" : "" ?>
<?php endif ?>
</div>
</td>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $person)): ?>
<?php $token = sha1(base64_encode($person.session_id())); ?>
<?php echo link_to(__('Add as Friend'), "@user-action?action=add&id={$person->getId()}", array('query_string' => "token=$token&width=560&height=220&_ref=".urlencode($sf_request->getUri()), 'class' => 'thickbox nice add', 'title' => __('Add as Friend'))) ?>
<?php endif ?>
</td>
<td>
<div id="r<?php echo $person->getId() ?>error"></div>
<div id="r<?php echo $person->getId() ?>">
<?php echo emt_remote_link(__('Ignore'), 'r'.$person->getId(), 'network/ignore', array('user' => $person->getId(), 'ignore' => 'true'), null, array('class' => 'nice')) ?>
</div>
</td>
</tr>
<?php endforeach ?>
</table>
<div class="hrsplit-1"></div>
<div style="float: right;">
<ol class="column">
<?php if (!is_null($prevPG)): ?>
<li class="column prepend-2">
<?php echo link_to(image_tag('layout/icon/left-arrow.png'), '@pymk', array('query_string' => "pg=$prevPG", 'class' => 'nice arrow')) ?>
</li>
<?php endif ?>
<?php if (!is_null($nextPG)): ?>
<li class="column prepend-2">
<?php echo link_to(image_tag('layout/icon/right-arrow.png'), '@pymk', array('query_string' => "pg=$nextPG", 'class' => 'nice arrow')) ?>
</li>
<?php endif ?>
</ol>
</div>
<?php else: ?>
<?php echo __('No people to advise.') ?>
<?php endif ?>
</div>