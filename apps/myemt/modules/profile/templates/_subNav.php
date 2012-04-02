    <header>
        <hgroup class="_comSel">
            <?php echo link_to(image_tag($sesuser->getProfilePictureUri()), "@edit-profile-picture", "class=_comMng_logo") ?>
            <ul class="_horizontal">
                <li><?php echo link_to(__('Go to Profile'), $sesuser->getProfileUrl()) ?></li>
                <li><?php echo link_to($sesuser->getProfilePicture() ? __('Change Photo') : __('Upload Photo'), "@edit-profile-picture") ?></li>
                <li class="_last_item"><?php echo link_to(__('Messages'), "@messages") ?></li>
            </ul>
            <dl>
                <dt>
                    <em><?php echo $sesuser ?></em>
                </dt>
                <dd>
                    <ul>
                        <?php $ocompanies = $sf_user->getUser()->getCompanies() ?>
                        <?php while (($ocomp = array_pop($ocompanies)) && $ocomp->getId() != $sesuser->getId()): ?>
                        <li><?php echo link_to($ocomp->getName(), $ocomp->getManageUrl()) ?></li>
                        <?php endwhile ?>
                        <li class="_bottom_comMng_links">
                            <?php echo link_to(__('Register Company'), "@register-comp", 'class=_right') ?>
                            <br class="clear" />
                        </li>
                    </ul>
                </dd>
            </dl>
        </hgroup>
        <nav>
            <dl id="subNav">
                <dt><a href=""><?php echo __('Control Panel') ?></a></dt>
                <dd<?php echo checkActivePage('@homepage', null, true, '_selected') ?>><?php echo link_to(__('Overview'), "@homepage") ?></dd>
                <dd<?php echo checkActivePage('module=contacts', null, true, '_selected') ?>><?php echo link_to(__('Contacts'), "@contacts") ?></dd>
                <dd<?php echo checkActivePage('@calender', null, true, '_selected') ?>><?php echo link_to(__('Calendar'), "@calendar") ?></dd>
                <dd<?php echo checkActivePage('@mycareer', null, true, '_selected') ?>><?php echo link_to(__('My Career'), "@mycareer") ?></dd>
                <dd class="ui-corner-tr<?php echo checkActivePage('module=account', null, false, '_selected') ?>"><?php echo link_to(__('Account'), "@account") ?></dd>
                <dd class="_sp <?php echo checkActivePage('@homepage', null, false, ' _selected') ?>"><?php echo link_to(__('INVITE FRIENDS'), "@homepage") ?></dd>
            </dl>
        </nav>
    </header>