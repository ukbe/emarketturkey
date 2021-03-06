<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

<div class="col_948 cmGroup">

    <div class="col_180" style="z-index: 1;">
        <div class="photoBox">
        <?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $group->getProfileUrl()) ?>
        </div>
<?php include_partial('leftmenu', array('group' => $group))?>
        
    </div>

<?php include_partial('profile_top', array('group' => $group, 'nums' => $nums, 'sesuser' => $sesuser, 'userprops' => $userprops, '_here' => $_here))?>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576">
                <h4><?php echo __("Contact Group") ?></h4>
                <section>
                <?php if ($sesuser->isNew()): ?>
                    <div class="pad-3">
                    <?php echo __('Please %1 or %2 in order to contact %3.', array('%1' => link_to(__('Login'), '@myemt.login', array('query_string' => "_ref=$_here", 'class' => 'loginlink inherit-font bluelink hover')), '%2' => link_to(__('Sign Up'), "@myemt.signup?_ref={$_here}", 'class=inherit-font bluelink hover'), '%3' => $group)) ?>
                    </div>
                <?php else: ?>
                    <?php if ($composed): ?>
                    <div class="bubble ui-corner-all pad-2">
                        <?php echo __('Your message has been sent successfully.')?>
                    </div>
                    <?php else: ?>
                    <div class="pad-3">
                    <?php echo __('Fill in the contact form below to send message to %1.', array('%1' => $group)) ?>
                    </div>
                    <?php echo form_errors() ?>
                    <?php echo form_tag($group->getProfileActionUrl('contact')) ?>
                    <dl class="_table">
                        <dt><?php echo emt_label_for('_s', __('Sender')) ?></dt>
                        <dd><?php $list = $sesuser->getOwnerships(true);
                                  unset($list[$group->getPlug()]);
                                  echo select_tag('_s', options_for_select($list)) ?></dd>
                        <dt><?php echo emt_label_for('_r', __('Recipient')) ?></dt>
                        <dd class="t_larger t_bold t_green _noInput"><?php echo input_hidden_tag('_r', $group->getPlug()) ?><?php echo $group ?></dd>
                        <dt><?php echo emt_label_for('rtype', __('Request Type')) ?></dt>
                        <dd><?php echo select_tag('rtype', options_for_select(MessageTypePeer::getOrderedNames(ApplicationPeer::APP_B2B, true, true))) ?></dd>
                        <?php if ($related): ?>
                        <dt><?php echo emt_label_for('rourl', __('Related Item')) ?></dt>
                        <dd class="_noInput"><?php echo link_to($related, $related->getUrl(), 'class=inherit-font t_orange t_bold hover target=blank') ?>
                            <?php echo input_hidden_tag('rel', $sf_params->get('rel'))?></dd>
                        <?php else: ?>
                        <dt><?php echo emt_label_for('rourl', __('Related Url')) ?></dt>
                        <dd><?php echo input_tag('rourl', $sf_params->get('rourl')) ?></dd>
                        <?php endif ?>
                        <dt><?php echo emt_label_for('_subject', __('Subject')) ?></dt>
                        <dd><?php echo input_tag('_subject', $sf_params->get('_subject')) ?></dd>
                        <dt><?php echo emt_label_for('_message', __('Message')) ?></dt>
                        <dd><?php echo textarea_tag('_message', $sf_params->get('_message'), 'cols=50 rows=6') ?></dd>
                        <dt></dt>
                        <dd><?php echo submit_tag(__('Send Message'), 'class=green-button') ?></dd>
                    </dl>
                    </form>
                    <?php endif ?>
                <?php endif?>
                </section>
            </div>
            <div class="hrsplit-1"></div>
            <div class="box_285">
                <h5><?php echo __('Location Map') ?></h5>
                <div class="_noBorder">
        <?php if ($address): ?>
        <?php $addr[] = $address->getStreet() ?>
        <?php $addr[] = $address->getCity() ?>
        <?php $addr[] = $address->getGeonameCity() ?>
        <?php $addr[] = $address->getPostalCode() ?>
        <?php $addr[] = $address->getCountry() ?>
        <?php $str = urlencode(implode(',', $addr)) ?>
                    <?php echo link_to(image_tag("http://maps.google.com/maps/api/staticmap?zoom=6&size=270x150&maptype=roadmap&markers=color:red|$str&sensor=true"), "http://maps.google.com/?q=$str", array('target' => 'blank', 'title' => __('Click to view location in Google Maps'))) ?>
                    <div><em class="t_grey" style="font-size: 11px;"><?php echo __('Click the map to view location on Google Maps.') ?></em></div>
        <?php endif ?>
                </div>
            </div>
            <div class="box_285">
                <h5><?php echo __('Contact Information') ?></h5>
                <div class="_noBorder">
                    <div class="pad-1">
                    <strong><?php echo __('Address:') ?></strong>
                    <?php echo implode(', ', $addr) ?>
                    </div>
                    <div class="pad-1">
                    <?php if ($phone): ?>
                    <strong><?php echo __('Phone:') ?></strong>
                    <?php echo $phone->getPhone() ?>
                    </div>
                    <div class="pad-1">
                    <?php endif ?>
                    <strong><?php echo __('Website:') ?></strong>
                    <?php echo $group->getUrl() ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if ($own_group): ?>
            <?php include_partial('owner_actions', array('group' => $group)) ?>
            <?php endif ?>
            
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $group)) ?>
                </div>
            </div>

        </div>

    </div>
</div>