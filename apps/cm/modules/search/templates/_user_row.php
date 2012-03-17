<?php 
switch ($column)
{
    case 'id': echo link_to(image_tag($row->getProfilePictureUri()), $row->getProfileUrl()); break;
    case 'name': $contact = $row->getContact();
      $address = ($contact ? ($contact->getWorkAddress()?$contact->getWorkAddress():$contact->getHomeAddress()) : new ContactAddress());
      $user = $sf_user->getUser();
      if ($user)
      {
          $friends = $row->getFriends();
          $myfriends = $user->getFriends();
          $comm = array_intersect($friends, $myfriends);
          $fcount = count($comm);
          if ($fcount>0) 
          {
              $commkey = array_values($comm);
              shuffle($commkey);
              $common = array_slice($commkey, 0, 5);
          }
      }
      ?>
<span class="right" style="float: right;width: 200px;"><?php echo $address->getCountry()!=''?format_country($address->getCountry()).'&nbsp;'.image_tag('layout/flag/'.$address->getCountry().'.png', 'style=margin-right:5px;width:20px;'):'&nbsp;' ?></span>
<span style="float: right;width: 250px;">
<?php if ($user && $user->getId() != $row->getId()): ?>
<?php if (isset($fcount) && $fcount>0): ?>
<?php echo link_to_function(format_number_choice('[1]%1 Common Friend|(1,+Inf]%1 Common Friends', 
                 array('%1' => $fcount), $fcount), "jQuery('.comm{$row->getId()}').slideToggle('fast');", 'class=comm'.$row->getId()) ?>
<div class="comm<?php echo $row->getId() ?> ghost">
<?php foreach ($common as $comm): ?>
<?php echo link_to(image_tag($comm->getProfilePictureUri()), $comm->getProfileUrl(), array('title' => $comm)); ?>
<?php endforeach ?>
<?php if ($fcount > count($common)): ?>
<?php echo link_to('...', $row->getProfileActionUrl('friends'), array('title' => __('more'), 'style' => 'background-color: #D6DCDD; color: #000000; font: 16pt arial;')) ?>
<?php endif ?>
</div>
<?php endif ?>
<?php endif ?>
</span>
<div style="vertical-align: middle; height: 50px; display: table-cell;">
<?php echo link_to($row, $row->getProfileUrl(), 'class=username') ?><br />
<?php $work = $row->getCurrentEmployments(true) ?>
<?php $school = $row->getCurrentEducations(true) ?>
<?php if ($school or $work): ?>
<?php echo $work ? __('%1p at %2c', array('%1p' => $work->getJobTitle(), '%2c' => $work->getCompanyName())) . "<br />" : "" ?>
<?php echo $school ? __('%1d student at %2s on %3m', array('%1d' => $school->getResumeSchoolDegree(), '%2s' => $school->getSchool(), '%3m' => $school->getMajor())) . "<br />" : "" ?>
<?php endif ?>
<?php if (!$user || ($user && $user->getId() != $row->getId())): ?>
<?php if ($user && $user->can(ActionPeer::ACT_SEND_MESSAGE, $row)) echo link_to('Send Message', '@myemt.compose-message', array('query_string' => 'rcpu='.$row->getId().'&_ref='.urlencode($sf_request->getUri()), 'class' => 'action')) . "<br />" ?>
<?php if (!$row->isFriendsWith($user ? $user->getId() : 0)): ?>
<?php $token = sha1(base64_encode($row.session_id())); ?>
<?php echo link_to(__('Add to My Network'), "@user-action?action=add&id={$row->getId()}", array('query_string' => "token=$token&width=560&height=220&_ref=".urlencode($sf_request->getUri()), 'class' => 'thickbox action plus', 'title' => __('Add as Friend'))); ?>
<?php endif ?> 
<?php else: ?>
<?php echo __("THAT'S YOU!") ?>
<?php endif;
    
        break;
    default: break;
}
?>
</div>