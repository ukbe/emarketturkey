    <li class="column span-10 first"></li>
    <li class="column span-110"><?php echo checkbox_tag('languages[]', $culture, (in_array($culture, $sf_params->get('languages', array())) || $group->hasLsiIn($culture)), array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-110" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo (in_array($culture, $sf_params->get('languages', array())) || $group->hasLsiIn($culture))?'':' style="display: none;"' ?>>
        <ol class="column span-110" style="padding: 0px;margin: 0px;">
            <li class="column span-36 first right"><?php echo emt_label_for('group_displayname_'.$culture, __('Display Name')) ?></li>
            <li class="column span-72 prepend-2"><?php echo input_tag('group_displayname_'.$culture, $sf_params->get('group_displayname_'.$culture, $group->getDisplayName($culture)), 'size=50 maxlength=255') ?></li>
            <li class="column span-36 first right official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost-sub':'' ?>"><?php echo emt_label_for('group_abbreviation_'.$culture, __('Abbreviation')) ?></li>
            <li class="column span-72 prepend-2 official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost-sub':'' ?>"><?php echo input_tag('group_abbreviation_'.$culture, $sf_params->get('group_abbreviation_'.$culture, $group->getAbbreviation($culture)), 'size=10 maxlength=50') ?></li>
            <li class="column span-36 first right"><?php echo emt_label_for('group_introduction_'.$culture, __('Introduction')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('group_introduction_'.$culture, $sf_params->get('group_introduction_'.$culture, $group->getIntroduction($culture)), 'cols=52 rows=4 maxlength=2000') ?></li>
            <li class="column span-36 first right"><?php echo emt_label_for('group_member_profile_'.$culture, __('Member Profile')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('group_member_profile_'.$culture, $sf_params->get('group_member_profile_'.$culture, $group->getMemberProfile($culture)), 'cols=52 rows=4 maxlength=2000') ?></li>
            <li class="column span-36 first right"><?php echo emt_label_for('group_events_'.$culture, __('Events Description')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('group_events_'.$culture, $sf_params->get('group_events_'.$culture, $group->getEventsIntroduction($culture)), 'cols=52 rows=4 maxlength=2000') ?></li>
        </ol>
    </div></li>