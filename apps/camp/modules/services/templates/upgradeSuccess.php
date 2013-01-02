<div class="col_948" style="padding-top: 50px;">

    <div class="presentation">
<?php $type = ($sf_params->get('type') == 'platinum' ? 1 : 2)?>
<?php $data = array(1 => array('platinum', __('Upgrade to Platinum Account'), __('<span class=to></span>Platinum Account'), 'Platinum Membership'),
                    2 => array('gold', __('Upgrade to Gold Account'), __('<span class=to></span>Gold Account'), 'Gold Membership'),
                )?>
        <div class="box_678 noBorder" style="float: none; margin: 50px auto 0; background: url(/images/layout/background/premium-<?php echo $data[$type][0] ?>-xl.jpg) no-repeat; padding-top: 300px;">
                <h4><?php echo $data[$type][1] ?></h4>
                <div>
                    <p class="pad-3"><?php echo __('Please fill in the form below in order to upgrade to %1acctype.<br />We will contact you for further steps.', array('%1acctype' => $data[$type][2])) ?></p>
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
                            <dl class="_table">
                                <dt><?php echo emt_label_for('Company', __('Company Name')) ?></dt>
                                <dd><?php echo input_tag('Company', '', 'max-length=100') ?></dd>
                                <dt><?php echo emt_label_for('First Name', __('Name')) ?></dt>
                                <dd><?php echo input_tag('First Name', '', 'max-length=40') ?></dd>
                                <dt><?php echo emt_label_for('Last Name', __('Lastname')) ?></dt>
                                <dd><?php echo input_tag('Last Name', '', 'max-length=80') ?></dd>
                                <dt><?php echo emt_label_for('Designation', __('Position Title')) ?></dt>
                                <dd><?php echo input_tag('Designation', '', 'max-length=100') ?></dd>
                                <dt><?php echo emt_label_for('Email', __('E-mail')) ?></dt>
                                <dd><?php echo input_tag('Email', '', 'max-length=100') ?></dd>
                                <dt><?php echo emt_label_for('Phone', __('Phone')) ?></dt>
                                <dd><?php echo input_tag('Phone', '', 'max-length=30') ?></dd>
                                <dt><?php echo emt_label_for('Website', __('Website')) ?></dt>
                                <dd><?php echo input_tag('Website', '', 'max-length=120') ?></dd>
                                <dt><?php echo emt_label_for('State', __('State/Province')) ?></dt>
                                <dd><?php echo input_tag('State', '', 'max-length=30') ?></dd>
                                <dt><?php echo emt_label_for('Country', __('Country')) ?></dt>
                                <dd><?php echo emt_select_country_tag('Country', '') ?></dd>
                                <dt><?php echo emt_label_for('Description', __('Notes')) ?></dt>
                                <dd class="margin-b2"><?php echo textarea_tag('Description', '', 'cols=50 rows=3 max-length=1000') ?></dd>
                                <dt></dt>
                                <dd class="margin-t2"><?php echo submit_tag(__('Upgrade Account'), 'class=green-button name=Save id=Save') ?>&nbsp;&nbsp;
                                    <?php echo reset_tag(__('Clear Form')) ?></dd>
                            </dl> 
                            <script> var mndFileds=new Array('Company','Last Name');var fldLangVal=new Array('Company','Last Name');function checkMandatery(){for(i=0;i<mndFileds.length;i++){ var fieldObj=document.forms['WebToLeads695090000000053037'][mndFileds[i]];if(fieldObj) {if(((fieldObj.value).replace(/^\s+|\s+$/g, '')).length==0){alert(fldLangVal[i] +' cannot be empty'); fieldObj.focus(); return false;}else if(fieldObj.nodeName=='SELECT'){if(fieldObj.options[fieldObj.selectedIndex].value=='-None-'){alert(fldLangVal[i] +' cannot be none'); fieldObj.focus(); return false;}}}}}</script>  
                        </form>
                    </div>                
                </div>
            </div>
        </div>

    </div>

</div>