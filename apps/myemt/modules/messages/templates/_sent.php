<?php use_helper('Date') ?>
                <table class="message-list">
                    <tr><th></th>
                        <th><?php echo __('Title') ?></th>
                        <th><?php echo __('Recipient') ?></th>
                        <th><?php echo __('Sender') ?></th>
                        <th><?php echo __('Time') ?></th></tr>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo checkbox_tag("msg[]", $message->getPlug()) ?></td>
                        <td><?php echo link_to($message->getSubject(), $message->getUrl($account, $folder), 'class=inherit-font bluelink hover') ?></td>
                        <td class="snd"><span><?php echo implode(',', $message->getRecipientNames()) ?></span></td>
                        <td class="rec"><?php echo image_tag($message->getSender()->getProfilePictureUri(), array('title' => $message->getSender())) ?></td>
                        <td><?php echo format_date($message->getCreatedAt('U'), 'g') ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
