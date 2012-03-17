<?php use_helper('Date') ?>
<div class="col_948">

    <div class="col_180">
    <?php if ($photo = $resume->getPhoto()): ?>
        <div class="box_180 txtCenter">
            <a class="editable-image" href="<?php echo url_for('@mycv-action?action=materials') ?>">
                <?php echo image_tag($photo->getMediumUri()) ?>
                <span class="edittag"><?php echo __('Change Photo') ?></span>
            </a>
        </div>
    <?php endif ?>
        <div class="col_180">
<?php include_partial('mycareer/leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_576">

        <div class="box_576">
            <h4><?php echo __('Custom Information') ?></h3>
            <div class="_noBorder pad-0">
                <?php echo form_errors() ?>
                <?php echo form_tag('@mycv-action?action=custom') ?>
                <?php echo input_hidden_tag('done', __('Done')) ?>
                <?php echo input_hidden_tag('next', __('Next')) ?>
                <dl class="_survey">
                    <dt><?php echo __('Please specify your military service status?') ?></dt>
                    <dd>
                    <?php echo radiobutton_tag('rsmc_military_service', -1, $sf_params->get('rsmc_military_service', $resume->getMilitaryServiceStatus())===-1, 'id=rsmc_military_service_1') ?>
                    <?php echo emt_label_for('rsmc_military_service_1', __('Performed')) ?>
                    <?php echo radiobutton_tag('rsmc_military_service', 0, $sf_params->get('rsmc_military_service', $resume->getMilitaryServiceStatus())===0, 'id=rsmc_military_service_2') ?>
                    <?php echo emt_label_for('rsmc_military_service_2', __('Not Performed (not postponed)')) ?>
                    <div class="_left">
                    <?php echo radiobutton_tag('rsmc_military_service', -2, $sf_params->get('rsmc_military_service', $resume->getMilitaryServiceStatus())===-2 || $sf_params->get('rsmc_military_service', $resume->getMilitaryServiceStatus())>0, 'id=rsmc_military_service_3') ?>
                    <?php echo emt_label_for('rsmc_military_service_3', __('Postponed')) ?>
                        </div>
                    <div>
                    <?php echo select_tag('rsmc_milser_postponed_year', options_for_select(array('1' => __('1 year'), '2' => __('2 years'), '3' => __('3 years'), '4' => __('4 years'), '5' => __('5 years'), '100' => __('Uncertain')), $sf_params->get('rsmc_milser_postponed_year', $resume->getMilitaryServiceStatus()), array('include_custom' => __('please select'))), 
                            array('disabled' => ($sf_params->get('rsmc_military_service', $resume->getMilitaryServiceStatus()) !== -2 &&  $sf_params->get('rsmc_military_service', $resume->getMilitaryServiceStatus())<1) ? 'disabled' : '')) ?>
                        </div>
                        </dd>
                    <dt><?php echo __('Do you smoke?') ?></dt>
                    <dd>
                    <?php echo radiobutton_tag('rsmc_smoke', 1, $sf_params->get('rsmc_smoke', $resume->getSmokes()), 'id=rsmc_smoke_1') ?>
                    <?php echo emt_label_for('rsmc_smoke_1', __('Yes')) ?>
                    <?php echo radiobutton_tag('rsmc_smoke', 0, $sf_params->get('rsmc_smoke', !$resume->getSmokes()), 'id=rsmc_smoke_2') ?>
                    <?php echo emt_label_for('rsmc_smoke_2', __('No')) ?>
                        </dd>
                    <dt><?php echo __('Are you willing to relocate?') ?></dt>
                    <dd>
                    <?php echo radiobutton_tag('rsmc_relocate', 1, $sf_params->get('rsmc_relocate', $resume->getWillingToRelocate()), 'id=rsmc_relocate_1') ?>
                    <?php echo emt_label_for('rsmc_relocate_1', __('Yes')) ?>
                    <?php echo radiobutton_tag('rsmc_relocate', 0, $sf_params->get('rsmc_relocate', !$resume->getWillingToRelocate()), 'id=rsmc_relocate_2') ?>
                    <?php echo emt_label_for('rsmc_relocate_2', __('No')) ?>
                        </dd>
                    <dt><?php echo __('Are you willing to telecommute?') ?></dt>
                    <dd><?php echo radiobutton_tag('rsmc_telecommute', 1, $sf_params->get('rsmc_telecommute', $resume->getWillingToTelecommute()), 'id=rsmc_telecommute_1') ?>
                    <?php echo emt_label_for('rsmc_telecommute_1', __('Yes')) ?>
                    <?php echo radiobutton_tag('rsmc_telecommute', 0, $sf_params->get('rsmc_telecommute', !$resume->getWillingToTelecommute()), 'id=rsmc_telecommute_2') ?>
                    <?php echo emt_label_for('rsmc_telecommute_2', __('No')) ?>
                        </dd>
                    <dt><?php echo __('Please select the percentage you are willing to travel up to') ?></dt>
                    <dd>
                    <?php echo select_tag('rsmc_travel', options_for_select(array(0 => __('0% - No travel'), 
                                          1 => '10%', 2 => '20%', 3 => '30%', 4 => '40%', 5 => '50%', 6 => '60%', 7 => '70%', 8 => '80%', 9 => '90%', 1 => '100%'),
                                    $sf_params->get('rsmc_travel', $resume->getWillingToTravel()))) ?>
                        </dd>
                    <dt><?php echo __('Please select the vehicles which you hold a license to drive/ride; <em class="ln-example">(you may select multiple options)</em>') ?></dt>
                    <dd>
                    <?php echo checkbox_tag('rsmc_license_car', 1, $sf_params->get('rsmc_licence_car', $resume->getLicense(ResumePeer::RSM_LIC_POS_CAR))) ?>
                    <?php echo emt_label_for('rsmc_license_car', __('Car')) ?>
                    <?php echo checkbox_tag('rsmc_license_motorcycle', 1, $sf_params->get('rsmc_licence_motorcycle', $resume->getLicense(ResumePeer::RSM_LIC_POS_MCYCLE))) ?>
                    <?php echo emt_label_for('rsmc_license_motorcycle', __('Motorcycle')) ?>
                    <?php echo checkbox_tag('rsmc_license_bus', 1, $sf_params->get('rsmc_licence_bus', $resume->getLicense(ResumePeer::RSM_LIC_POS_BUS))) ?>
                    <?php echo emt_label_for('rsmc_license_bus', __('Bus')) ?>
                    <?php echo checkbox_tag('rsmc_license_truck', 1, $sf_params->get('rsmc_licence_truck', $resume->getLicense(ResumePeer::RSM_LIC_POS_TRUCK))) ?>
                    <?php echo emt_label_for('rsmc_license_truck', __('Truck')) ?>
                        </dd>
                    <dt><?php echo __('What is the amount of your desired salary?') ?></dt>
                    <dd>
                    <?php echo input_tag('rsmc_salary', $sf_params->get('rsmc_salary', $resume->getDesiredSalary()), 'style=width:100px;') ?>
                    <?php echo select_currency_tag('rsmc_currency', $sf_params->get('rsmc_currency', $resume->getSalaryCurrency()), array('include_custom' => __('select currency'))) ?>
                        </dd>
                </dl>
                <div class="txtCenter">
                    <?php echo link_to(__('Back'), '@mycv-action?action=basic', 'class=action-button _left')?>
                    <?php echo submit_tag(__('Next'), 'class=action-button _right')?>
                    <?php echo submit_tag(__('Done'), 'class=action-button')?>&nbsp;&nbsp;<?php echo link_to(__('Cancel'), '@mycv-action?action=review', 'class=bluelink hover') ?>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('cv-steps-right', array('sesuser' => $sesuser, 'resume' => $resume)) ?>
        
    </div>
</div>
<?php echo javascript_tag("
$(function(){
    $('dl._survey input').customInput();
    $('input[type=radio][name=\"rsmc_military_service\"]').click(function(){ if ($(this).val() == -2) $('#rsmc_milser_postponed_year').removeAttr('disabled'); else $('#rsmc_milser_postponed_year').attr('disabled', 'disabled'); });
});
") ?>