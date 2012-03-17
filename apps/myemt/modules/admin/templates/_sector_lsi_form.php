    <li class="column span-10 first"></li>
    <li class="column span-100"><?php echo checkbox_tag('languages[]', $culture, $sector->hasLsiIn($culture), array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-100" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo $sector->hasLsiIn($culture)?'':' style="display: none;"' ?>>
        <ol class="column span-100" style="padding: 0px;margin: 0px;">
            <li class="column span-26 right"><?php echo emt_label_for('name_'.$culture, __('Display Name')) ?></li>
            <li class="column span-72 prepend-2"><?php echo input_tag('name_'.$culture, $sf_params->get('name_'.$culture, $sector->getName($culture)), 'size=50') ?></li>
        </ol>
    </div></li>