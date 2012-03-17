    <li class="column span-10 first"></li>
    <li class="column span-120"><?php echo checkbox_tag('languages[]', $culture, (in_array($culture, $sf_params->get('languages', array())) || $job->hasLsiIn($culture)), array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo (in_array($culture, $sf_params->get('languages', array())) || $job->hasLsiIn($culture))?'':' style="display: none;"' ?>>
        <ol class="column span-120" style="padding: 0px;margin: 0px;">
            <li class="column span-26 right"><?php echo emt_label_for('title_display_name_'.$culture, __('Display Name')) ?></li>
            <li class="column span-72 prepend-2"><?php echo input_tag('title_display_name_'.$culture, $sf_params->get('title_display_name_'.$culture, $job->getTitleDisplayName($culture)), 'size=50') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('description_'.$culture, __('Description')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('description_'.$culture, $sf_params->get('description_'.$culture, $job->getClob(JobI18nPeer::DESCRIPTION, $culture)), 'cols=70 rows=6') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('requirements_'.$culture, __('Requirements')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('requirements_'.$culture, $sf_params->get('requirements_'.$culture, $job->getClob(JobI18nPeer::REQUIREMENTS, $culture)), 'cols=70 rows=6') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('responsibility_'.$culture, __('Responsibility')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('responsibility_'.$culture, $sf_params->get('responsibility_'.$culture, $job->getClob(JobI18nPeer::RESPONSIBILITY)), 'cols=70 rows=6') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('html_'.$culture, __('HTML Content')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('html_'.$culture, $sf_params->get('html_'.$culture, $job->getClob(JobI18nPeer::HTML, $culture)), 'cols=70 rows=6') ?></li>
        </ol>
    </div></li>