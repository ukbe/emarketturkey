    <li class="column span-10 first"></li>
    <li class="column span-120"><?php echo checkbox_tag('languages[]', $culture, $active, array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo $active?'':' style="display: none;"' ?>>
        <ol class="column span-120" style="padding: 0px;margin: 0px;">
            <li class="column span-26 right"><?php echo emt_label_for('service_name_'.$culture, __('Service Name')) ?></li>
            <li class="column span-92 prepend-2"><?php echo input_tag('service_name_'.$culture, $sf_params->get('service_name_'.$culture, $service->getName($culture)), 'size=50') ?></li>
        </ol>
    </div></li>