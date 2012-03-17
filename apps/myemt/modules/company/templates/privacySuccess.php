<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('company/account', array('company' => $company)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4><?php echo __('Privacy Settings') ?></h4>
            
                <p><?php echo __('You may edit your privacy preferences for your company anytime by using the controls below.') ?></p>
                <?php echo form_tag('@setup-privacy', 'class=focusing') ?>
                <div class="save-block">
                    <span class="fade"><?php echo __('Please click Save Changes button to apply your settings') ?></span>
                    <?php echo submit_tag(__('Save Changes'), 'class=focusing') ?>
                </div>
                <?php $actions = ActionPeer::getActionsAs(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_USER, true, $view_filter); ?>
                <div class="switched _off">
                    <h3 class="margin-t0">
                        <div class="_right"><span class="_on"><?php echo __('Accessible') ?></span>
                                            <span class="_off"><?php echo __('Inaccessible') ?></span>
                                            <?php echo checkbox_tag('profile_status', 1, $prmatrix[ActionPeer::ACT_VIEW_PROFILE]['X'] != 0) ?>
                                            <?php echo label_for('profile_status', '&nbsp;') ?></div>
                        <?php echo __('Profile Status') ?>
                    </h3>
                    <div class="_body">
                        <dl class="_table">
                            <dt><?php echo label_for('profile_viewer', __('Who can view your profile')) ?></dt>
                            <dd><?php echo select_tag('profile_viewer', options_for_select(array(RolePeer::RL_ALL => __('Anybody'), RolePeer::RL_NETWORK_MEMBER => __('People in My Network')), $prmatrix[ActionPeer::ACT_VIEW_PROFILE]['X'])) ?></dd>
                        </dl>
                        <br class="clear" />
                        <br class="clear" />
                        <?php echo __('Select who you want to allow to see specific information:') ?>
                        <table class="prefs">
                        <?php foreach ($actions as $act): ?>
                        <?php $v = isset($prmatrix[$act->getId()]) && isset($prmatrix[$act->getId()]['X']) ? $prmatrix[$act->getId()]['X'] : 0 ?>
                            <tr>
                                <th><?php echo $act->getName() ?>
                                    <?php echo input_hidden_tag('pa_act[]', $act->getId()) ?></th>
                                <td class="td-all"><?php echo radiobutton_tag("pa_opt_{$act->getId()}", RolePeer::RL_ALL, $v == RolePeer::RL_ALL, array('id' => "pa_opt_{$act->getId()}_all", 'alt' => __('Anybody'))) ?>
                                    <?php echo label_for("pa_opt_{$act->getId()}_all", __('Anybody')) ?></td>
                                <td class="td-network"><?php echo radiobutton_tag("pa_opt_{$act->getId()}", RolePeer::RL_NETWORK_MEMBER, $v == RolePeer::RL_NETWORK_MEMBER, array('id' => "pa_opt_{$act->getId()}_network", 'alt' => __('People in My Network'))) ?>
                                    <?php echo label_for("pa_opt_{$act->getId()}_network", __('People in My Network')) ?></td>
                                <td class="td-none"><?php echo radiobutton_tag("pa_opt_{$act->getId()}", RolePeer::RL_SELF, $v == RolePeer::RL_SELF, array('id' => "pa_opt_{$act->getId()}_none", 'alt' => __('Nobody'))) ?>
                                    <?php echo label_for("pa_opt_{$act->getId()}_none", __('Nobody')) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </table>
                    </div>
                </div>

                <br class="clear" />

                <?php $actions = ActionPeer::getActionsAs(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_USER, true, $intr_filter) ?>
                <div class="switched">
                    <h3 class="margin-t0"><?php echo __('Interactivity') ?></h3>
                    <div class="_body">
                        <?php echo __('Select the way others interact with you:') ?>
                        <table class="prefs">
                        <?php foreach ($actions as $act): ?>
                        <?php $v = isset($prmatrix[$act->getId()]) && isset($prmatrix[$act->getId()]['X']) ? $prmatrix[$act->getId()]['X'] : 0 ?>
                            <tr>
                                <th><?php echo $act->getName() ?></th>
                                <td class="td-all"><?php echo radiobutton_tag("pa_opt_{$act->getId()}", RolePeer::RL_ALL, $v == RolePeer::RL_ALL, array('id' => "pa_opt_{$act->getId()}_all", 'alt' => __('Anybody'))) ?>
                                    <?php echo label_for("pa_opt_{$act->getId()}_all", __('Anybody')) ?></td>
                                <td class="td-network">
                                    <?php if ($act->getId() != ActionPeer::ACT_ADD_TO_NETWORK): ?>
                                    <?php echo radiobutton_tag("pa_opt_{$act->getId()}", RolePeer::RL_NETWORK_MEMBER, $v == RolePeer::RL_NETWORK_MEMBER, array('id' => "pa_opt_{$act->getId()}_network", 'alt' => __('People in My Network'))) ?>
                                    <?php echo label_for("pa_opt_{$act->getId()}_network", __('People in My Network')) ?>
                                    <?php endif ?></td>
                                <td class="td-none"><?php echo radiobutton_tag("pa_opt_{$act->getId()}", RolePeer::RL_SELF, $v == RolePeer::RL_SELF, array('id' => "pa_opt_{$act->getId()}_none", 'alt' => __('Nobody'))) ?>
                                    <?php echo label_for("pa_opt_{$act->getId()}_none", __('Nobody')) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </table>
                    </div>
                </div>

                <div class="save-block">
                    <span class="fade"><?php echo __('Please click Save Changes button to apply your settings') ?></span>
                    <?php echo submit_tag(__('Save Changes')) ?>
                </div>
                </form>
                <style>
dl._table {
 margin:0 0 10px;
 font-size:12px;
 clear:both;
 width:98%;
}

dl._table dt {
 float:left;
 clear:both;
 display:block;
 width:120px;
 margin-right:15px;
 padding:5px;
 font-weight:bold;
 text-align:right;
}

dl._table dd {
 display:block;
 float: left;
 width:auto;
 margin:1px 0 0;
 padding:5px 0;
}

body ._right {float:right}
body ._left {float:left}
body .clear { float:none;display:block;clear:both; }

                    .prefs { width: 100%; }
                    .prefs th { font: 12px tahoma; color: #647199; text-align: left; vertical-align: middle; padding: 7px 5px; }
                    .prefs td {font: 13px tahoma; color: #3d3e3f; text-align: left; vertical-align: middle; padding: 7px 5px; }
                    .prefs tr:nth-child(even) { background-color: #f8f8f8; } 
                    .prefs tr:nth-child(odd) { background-color: #fefefe; } 
                    .prefs tr:hover { background-color: #e5e5f7; } 
                    .prefs label {width: 0px; height: 15px; padding: 0px; margin: 0 auto; display: inline; cursor: pointer; }
                    
                    .switched { -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px; border: solid 1px #e7e7e7; clear: both; }
                    .switched h3 * { display: inline-block; vertical-align: middle; }
                    .switched h3 ._on { display: inline-block; }
                    .switched h3 ._off { display: none; }
                    .switched div._body{ padding: 10px; border-width: 1px 0px 0px 0px; border-color: #e7e7e7; border-style: solid;  }
                    .switched h3 { background-color: #fff; font: 14px tahoma; color: #000; padding: 10px 10px; border-width: 0px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;  }
                    .switched h3 div._right { margin-top: -1px; font: 16px arial; color: #b1b1b1; }
                    .switched._off h3 ._on { display: none; }
                    .switched._off h3 ._off { display: inline-block; }
                    .switched._off div._body{ display: none; }
                    .switched._off h3 { border-width: 0px; }
                    .switched .custom-checkbox label { padding-left: 80px; background-image: url(/images/layout/background/switch-on-off.png); height: 20px; }
                    .switched ._body { clear: both; }
                    .switched ._body dl { clear: both; width: 500px; }
                    .switched ._body dl dt { width: auto; }
                    .switched ._body dl dd { }

                    .save-block { padding: 0px; text-align: right; margin: 10px 0px; }
                    .save-block .fade { display: none; font: 400 13px 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; }
                    .save-block.bold { padding: 10px; background-color: #ddd; }
                    .save-block.bold .fade { display: inline; }
                    .save-block input[type=button], 
                    .save-block input[type=submit] { -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; background-color: transparent; padding: 0px; font: 400 12px 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; color: #5b8fca; cursor: pointer; border: solid 1px transparent; }
                    .save-block.bold input[type=button], 
                    .save-block.bold input[type=submit] { background-color: #e00000; padding: 4px 6px; color: #fff; border: solid 1px #e64f4f; }

/* wrapper divs */
.custom-checkbox, 
.custom-radio { position: relative; margin-left:15px;}
    
/* input, label positioning */
.custom-checkbox input, 
.custom-radio input {
 position: absolute;
 left: -1em;
 top: 0.50em;
 margin:0;
 z-index:0;
 visibility:hidden;
}

.custom-checkbox label, 
.custom-radio label {
 display: block;
 position: relative;
 z-index: 1;
 cursor: pointer;
 padding-left: 15px;
}

.custom-checkbox label {
    background: url(/images/layout/background/checkbox.gif) no-repeat;
}

.custom-radio label { 
    background: url(/images/layout/background/radiobutton.gif) no-repeat; 
}
    
/* states */

.custom-checkbox label, .custom-radio label {
 background-position: -10px -14px;
}

.custom-checkbox label.hover,
.custom-checkbox label.focus,
.custom-radio label.hover,
.custom-radio label.focus {
 background-position: -10px -114px;
}

.custom-checkbox label.checked, 
.custom-radio label.checked {
 background-position: -10px -214px;
}

.custom-checkbox label.checkedHover, 
.custom-checkbox label.checkedFocus {
 background-position: -10px -314px;
}

.custom-checkbox label.focus, 
.custom-radio label.focus {
 outline: 1px dotted #ccc;
}
                 </style>
<?php use_javascript('jquery.customCheckbox.js'); ?>
<?php echo javascript_tag("

    var p_switch = jQuery('.switched > h3 input')
    
    p_switch.click(function(){
        if (jQuery(this).attr('checked') == 'checked') jQuery(this).closest('.switched').find('._body').slideDown(150, function(){ $(this).closest('.switched').removeClass('_off'); });
        else jQuery(this).closest('.switched').find('._body').slideUp(150, function(){ $(this).closest('.switched').addClass('_off'); });
    }).customInput();

    if (p_switch.attr('checked') == 'checked') p_switch.closest('.switched').removeClass('_off');
    else p_switch.closest('.switched').addClass('_off');
    
    var p_viewer = jQuery('#profile_viewer');
    p_viewer.change(function(){
        var p = jQuery(this).closest('.switched');
        if (jQuery(this).val() == 15) p.find('._body .td-all *').hide(); else if (jQuery(this).val() == 21) p.find('._body .td-all *').show();
    });
    
    if (p_viewer.val() == 15) p_viewer.closest('.switched').find('._body .td-all *').hide(); else if (p_viewer.val() == 21) p_viewer.closest('.switched').find('._body .td-all *').show();
    
    jQuery('form.focusing input, form.focusing select').change(function(){ jQuery(this).closest('form..focusing').find('.save-block').addClass('bold'); });
    
") ?>
            
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('company/upgradeBox', array('company' => $company)) ?>
    </div>

</div>