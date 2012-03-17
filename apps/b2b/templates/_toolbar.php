<?php $search = array(PrivacyNodeTypePeer::PR_NTYP_COMPANY  => array(__('Companies'), url_for('@companies')),
                      PrivacyNodeTypePeer::PR_NTYP_PRODUCT  => array(__('Products'), url_for('@products')),
                      PrivacyNodeTypePeer::PR_NTYP_USER     => array(__('People'), url_for('@cm.people')),
                      PrivacyNodeTypePeer::PR_NTYP_GROUP    => array(__('Groups'), url_for('@cm.groups'))) ?>
<?php $srctyp = $sf_user->getAttribute('srctype', PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
<?php $srcdata = $search[$srctyp] ?>
<?php $js = array() ?> 
<div id="toolbar">
<div id="mainmenu">
<ol>
    <li><?php echo link_to(__('Home'), $sf_user->getUser() ? '@myemt.homepage' : '@lobby.homepage', array('onmouseover' => "jQuery('#myemtsub').show();".($sf_user->getUser() ? "jQuery(this).addClass('hover');" : ""), 'onmouseout' => "jQuery('#myemtsub').hide();".($sf_user->getUser() ? "jQuery(this).removeClass('hover');" : ""))) ?>
        <div class="jssubmenu" id="myemtsub" onmouseover="jQuery('#myemtsub').show();jQuery(this).siblings('a').addClass('hoversec');" onmouseout="jQuery('#myemtsub').hide();jQuery(this).siblings('a').removeClass('hoversec');">
            <?php if ($sf_user->getUser()): ?>
            <ol>
                <li><?php echo link_to(__('My Profile'), $sf_user->getUser()->getProfileUrl()) ?></li>
                <li><?php echo link_to(__('Edit Profile'), '@myemt.profile-edit') ?></li>
                <?php foreach ($sf_user->getUser()->getOwnerships() as $item): ?>
                <li><?php echo link_to($item, $item->getProfileUrl()) ?></li>
                <?php endforeach ?>
            </ol>
            <?php endif ?>
            </div></li>
    <li><?php echo link_to(__('B2B'), '@homepage', array('onmouseover' => "jQuery('#b2bsub').show();jQuery(this).addClass('hover');", 'onmouseout' => "jQuery('#b2bsub').hide();jQuery(this).removeClass('hover');", 'class' => 'selected')) ?>
        <div class="jssubmenu" id="b2bsub" onmouseover="jQuery('#b2bsub').show();jQuery(this).siblings('a').addClass('hoversec');" onmouseout="jQuery('#b2bsub').hide();jQuery(this).siblings('a').removeClass('hoversec');">
            <ol>
                <li><?php echo link_to(__('Companies'), '@companies') ?></li>
                <li><?php echo link_to(__('Products'), '@products') ?></li>
                <li><?php echo link_to(__('Selling Leads'), '@homepage') ?></li>
                <li><?php echo link_to(__('Buying Leads'), '@homepage') ?></li>
            </ol></div></li>
    <li><?php echo link_to(__('Jobs<b></b>'), '@hr.homepage', array('onmouseover' => "jQuery('#hrsub').show();jQuery(this).addClass('hover');", 'onmouseout' => "jQuery('#hrsub').hide();jQuery(this).removeClass('hover');")) ?>
        <div class="jssubmenu" id="hrsub" onmouseover="jQuery('#hrsub').show();jQuery(this).siblings('a').addClass('hoversec');" onmouseout="jQuery('#hrsub').hide();jQuery(this).siblings('a').removeClass('hoversec');">
            <ol>
                <li><?php echo link_to(__('My Career'), '@hr.mycareer') ?></li>
                <li><?php echo link_to(__('Job Search'), '@hr.homepage') ?></li>
            </ol></div></li>
    <li><?php echo link_to(__('Academy'), '@ac.homepage', array('onmouseover' => "jQuery('#acsub').show();jQuery(this).addClass('hover');", 'onmouseout' => "jQuery('#acsub').hide();jQuery(this).removeClass('hover');")) ?>
        <div class="jssubmenu" id="acsub" onmouseover="jQuery('#acsub').show();jQuery(this).siblings('a').addClass('hoversec');" onmouseout="jQuery('#acsub').hide();jQuery(this).siblings('a').removeClass('hoversec');">
            <ol>
                <li><?php echo link_to(__('Articles'), '@ac.articles') ?></li>
                <li><?php echo link_to(__('News'), '@ac.news-home') ?></li>
            </ol></div></li>
    <li><?php echo link_to(__('Community'), '@cm.homepage', array('onmouseover' => "jQuery('#cmsub').show();jQuery(this).addClass('hover');", 'onmouseout' => "jQuery('#cmsub').hide();jQuery(this).removeClass('hover');")) ?>
        <div class="jssubmenu" id="cmsub" onmouseover="jQuery('#cmsub').show();jQuery(this).siblings('a').addClass('hoversec');" onmouseout="jQuery('#cmsub').hide();jQuery(this).siblings('a').removeClass('hoversec');">
            <ol>
                <li><?php echo link_to(__('People'), '@cm.people') ?></li>
                <li><?php echo link_to(__('Groups'), '@cm.groups') ?></li>
            </ol></div></li>
    <li><?php echo link_to(__('Translation'), '@tx.homepage') ?></li>
    </ol>
    </div>
    <div style="text-align: right; float: right;">
        <div class="adv-search"><?php echo link_to(__('Advanced Search'), 'search/index') ?></div>
        <?php echo form_tag($srcdata[1], 'class=search method=get') ?>
        <ol class="searchbox">
            <li><?php echo link_to_function($srcdata[0], "jQuery('#select-src-type').toggle()", 'id=selected-src-type') ?>
                <ol id="select-src-type" class="ghost">
                <?php foreach ($search as $key => $data): ?>
                    <li><a href="#t<?php echo $key ?>"><?php echo $data[0] ?></a></li>
                    <?php $js[] = "t$key: {id: $key, url: '{$data[1]}'}" ?>
                <?php endforeach ?>
                </ol></li>
            <li style="padding: 0px;"><?php echo input_tag('keyword', '') ?></li>
            <li style="padding: 0px;"><?php echo submit_tag('&nbsp;') ?></li>
        </ol>
        </form>
    </div>
<?php echo javascript_tag("var  slinks={".implode(', ', $js)."};
jQuery('#select-src-type a').click(function(){jQuery('#selected-src-type').text(jQuery(this).text());jQuery('#select-src-type').toggle();jQuery('form.search').attr('action', slinks[jQuery(this).attr('href').substr(1)].url)});
") ?>
</div>