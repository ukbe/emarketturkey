            <ul class="_side">
                <li<?php echo checkActivePage('action=summary', null) ?>><?php echo link_to(__('Summary'), "@group-members?action=summary&hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=list', null) ?>><?php echo link_to(__('List Members'), "@group-members?action=list&hash={$group->getHash()}") ?></li><?php /* ?>
                <li<?php echo checkActivePage('action=messaging', null) ?>><?php echo link_to(__('Messaging'), "@group-members?action=messaging&hash={$group->getHash()}") ?></li><?php */ ?>
                <li<?php echo checkActivePage('action=demographics', null) ?>><?php echo link_to(__('Demographics'), "@group-members?action=demographics&hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=invite', null) ?>><?php echo link_to(__('Invite to Group'), "@group-members?action=invite&hash={$group->getHash()}") ?></li>
            </ul>
            </div>
            <div class="box_180 _titleBG_Transparent _side t_smaller">
            <h3><?php echo __('Search within Members') ?></h3>
            <div>
            <?php echo form_tag("@group-members?action=list&hash={$group->getHash()}") ?>
            <?php echo emt_label_for('mkeyword', __('Enter Keyword :')) ?>
            <?php echo input_tag('mkeyword', '', 'style=width: 120px;') ?>
            <?php echo submit_tag(__('Search')) ?>
            <?php echo link_to(__('Advanced Search'), '@homepage', 'class=bluelink hover ln-example') ?>
            </form>
            </div>
