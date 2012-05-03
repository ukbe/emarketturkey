<?php use_helper('DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('subNav-start', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">

    <div class="col_678" style="margin-left: 100px;">
        <div class="box_678 _titleBG_Transparent">
            <div id="boxContent" class="_noBorder">
                <div class="hrsplit-3"></div>
                <?php if (isset($errorWhileSaving) && $errorWhileSaving == true): ?>
                <div id="error">
                    <h3><?php echo __('Error Occured!') ?></h3>
                    <div class="t_red pad-2">
                    <?php echo __('An error occurred while creating your group.<br />We are sorry for the inconvenience and working to work out the problem yet.') ?>
                    </div>
                </div>
                <div class="hrsplit-2"></div>
                <?php elseif (form_errors()): ?>
                <div><?php echo form_errors() ?></div>
                <div class="hrsplit-2"></div>
                <?php endif ?>
                <?php echo form_tag('group/start') ?>
                <?php echo input_hidden_tag('keepon', $sf_params->get('keepon')) ?>

                <dl class="_table signup">
                    <dt class="_req"><?php echo emt_label_for('group_publicity', __('Group Publicity')) ?></dt>
                    <dd class="L-floater">
                        <?php echo radiobutton_tag("group_publicity", GroupPeer::GRP_PBL_CLOSED, $sf_params->get("group_publicity") == GroupPeer::GRP_PBL_CLOSED, 'id=group_publicity_2') ?>
                        <?php echo emt_label_for("group_publicity_2", __(GroupPeer::$pblLabels[GRoupPeer::GRP_PBL_CLOSED]), ($sf_params->get("group_publicity") == GroupPeer::GRP_PBL_CLOSED ? 'class=selected' : '')) ?>
                        <?php echo radiobutton_tag("group_publicity", GroupPeer::GRP_PBL_OPEN, $sf_params->get("group_publicity") == GroupPeer::GRP_PBL_OPEN, 'id=group_publicity_1') ?>
                        <?php echo emt_label_for("group_publicity_1", __(GroupPeer::$pblLabels[GroupPeer::GRP_PBL_OPEN]), ($sf_params->get("group_publicity") == GroupPeer::GRP_PBL_OPEN ? 'class=selected' : '')) ?>
                       <em class="ln-example"><?php echo __('Select group publicity. Open Groups are available for everyone to join the group while Closed Groups require group owner to approve membership requests.') ?>
                        <?php echo help_link('community~groups~publicity', __('more info')) ?></em>
                    </dd>
                    <dt class="_req"><?php echo emt_label_for('group_type_id', __('Group Type')) ?></dt>
                    <dd><?php echo select_tag('group_type_id', options_for_select(GroupTypePeer::getOrderedNames(true), $sf_params->get('group_type_id'), array('include_custom' => '-- ' . __('select group type') . ' --')), array('onchange' => "if (this.value==".GroupTypePeer::GRTYP_ONLINE.") {jQuery('.official').slideUp();} else {jQuery('.official').slideDown();}")) ?>
                       <em class="ln-example"><?php echo __('Select a suitable group type.') ?></em></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_founded_in', __('Founded In')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo select_year_tag('group_founded_in', $sf_params->get('group_founded_in'), array('year_start' => date('Y'), 'year_end' => date('Y')-100, 'include_custom' => '-- ' . __('year') . ' --')) ?>
                       <em class="ln-example"><?php echo __('Select the year which your organisation was founded in.') ?></em></dd>
                </dl>
                <?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get('group_lang') : array($sf_user->getCulture())) as $key => $lang): ?>
                <dl class="_table signup ln-part">
                    <dt></dt>
                    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(__('remove'), '', "class=ln-removelink") ?></div></dd>
                    <dt class="_req"><?php echo emt_label_for("group_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
                    <dd><?php echo select_language_tag("group_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'group_lang[]', 'include_blank' => true)) ?></dd>
                    <dt></dt>
                    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
                    <dt class="_req"><?php echo emt_label_for("group_name_$key", __('Group Name')) ?></dt>
                    <dd><?php echo input_tag("group_name_$key", $sf_params->get("group_name_$key"), 'style=width:400px; size=50 maxlength=255') ?></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for("group_abbreviation_$key", __('Group Abbreviation')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo input_tag("group_abbreviation_$key", $sf_params->get("group_abbreviation_$key"), 'style=width:100px; maxlength=50') ?>
                       <em class="ln-example"><?php echo __('NASA') ?></em></dd>
                    <dt><?php echo emt_label_for("group_introduction_$key", __('Introduction')) ?></dt>
                    <dd><?php echo textarea_tag("group_introduction_$key", $sf_params->get("group_introduction_$key"), 'cols=52 rows=4 maxlength=2000 style=width:400px;') ?>
                       <em class="ln-example"><?php echo __('Tell us about your group.') ?></em></dd>
                    <dt><?php echo emt_label_for("group_member_profile_$key", __('Member Profile')) ?></dt>
                    <dd><?php echo textarea_tag("group_member_profile_$key", $sf_params->get("group_member_profile_$key"), 'style=width:400px; cols=52 rows=4 maxlength=2000') ?>
                       <em class="ln-example"><?php echo __("Describe your members' profile.") ?></em></dd>
                    <dt><?php echo emt_label_for("group_events_$key", __('Events Description')) ?></dt>
                    <dd><?php echo textarea_tag("group_events_$key", $sf_params->get("group_events_$key"), 'style=width:400px; cols=52 rows=4 maxlength=2000') ?>
                       <em class="ln-example"><?php echo __("Provide some information about your organisation's events, if available.") ?></em></dd>
                </dl>
                <?php endforeach ?>
                <dl class="_table signup">
                    <dt></dt>
                    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_country', __('Country')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo select_country_tag('group_country', $sf_params->get('group_country'), array('include_custom' => '-- ' . __('select country') . ' --')) ?></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_street', __('Street Address')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo input_tag('group_street', $sf_params->get('group_street'), 'style=width:400px; size=50 maxlength=255') ?>
                         <em class="ln-example"><?php echo __('54th Hallway Rd.') ?></em></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_state', __('State/Province')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo select_tag('group_state', options_for_select($contact_cities, $sf_params->get('group_state'), array('include_custom' => '-- ' . __('select state/province') . ' --'))) ?></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_postalcode', __('Postal Code')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo input_tag('group_postalcode', $sf_params->get('group_postalcode'), 'style=width:80px; size=10') ?>
                         <em class="ln-example"><?php echo __('54367') ?></em></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_city', __('City/Town')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo input_tag('group_city', $sf_params->get('group_city'), 'style=width:150px; size=25') ?>
                         <em class="ln-example"><?php echo __('Arlington') ?></em></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_phone', __('Phone Number')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo input_tag('group_phone', $sf_params->get('group_phone'), 'style=width:150px; size=20 maxlength=50') ?>
                         <em class="ln-example"><?php echo __('+66 666 6666666') ?></em></dd>
                    <dt><?php echo emt_label_for('group_url', __('Group Web Site')) ?></dt>
                    <dd><?php echo input_tag('group_url', $sf_params->get('group_url'), 'size=30 maxlength=255') ?>
                       <em class="ln-example"><?php echo __('http://www.groupsite.com') ?></em></dd>
                    <dt class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo emt_label_for('group_email', __('E-mail')) ?></dt>
                    <dd class="official<?php echo $is_online ? ' ghost' : '' ?>"><?php echo input_tag('group_email', $sf_params->get('group_email'), 'style=width:200px; size=30 maxlength=50') ?>
                       <em class="ln-example"><?php echo __("Group's public e-mail address.") ?></em></dd>
                    <dt>&nbsp;</dt>
                    <dd><?php echo __('By clicking Start Group, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'), '@lobby.terms', 'target=emt_terms class=inherit-font bluelink t_hover'), '%2s' => link_to(__('Privacy Policy'), '@lobby.privacy', 'target=emt_privacy class=inherit-font bluelink t_hover'))) ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Start Group'), 'class=green-button') ?></dd>
                </dl>
                </form>
            </div>
            <table class="_secured" style="margin: 0 auto;">
                <tr>
                    <td><?php echo __('You are secured with:')?></td>
                    <td class="margin-r2"><a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_s" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_s.png" alt="TRUSTe online privacy certification"/></a></td>
                    <td><!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=small&amp;seal_color=blue&amp;new=1&amp;newsmall=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code --></td>
                </tr>
            </table>
        </div>
        <div class="box_678 _titleBG_Transparent">
            <div class="_noBorder">

            </div>
        </div>
    </div>
</div>

<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222;
margin: 0px; padding: 5px 10px; border-bottom: none; }
dl._table.signup dt { width: 25%; }
dl._table.signup dd { width:  65%;}
</style>
<?php use_javascript('emt-location-1.0.js') ?>
<?php use_javascript('emt.langform-1.0.js') ?>
<?php use_javascript('jquery.customCheckbox.js') ?>
<?php echo javascript_tag("

    $('#group_country').location({url: '".url_for('@location-query', true)."'});

    $('#boxContent').langform();

    $('dl._table input').customInput();

    ") ?>