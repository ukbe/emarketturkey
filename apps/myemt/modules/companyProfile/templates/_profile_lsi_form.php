    <li class="column span-10 first"></li>
    <li class="column span-110"><?php echo checkbox_tag('languages[]', $culture, (in_array($culture, $sf_params->get('languages', array())) || $profile->hasLsiIn($culture)), array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-110" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo (in_array($culture, $sf_params->get('languages', array())) || $profile->hasLsiIn($culture))?'':' style="display: none;"' ?>>
        <ol class="column span-110" style="padding: 0px;margin: 0px;">
            <li class="column span-36 right"><?php echo emt_label_for('introduction_'.$culture, __('Introduction')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('introduction_'.$culture, $sf_params->get('introduction_'.$culture, $profile->getClob(CompanyProfileI18nPeer::INTRODUCTION, $culture)), 'cols=52 rows=4') ?></li>
            <li class="column span-36 right"><?php echo emt_label_for('productservice_'.$culture, __('Products and Services')) ?></li>
            <li class="column span-72 prepend-2"><?php echo textarea_tag('productservice_'.$culture, $sf_params->get('productservice_'.$culture, $profile->getClob(CompanyProfileI18nPeer::PRODUCT_SERVICE, $culture)), 'cols=52 rows=4') ?></li>
        </ol>
    </div></li>