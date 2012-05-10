<?php use_helper('Cryptographp') ?>

<div class="col_948">

    <div class="col_180">

<?php include_partial('leftmenu')?>

    </div>

    <div class="col_576">
        <div class="box_576">
            <h4><?php echo __('Contact Us') ?></h4>
            <div class="_noBorder">
                <div class="hrsplit-3"></div>
                <p><?php echo __('Please do not hessitate to contact us on any subject.') ?></p>
                <?php if (isset($successtext)): ?>
                <p style="color: #006600"><b><?php echo __($successtext) ?></b></p>
                
                <?php else: ?>
                <?php echo __('You may send us your message using the contact form below.') ?>
                <div class="hrsplit-3"></div>
                
                <?php if (isset($errortext)): ?>
                <p style="color: #660000"><b><?php echo __($errortext) ?></b></p>
                <?php endif ?>
                
                <?php if (form_errors()): ?>
                <div class="hrsplit-1"></div>
                <?php echo form_errors() ?>
                <?php endif ?>
            </div>
            <section>
                <?php echo form_tag('corporate/contactus') ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('topic_id', __('Topic :')) ?></dt>
                    <dd><?php echo select_tag('topic_id', options_for_select($subject_list, $sf_params->get('topic_id', $topic), array('include_custom' => '-- ' . __('Please select a topic') . ' --'))) ?></dd>
                    <dt><?php echo emt_label_for('sender_name', __('Your Name and Lastname :')) ?></dt>
                    <dd><?php echo input_tag('sender_name', $sf_params->get('sender_name'), 'size=45') ?></dd>
                    <dt><?php echo emt_label_for('sender_email', __('Your E-mail Address :')) ?></dt>
                    <dd><?php echo input_tag('sender_email', $sf_params->get('sender_email'), 'size=45') ?></dd>
                    <dt><?php echo emt_label_for('message_text', __('Your Message :')) ?></dt>
                    <dd><?php echo textarea_tag('message_text', $sf_params->get('message_text'), 'cols=50 rows=4') ?></dd>
                    <?php if ($sesuser->isNew()): ?>
                    <dt></dt>
                    <dd><?php echo cryptographp_picture(); ?>&nbsp;
                        <?php echo cryptographp_reload(); ?></dd>
                    <dt></dt>
                    <dd><?php echo emt_label_for('verify_code', __('Please type the verification code seen above:')) ?></dd>
                    <dt></dt>
                    <dd><?php echo input_tag('verify_code', '', 'style=width: 100px;') ?></dd>
                    <?php endif ?>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Send Message'), 'class=green-button') ?></dd>
                </dl>
                <div class="hrsplit-2"></div>
                <table class="note">
                    <tr><td><?php echo __('Important Note:') ?></td>
                        <td><em><?php echo __('If you need information on a specific product, you should contact its supplier through contact form on supplier profile page.') ?></em></td>
                        </tr>
                </table>
                <?php endif ?>
            </section>
        </div>
        <div class="box_576">
            <h4><?php echo __('Head Office:') ?></h4>
            <div class="_noBorder">
                <p><?php echo __('EMTPORT Bilgi Teknolojileri A.Ş.') ?></p>
                <p><?php echo __('Mansuroğlu Mah. Cumhuriyet Cad. No:15/1<br />Bayraklı 35040 Izmir<br />TURKEY') ?></p>
                <br />
                <div class="hrsplit-3"></div>
            </section>
            </div>
        </div>

    </div>

</div>