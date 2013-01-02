<div class="col_948">

    <div class="presentation">

        <div class="boxContent tabs">

            <dl class="_premium-services" style="display: block; ">
                <dt><?php echo __('Premium Services') ?></dt>
                <dd>
                    <?php echo __('Take your business to the level it deserves.') ?>
                </dd>
            </dl>

        </div>
        <div class="hrsplit-3"></div>

        <div class="boxContent _noTitle noBorder">
            <q>
                <?php echo __('Premium Services provide you a wide range of business opportunities which improves your reachability and profitability.') ?>
            </q>
            <dl class="_table">
                <dt><?php echo image_tag('layout/icon/large/medal_blue.png') ?></dt>
                <dd style="width: 700px;"><h2><?php echo __('Prove your Reliability with emtTrust') ?><sup>®</sup></h2>
                    <p><?php echo __('A Premium Member is verified at their business location prior to the confirmation of its eligibility. emtTrust, provides eMarketTurkey sellers and buyers protect themselves from fraudulent quotations.') ?></p>
                </dd>
                <dt><?php echo image_tag('layout/icon/large/search_blue.png') ?></dt>
                <dd style="width: 700px;"><h2><?php echo __('Better reachability performance') ?></h2>
                    <p><?php echo __('Premium Service members have a higher reachability score than other members. Because, Premium Service members are listed prior to other members in search results and category pages. As a result of this potential customers will find you more easily and contact you more frequently.') ?></p>
                </dd>
                <dt><?php echo image_tag('layout/icon/large/chart-up_green.png') ?></dt>
                <dd style="width: 700px;"><h2><?php echo __('The very first step for more profitable connections') ?></h2>
                    <p><?php echo __('eMarketTurkey provides valued trading services to its Premium Members. Some of these services include; <b>Buyer-Seller Matching</b>, <b>Marketing Support</b>, <b>Regional Market Research</b>, <b>Remote Product Audit</b>, etc.. Premium Services, reduces operational costs of organisations on global trade tasks.') ?></p>
                </dd>
                <dt><?php echo image_tag('layout/icon/large/shapes_blue.png') ?></dt>
                <dd style="width: 700px;"><h2><?php echo __('Wide Range of Business Services in one place') ?></h2>
                    <p><?php echo __('We provide a group of Business Services to our valued Premium Members. By upgrading to Premium Services, members get service packages like emtTrust, Job Posts, Online Translation Service, Unlimited Product Listing, CV Database Search, etc..') ?></p>
                </dd>
                <dt><?php echo image_tag('layout/icon/large/user_yellow.png') ?></dt>
                <dd style="width: 700px;"><h2><?php echo __('Professional support by a Corporate Representative dedicated to your Company') ?></h2>
                    <p><?php echo __('Premium Members have an advantage of getting direct support from an eMarketTurkey Corporate Representative on any topic like; Performing Negotiations with Buyers/Sellers, Getting Trading Support Services, etc..') ?></p>
                </dd>
            </dl>
            <div class="txtCenter margin-t2">
                <?php echo link_to(__('Compare Premium Account Types'), "@premium-compare", 'class=green-button') ?>
            </div>
        <div class="box_678 noBorder" style="float: none; margin: 50px auto 0;">
                <h4><?php echo __('Need More Information?')?></h4>
                <div>
                    <p class="pad-3"><?php echo __('Please fill in the form below and we will contact you regarding our Premium Services.') ?></p>
                    <div id='crmWebToEntityForm' align=center>
                        <form action='https://crm.zoho.com/crm/WebToLeadForm' name=WebToLeads695090000000053037 method='POST' onSubmit='javascript:document.charset="UTF-8"; return checkMandatery()' accept-charset='UTF-8'>
                            <input type='hidden' name='xnQsjsdp' value=YCm8KjqT-AJthYo*kRl79w$$/>
                            <input type='hidden' name='xmIwtLD' value=B-OVfTFfSyZtQkCwOFwd*PKHA-X**-ls/>
                            <input type='hidden' name='actionType' value=TGVhZHM=/>
                            <input type='hidden' name='returnURL' value='http://www.emarketturkey.com/thankyou' />
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
                                <dt><?php echo emt_label_for('LEADCF4', __('Membership Type')) ?></dt>
                                <dd><?php echo select_tag('LEADCF4', options_for_select(array('' => __('Not Decided'), 'Gold Membership' => __('Gold Membership'), 'Platinum Membership' => __('Platinum Membership')))) ?></dd>
                                <dt><?php echo emt_label_for('Description', __('Notes')) ?></dt>
                                <dd class="margin-b2"><?php echo textarea_tag('Description', '', 'cols=50 rows=3 max-length=1000') ?></dd>
                                <dt></dt>
                                <dd class="margin-t2"><?php echo submit_tag(__('Post Information'), 'class=green-button name=Save id=Save') ?>&nbsp;&nbsp;
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