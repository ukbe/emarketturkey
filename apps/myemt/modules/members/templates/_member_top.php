                <div>
<?php $stateCnt = $member->getObjectTypeId()==PrivacyNodeTypePeer::PR_NTYP_USER ?
                        implode(', ', array_filter(array(
                                  ($member->getContact() && $member->getContact()->getHomeAddress() ) ? $member->getContact()->getHomeAddress()->getGeonameCity() : null,
                                  ($member->getContact() && $member->getContact()->getHomeAddress() ) ? format_country($member->getContact()->getHomeAddress()->getCountry()) : null)
                                 )
                        )
                : implode(', ', array_filter(array(
                          ($member->getContact() && $member->getContact()->getWorkAddress() ) ? $member->getContact()->getWorkAddress()->getGeonameCity() : null,
                          ($member->getContact() && $member->getContact()->getWorkAddress() ) ? format_country($member->getContact()->getWorkAddress()->getCountry()) : null)
                         )
                  )
                           ?>            
                <?php echo image_tag($member->getProfilePictureUri(), 'class=_left margin-r2') ?>
                <span class="t_green t_bold"><?php echo $member ?></span>
                <?php echo link_to(__('[Go to Profile]'), $member->getProfileUrl(), 'class=bluelink hover margin-l2') ?>
                <div>
                <span class="tag calendar-11px"><?php echo __('Member since %1', array('%1' => format_datetime($membership->getCreatedAt('U'), 'D'))) ?></span>
            <?php if ($member->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
                <span class="tag <?php echo $member->getGender() == UserProfilePeer::GENDER_MALE ? 'male' : 'female' ?>-11px"><?php echo __(UserProfilePeer::$Gender[$member->getGender()]) . ($member->getUserProfile() ? ($member->getUserProfile()->getMaritalStatus() ? ' (' . __(UserProfilePeer::$MaritalStatus[$member->getUserProfile()->getMaritalStatus()]) . ')' : '' ) : '') ?></span>
                <span class="tag balloon-11px"><?php echo __('Born on %1', array('%1' => format_date($member->getBirthdate('U'), 'D'))) ?></span>
            <?php endif ?>
            <?php if ($member->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY && $member->getCompanyProfile() && $member->getCompanyProfile()->getFoundedIn()): ?>
                <span class="tag balloon-11px"><?php echo __('Founded on %1', array('%1' => format_date($member->getCompanyProfile()->getFoundedIn('U'), 'D'))) ?></span>
            <?php endif ?>
            <?php if ($stateCnt): ?>
                <span class="tag pin-11px"><?php echo $stateCnt ?></span>
            <?php endif ?>
            <?php if ($perm = $group->can(ActionPeer::ACT_VIEW_CONTACT_INFO, $member)): ?>
                <span class="tag at-symbol-11px"><?php echo $member->getLogin()->getEmail() ?></span>
                <?php if ($member->getContact() && $member->getContact()->getHomePhone() && $member->getContact()->getHomePhone()->getPhone()): ?>
                <span class="tag phone-11px"><?php echo $member->getContact()->getHomePhone()->getPhone() ?></span>
                <?php endif ?>
                <?php if ($member->getContact() && $member->getContact()->getMobilePhone() && $member->getContact()->getMobilePhone()->getPhone()): ?>
                <span class="tag mobile-phone-11px"><?php echo $member->getContact()->getMobilePhone()->getPhone() ?></span>
                <?php endif ?>
            <?php endif ?>
                </div>
                </div>
