<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('messages/toolbar', array('sesuser' => $sesuser, 'props' => $props, 'account' => $account, 'folder' => $folder, 'accparam' => $accparam, 'message' => $message)) ?>

    <div class="col_180">

<?php include_partial('messages/leftmenu', array('sesuser' => $sesuser, 'account' => $account, 'folders' => $folders, 'folder' => $folder, 'accparam' => $accparam)) ?>

    </div>

    <div class="col_576">

        <div class="box_576 _titleBG_Transparent">
            <section>
                <div class="_datetime _right"><span class="ln-example"><?php echo format_datetime($message->getCreatedAt('U'), 'f') ?></span></div>
                <table class="_message">
                    <tr>
                        <th><?php echo emt_label_for('sender', __('Sender')) ?></th>
                        <td><?php echo link_to($message->getSender(), $message->getSender()->getProfileUrl(), 'class=inherit-font bluelink hover') ?></td>
                    </tr>
                    <tr>
                        <th><?php echo emt_label_for('recipient', __('Recipient')) ?></th>
                        <td><?php $recips = array() ?>
                        <?php foreach ($recipients as $recip): ?>
                        <?php $recips[] = link_to($recip->getRecipient(), $recip->getRecipient()->getProfileUrl(), 'class=inherit-font bluelink hover') ?>
                        <?php endforeach ?>
                        <?php echo implode(', ', $recips)?></td>
                    </tr>
                    <tr class="subject">
                        <th><?php echo emt_label_for('subject', __('Subject')) ?></th>
                        <td><?php echo $message->getSubject() ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="body"><?php echo myTools::format_text($message->getBody()) ?></td>
                    </tr>
                    </table>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>
</div>