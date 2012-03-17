    <li class="column span-10 first"></li>
    <li class="column span-120"><?php echo checkbox_tag('languages[]', $culture, $active, array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo $active?'':' style="display: none;"' ?>>
        <ol class="column span-120" style="padding: 0px;margin: 0px;">
            <li class="column span-26 right"><?php echo emt_label_for('title_'.$culture, __('Title')) ?></li>
            <li class="column span-92 prepend-2"><?php echo input_tag('title_'.$culture, $sf_params->get('title_'.$culture, $news->getTitle($culture)), 'size=50') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('news_summary_'.$culture, __('Summary')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('news_summary_'.$culture, $sf_params->get('news_summary_'.$culture, $news->getSummary($culture)), 'cols=52 rows=4') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('news_introduction_'.$culture, __('Introduction')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('news_introduction_'.$culture, $sf_params->get('news_introduction_'.$culture, $news->getIntroduction($culture)), 'cols=52 rows=4') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('news_content_'.$culture, __('Content')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('news_content_'.$culture, $sf_params->get('news_content_'.$culture, $news->getBody($culture)), 'cols=65 rows=15') ?></li>
        </ol>
    </div></li>