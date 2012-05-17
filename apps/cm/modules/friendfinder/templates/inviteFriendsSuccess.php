<?php use_helper('Cryptographp', 'DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">
    <div class="box_762 _titleBG_Transparent" style="float: none; margin: 0 auto;">
        <div class="_noBorder">

            <div class="bubble ui-corner-all">
                <div style="background: url(/images/layout/address-book.png) 15px 10px no-repeat; background-size: 100px auto; padding: 0px 20px 15px 135px;">
                    <h4 class="noBorder"><?php echo __('Invite Friends') ?></h4>
                    
                    <?php if (isset($sent)): ?>
                    <div class="<?php echo $sent > 0 ? 't_green' : 't_red' ?>">
                    <?php echo format_number_choice('[0]No friends were invited|[1]1 friend was invited|(1,+Inf]%1% friends were invited', array('%1%' => $sent), $sent) ?>
                    </div>
                    <?php endif ?>
                    <?php echo form_errors() ?>
                    <div class="hrsplit-1"></div>
                    <?php echo form_tag('@invite-friends') ?>
                    <dl class="_table">
                        <dt><?php echo emt_label_for('emaillist', __('E-mail List')) ?></dt>
                        <dd><?php echo textarea_tag('emaillist', !(isset($sent) && $sent) ? $sf_params->get('emaillist') : '', 'cols=60 rows=6') ?>
                            <em class="ln-example"><?php echo __('Enter only one email address per line.') ?></em></dd>
                        <dt><?php echo emt_label_for('message', __('Invite Message')) ?></dt>
                        <dd><?php echo textarea_tag('message', !(isset($sent) && $sent) ? $sf_params->get('message') : '', 'cols=60 rows=6') ?>
                            <em class="ln-example"><?php echo __('Optional') ?></em></dd>
                        <dt><?php echo emt_label_for('cult', __('Invitation Language')) ?></dt>
                        <dd><?php echo select_tag('cult', options_for_select(array('tr' => 'Türkçe', 'en' => 'English'), $sf_params->get('cult'))) ?>
                            <em class="ln-example"><?php echo __('Invitation will be sent in selected language.') ?></em></dd>
                        <dt></dt>
                        <dd><?php echo submit_tag(__('Send Invitation'), 'class=green-button') ?></dd>
                    </dl>
                    </form>
                    <div class="hrsplit-1"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.box_762 dl._table dd { width: 424px; }
</style>