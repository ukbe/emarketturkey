    <li class="column span-10 first"></li>
    <li class="column span-120"><?php echo checkbox_tag('languages[]', $culture, $active, array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo $active?'':' style="display: none;"' ?>>
        <ol class="column span-120" style="padding: 0px;margin: 0px;">
            <li class="column span-26 right"><?php echo emt_label_for('author_display_name_'.$culture, __('Display Name')) ?></li>
            <li class="column span-92 prepend-2"><?php echo input_tag('author_display_name_'.$culture, $sf_params->get('author_display_name_'.$culture, $author->getDisplayName($culture)), 'size=50') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('author_description_'.$culture, __('Description')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('author_description_'.$culture, $sf_params->get('author_description_'.$culture, $author->getDescription($culture)), 'cols=52 rows=4') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('author_introduction_'.$culture, __('Introduction')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('author_introduction_'.$culture, $sf_params->get('author_introduction_'.$culture, $author->getIntroduction($culture)), 'cols=52 rows=4') ?></li>
        </ol>
    </div></li>