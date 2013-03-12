<div class="col_948" style="padding-top: 100px;">

    <div class="presentation">
    
    <?php if ($campaign): ?>
    <div class="premium-container">
        <h1><?php echo $campaign->getDisplayName() ?></h1>
    </div>
    <?php endif ?>
<?php $type = ($sf_params->get('type') == 'platinum' ? 1 : 2)?>
<?php $data = array(1 => array('platinum', $campaign ? __('Apply for Platinum Account') : __('Upgrade to Platinum Account'), __('<span class=to></span>Platinum Account'), 'Platinum Membership'),
                    2 => array('gold', $campaign ? __('Apply for Gold Account') : __('Upgrade to Gold Account'), __('<span class=to></span>Gold Account'), 'Gold Membership'),
                )?>
        <div class="box_678 noBorder banner" style="">
                <?php if (1==2): ?>
                <div class="float-logo"><?php echo image_tag('content/logo/igid-logo.png') ?></div>
                <?php endif ?>
                <h4><?php echo $data[$type][1] ?></h4>
                <div>
                    <p class="pad-3"><?php echo $campaign ? __('Please fill in the form below in order to apply for %1acctype.<br />We will contact you for further steps.', array('%1acctype' => $data[$type][2])) 
                                                          : __('Please fill in the form below in order to upgrade to %1acctype.<br />We will contact you for further steps.', array('%1acctype' => $data[$type][2])) ?></p>
                    <div id='crmWebToEntityForm' align=center>
                        <form action='https://crm.zoho.com/crm/WebToLeadForm' name=WebToLeads695090000000053037 method='POST' onSubmit='javascript:document.charset="UTF-8"; return checkMandatery()' accept-charset='UTF-8'>
                            <input type='hidden' name='xnQsjsdp' value=YCm8KjqT-AJthYo*kRl79w$$/>
                            <input type='hidden' name='xmIwtLD' value=B-OVfTFfSyZtQkCwOFwd*PKHA-X**-ls/>
                            <input type='hidden' name='actionType' value=TGVhZHM=/>
                            <input type='hidden' name='returnURL' value='http://www.emarketturkey.com/thankyou' />
                            <input type='hidden' name='LEADCF3' value='YES' />
                            <?php echo input_hidden_tag('LEADCF4', $data[$type][3]) ?>
                            <?php echo !$sesuser->isNew() ? input_hidden_tag('LEADCF1', $sesuser->getHash()) : '' ?>
                            <?php echo count($companies = $sesuser->getCompanies()) == 1 ? input_hidden_tag('LEADCF2', $companies[0]->getHash()) : '' ?>
                        <?php if ($campaign): ?>
                            <?php echo input_hidden_tag('Campaign', $campaign->getCode()) ?>
                            <?php include_partial("campaign_{$campaign->getCode()}_custom", array('campaign' => $campaign)) ?>
                        <?php endif ?>
                            <dl class="_table">
                                <dt class="_req"><?php echo emt_label_for('Company', __('Company Name')) ?></dt>
                                <dd><?php echo input_tag('Company', '', 'max-length=100') ?></dd>
                                <dt class="_req"><?php echo emt_label_for('First Name', __('Name')) ?></dt>
                                <dd><?php echo input_tag('First Name', '', 'max-length=40') ?></dd>
                                <dt class="_req"><?php echo emt_label_for('Last Name', __('Lastname')) ?></dt>
                                <dd><?php echo input_tag('Last Name', '', 'max-length=80') ?></dd>
                            <?php if (!$campaign): ?>
                                <dt><?php echo emt_label_for('Designation', __('Position Title')) ?></dt>
                                <dd><?php echo input_tag('Designation', '', 'max-length=100') ?></dd>
                            <?php endif ?>
                                <dt class="_req"><?php echo emt_label_for('Email', __('E-mail')) ?></dt>
                                <dd><?php echo input_tag('Email', '', 'max-length=100') ?></dd>
                                <dt class="_req"><?php echo emt_label_for('Phone', __('Phone')) ?></dt>
                                <dd><?php echo input_tag('Phone', '', 'max-length=30') ?></dd>
                                <dt><?php echo emt_label_for('Website', __('Website')) ?></dt>
                                <dd><?php echo input_tag('Website', '', 'max-length=120') ?></dd>
                            <?php if (!$campaign): ?>
                                <dt><?php echo emt_label_for('State', __('State/Province')) ?></dt>
                                <dd><?php echo input_tag('State', '', 'max-length=30') ?></dd>
                                <dt><?php echo emt_label_for('Country', __('Country')) ?></dt>
                                <dd><?php echo emt_select_country_tag('Country', '') ?></dd>
                            <?php endif ?>
                                <dt><?php echo emt_label_for('Description', __('Notes')) ?></dt>
                                <dd><?php echo textarea_tag('Description', '', 'cols=50 rows=3 max-length=1000') ?></dd>
                                <dt></dt>
                                <dd class="margin-t2"><?php echo submit_tag($campaign ? __('Apply') : __('Upgrade Account'), 'class=green-button name=Save id=Save') ?>&nbsp;&nbsp;
                                    <?php echo reset_tag(__('Clear Form')) ?></dd>
                            </dl> 
                            <script> var mndFileds=new Array(<?php if ($campaign->getCode() == 'tuskon.spr2013') echo "'Organization', "?>'Company', 'First Name', 'Last Name', 'Email', 'Phone');var fldLangVal=new Array(<?php if ($campaign->getCode() == 'tuskon.spr2013') echo '"'.__('Related Association').'", ' ?>"<?php echo __('Company Name') ?>", "<?php echo __('Name') ?>", "<?php echo __('Lastname') ?>", "<?php echo __('E-mail') ?>", "<?php echo __('Phone') ?>");function checkMandatery(){for(i=0;i<mndFileds.length;i++){ var fieldObj=document.forms['WebToLeads695090000000053037'][mndFileds[i]];if(fieldObj) {if(((fieldObj.value).replace(/^\s+|\s+$/g, '')).length==0){alert(("<?php echo __('%1field cannot be empty') ?>").replace('%1field', fldLangVal[i])); fieldObj.focus(); return false;}else if(fieldObj.nodeName=='SELECT'){if(fieldObj.options[fieldObj.selectedIndex].value == 'null'){alert(("<?php echo __('Please select %1field from list') ?>").replace('%1field', fldLangVal[i])); fieldObj.focus(); return false;}}}}}</script>  
                        </form>
                    </div>                
                </div>
            </div>
        </div>

    </div>

</div>
<style>
div.banner { float: none; position: relative; margin: 0px auto 0; background: url(/images/layout/background/premium-<?php echo $data[$type][0] ?>-xl.jpg) no-repeat; padding-top: 300px; overflow: visible; }
div.float-logo { position: absolute; display: inline-block; width: auto; float: left; top: -10px; left: -10px; opacity: .8; border: solid 2px #aaa !important; padding: 10px; border-radius: 3px; }
h1 { font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; font-size: 26px; line-height: 30px; color: #454545; }
div.premium-container { width: 896px; margin: 10px auto 0; border: none; text-align: center; }
.campaign-form { border: solid 1px #08c; padding: 10px 0px 10px; }
.campaign-form dd:last-child { margin-bottom: 10px; }
</style>