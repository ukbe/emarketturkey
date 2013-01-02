<table cellspacing="0" cellpadding="0" border="1" width="850">
<tr>
<td width="100"><?php echo link_to(image_tag('layout/background/cv-form/photo-frame.png'), 'hr_cv/materials') ?></td>
<td width="375">
<table cellspacing="0" cellpadding="0" border="0" width="375">
<tr><td><font size="16"><?php echo $resume->getUser() ?></font></td></tr>
<tr><td><font size="14"><?php echo __('Birth: %1', array('%1' => $resume->getUser()->getBirthDate('d F Y'))) ?></font></td></tr>
<tr><td><font size="12"><?php echo UserProfilePeer::$Gender[$resume->getUser()->getGender()] . ' / ' . UserProfilePeer::$MaritalStatus[$resume->getUser()->getUserProfile()->getMaritalStatus()] ?></font></td></tr>
<tr><td><font size="12"><?php echo $resume->getUser()->isEmployed()?__('Currently Employed') : __('Currently Unemployed') ?></font></td></tr>
</table>
</td>
<td width="375" align="right">
<table cellspacing="0" cellpadding="0" border="1" align="right" width="375">
<tr><td align="right" valign="top"><?php echo $resume->getContact()->getHomePhone()->getPhone() ?></td><td width="20"><?php echo image_tag('layout/icon/cv/telephone.png') ?></td></tr>
<tr><td align="right" valign="top"><?php echo $resume->getContact()->getEmail() ?></td><td width="20"><?php echo image_tag('layout/icon/cv/email.png') ?></td></tr>
<tr><td align="right" valign="top"><?php echo $resume->getContact()->getHomeAddress()->getStreet() ?><br />
<?php echo implode(', ', array($resume->getContact()->getHomeAddress()->getCity(),
                              $resume->getContact()->getHomeAddress()->getGeonameCity(),
                              format_country($resume->getContact()->getHomeAddress()->getCountry()))) ?></td><td width="20"><?php echo image_tag('layout/icon/cv/envelope.png') ?></td>
</tr></table>
</td>
</tr>
<tr>
<td colspan="3">
<?php echo image_tag('layout/background/cv-form/desired-position.'.$sf_user->getCulture().'.png', 'width=777') ?>
<br />
<table cellspacing="0" cellpadding="0" border="0">
<tr><td colspan="2"><?php echo $resume->getJobPosition() ?>[<?php echo $resume->getJobGrade() ?>]</td></tr>
<tr><td width="120"><?php echo __('Objective :') ?></td><td>
<span id="objectivebox" style="font: 13px helvetica; width: 600px; background-color: #F0FFE6; padding: 10px;"><?php echo $resume->getObjective() ?></span>
</td></tr>
</table>
</td>
</tr>
</table>

