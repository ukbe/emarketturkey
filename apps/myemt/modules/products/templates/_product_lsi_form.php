    <li class="column span-10 first"></li>
    <li class="column span-100"><?php echo checkbox_tag('languages[]', $culture, (in_array($culture, $sf_params->get('languages', array())) || $product->hasLsiIn($culture)), array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-100" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo (in_array($culture, $sf_params->get('languages', array())) || $product->hasLsiIn($culture))?'':' style="display: none;"' ?>>
        <ol class="column span-100" style="padding: 0px;margin: 0px;">
            <li class="column span-26 first right"><?php echo emt_label_for('displayname_'.$culture, __('Display Name')) ?></li>
            <li class="column span-72 prepend-2"><?php echo input_tag('displayname_'.$culture, $sf_params->get('displayname_'.$culture, $product->getDisplayName($culture)), 'size=50 maxlength=400') ?></li>
            <li class="column span-26 first right"><?php echo emt_label_for('product_introduction_'.$culture, __('Introduction')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('product_introduction_'.$culture, $sf_params->get('product_introduction_'.$culture, $product->getIntroduction($culture)), 'cols=52 rows=4 maxlength=1800') ?></li>
            <li class="column span-26 first right"><?php echo emt_label_for('packaging_'.$culture, __('Packaging')) ?></li>
            <li class="column span-72 prepend-2"><?php echo input_tag('packaging_'.$culture, $sf_params->get('packaging_'.$culture, $product->getPackaging($culture)), 'size=50 maxlength=200') ?></li>
        </ol>
    </div></li>