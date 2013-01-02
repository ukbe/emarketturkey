<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
    <header>
        <table>
            <tr>
                <td class="logo"><?php echo link_to(image_tag('emtlogo.gif', 'style=width:160px;'), '@homepage') ?></td>
                <td>
                    <ul class="_horizontal corporate-menu">
                        <li class="_right"><?php echo link_to(__('Back to eMarketTurkey'), !$sf_user->getUser()->isNew() ? '@myemt.homepage' : '@homepage', 'class=inherit-font bluelink hover') ?></li>
                        <li<?php echo ($module == 'corporate' && $action != 'contactus') || $module == 'press' ? ' class="selected"' : '' ?>><?php echo link_to(__('About eMarketTurkey'), "@aboutus", 'class=inherit-font hover') ?></li>
                        <li<?php echo $module == 'services' ? ' class="selected"' : '' ?>><?php echo link_to(__('Services'), "@services", 'class=inherit-font hover') ?></li>
                        <li<?php echo $module == 'support' ? ' class="selected"' : '' ?>><?php echo link_to(__('Support'), "@support", 'class=inherit-font hover') ?></li>
                        <li<?php echo $action == 'contactus' ? ' class="selected"' : '' ?>><?php echo link_to(__('Contact Us'), "@contactus", 'class=inherit-font hover') ?></li>
                    </ul>
                </td>
            </tr>
        </table>
        <div class="liner">
    </header>
