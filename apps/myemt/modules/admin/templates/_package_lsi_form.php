    <li class="column span-10 first"></li>
    <li class="column span-120"><?php echo checkbox_tag('languages[]', $culture, $active, array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo $active?'':' style="display: none;"' ?>>
        <ol class="column span-120" style="padding: 0px;margin: 0px;">
            <li class="column span-26 first right"><?php echo emt_label_for('package_name_'.$culture, __('Package Name')) ?></li>
            <li class="column span-92 prepend-2"><?php echo input_tag('package_name_'.$culture, $sf_params->get('package_name_'.$culture, $package->getName($culture)), 'size=50') ?></li>
            <li class="column span-26 first right"><?php echo emt_label_for('package_description_'.$culture, __('Description')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('package_description_'.$culture, $sf_params->get('package_description_'.$culture, $package->getDescription($culture)), 'cols=52 rows=3') ?></li>
        </ol>
    </div></li>