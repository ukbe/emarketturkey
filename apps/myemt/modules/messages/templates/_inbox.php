<?php use_helper('Date') ?>
                <table class="message-list">
                    <tr><th></th>
                        <th><?php echo __('Title') ?></th>
                        <th><?php echo __('Sender') ?></th>
                        <th><?php echo __('Recipient') ?></th>
                        <th><?php echo __('Date') ?></th></tr>
                <?php foreach ($messages as $message): ?>
                    <tr<?php echo !$message->getIsRead() ? ' class="unread"' : '' ?>>
                        <td><?php echo checkbox_tag("msg[]", $message->getMessage()->getPlug()) ?></td>
                        <td><?php echo link_to($message->getMessage()->getSubject(), $message->getMessage()->getUrl($account, $folder), 'class=inherit-font bluelink hover') ?></td>
                        <td class="snd"><?php echo $message->getMessage()->getSender() ?></td>
                        <td class="rec"><?php echo image_tag($message->getRecipient()->getProfilePictureUri(), array('title' => $message->getRecipient())) ?></td>
                        <td><?php echo format_date($message->getMessage()->getCreatedAt('U'), 'g') ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
