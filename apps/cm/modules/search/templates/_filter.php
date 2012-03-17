<div class="column span-39" style="border-right: solid 1px #CCCCCC;">
<em><?php echo __('Recent Searches') ?></em><br />
<?php echo form_tag('search/results', array('method' => 'GET')) ?>
<?php $ar  = $sf_user->getSearchTerms('search/'.$criterias['within']);
      //$ar = array_combine($ar, $ar);
        echo select_tag('keyword', options_for_select($ar, $criterias['keyword']), 'style="width:143px;border:solid 1px #DCF8B3; background: #F6FFEA;" onchange="submit()"') ?>
<?php echo input_hidden_tag('within', $criterias['within']) ?>
<noscript><?php echo submit_tag(_('Go')) ?></noscript>
</form>
<div class="hrsplit-1"></div>
<h3><?php echo __('Filter Results') ?></h3>
<ol class="column span-36 prepend-1 filter-list">
<?php $i = 0 ?>
<?php foreach ($filtercats as $cat => $data): ?>
<?php if ($i>0): ?>
<li class="spacer"></li>
<?php endif ?>
<?php $cname = get_class($data['class']) ?>
<li class="toggler" id="f<?php echo $cname ?>">
<?php echo link_to_function(image_tag('layout/icon/collapse-down.png'), "", "id=f{$cname}down class=c") ?>
<?php echo link_to_function(image_tag('layout/icon/collapse-right.png'), "", "id=f{$cname}right style=display:none; class=c") ?>
<?php echo link_to_function(__($cat), "") ?></li>
<?php $criteria = $criterias; ?>
<?php $criteria[$data['criteria']] = '' ?>
<li id="f<?php echo $cname.'all' ?>"<?php echo ($sf_params->get($data['criteria'])==''?' class="selected"':'') ?>><?php echo link_to(__('All') . ' ('. $data['total'] .')', $criterias['within']==PrivacyNodeTypePeer::PR_NTYP_GROUP ? '@groups' : '@people', array('query_string' => http_build_query($criteria))) ?></li>
<?php foreach ($data['results'] as $datum): ?>
<?php $criteria[$data['criteria']] = $datum['object']->getId() ?>
<li id="f<?php echo $cname.$i ?>"<?php echo ($sf_params->get($data['criteria'])==$datum['object']->getId()?' class="selected"':'') ?>><?php echo link_to($datum['object'] . ' ('.$datum['count'].')', $criterias['within']==PrivacyNodeTypePeer::PR_NTYP_GROUP ? '@groups' : '@people', array('query_string' => http_build_query($criteria))) ?></li>
<?php $i++ ?>
<?php endforeach ?>
<?php endforeach ?>
</ol>
<?php echo javascript_tag("
        
        jQuery('.toggler a').click(function(){
            jQuery('li[id^='+jQuery(this).parent().attr('id')+'],a[id^='+jQuery(this).parent().attr('id')+']').filter('[id!='+jQuery(this).parent().attr('id')+']').toggle();
        })
") ?>
</div>