<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('messages/toolbar', array('sesuser' => $sesuser, 'props' => $props, 'account' => $account, 'folder' => $folder, 'accparam' => $accparam)) ?>

    <div class="col_180">

<?php include_partial('messages/leftmenu', array('sesuser' => $sesuser, 'account' => $account, 'folders' => $folders, 'folder' => $folder, 'accparam' => $accparam)) ?>

    </div>

    <div class="col_576">

        <div class="box_576 _titleBG_Transparent">
            <section>
                <?php echo form_errors() ?>
                <?php echo form_tag(url_for("@compose-message", true), 'id=mess-form') ?>
                <?php echo input_hidden_tag('_ref', $_ref) ?>
                <?php echo input_hidden_tag('mod', 'commit') ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('_s', __('Sender')) ?></dt>
                    <dd><?php echo select_tag('_s', options_for_select($senders, $sf_params->get('_s'))) ?></dd>
                    <dt><?php echo emt_label_for('_r', __('Recipient')) ?></dt>
                    <dd><div id="reco"></div></dd>
                    <dt><?php echo emt_label_for('_subject', __('Subject')) ?></dt>
                    <dd><?php echo input_tag('_subject', $sf_params->get('_subject')) ?></dd>
                    <dt><?php echo emt_label_for('_message', __('Message')) ?></dt>
                    <dd><?php echo textarea_tag('_message', $sf_params->get('_message'), 'cols=40 rows=4') ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Send Message'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), $cancel, 'class=inherit-font bluelink hover') ?></dd>
                </dl>
                </form>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>
</div>
<?php use_javascript("emt-dynalist-1.0.js")?>
<?php echo javascript_tag("
$(function() {
    $('#reco').dynalist({
        data: $recdata,
        autoCompleteConf: {url: '".url_for('@query-network', true)."', data: { scope: $('#_s').val() }},
        classMap: { TYPE_ID: {1: 'user-px', 2: 'company-px', 3: 'group-px'} },
        includeSpan: true, mapFields: {HASH: '_r[]'}
        });
});
") ?>