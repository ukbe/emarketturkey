    <li class="column span-10 first"></li>
    <li class="column span-120"><?php echo checkbox_tag('languages[]', $culture, $active, array('id' => 'lsi_check_'.$culture, 'onchange' => "if(this.checked){".visual_effect('appear', 'lsi_'.$culture)."}else{".visual_effect('fade', 'lsi_'.$culture)."}")).' '.image_tag('layout/flag/'.strtoupper($culture).'.png', 'height=14').' '.sfContext::getInstance()->getI18N()->getNativeName($culture) ?></li>
    <li class="column span-10 first"></li>
    <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
    <div id="lsi_<?php echo $culture ?>"<?php echo $active?'':' style="display: none;"' ?>>
        <ol class="column span-120" style="padding: 0px;margin: 0px;">
            <li class="column span-26 right"><?php echo emt_label_for('title_'.$culture, __('Title')) ?></li>
            <li class="column span-92 prepend-2"><?php echo input_tag('title_'.$culture, $sf_params->get('title_'.$culture, $article->getTitle($culture)), 'size=50') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('article_summary_'.$culture, __('Summary')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('article_summary_'.$culture, $sf_params->get('article_summary_'.$culture, $article->getSummary($culture)), 'cols=52 rows=4') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('article_introduction_'.$culture, __('Introduction')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('article_introduction_'.$culture, $sf_params->get('article_introduction_'.$culture, $article->getIntroduction($culture)), 'cols=52 rows=4') ?></li>
            <li class="column span-26 right"><?php echo emt_label_for('article_content_'.$culture, __('Content')) ?></li>
            <li class="column span-92 prepend-2"><?php echo textarea_tag('article_content_'.$culture, $sf_params->get('article_content_'.$culture, $article->getBody($culture)), 'cols=65 rows=15') ?></li>
        </ol>
    </div></li>