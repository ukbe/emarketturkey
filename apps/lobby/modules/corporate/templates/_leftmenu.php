<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li <?php echo $action == 'aboutus' ? 'class="selected"' : '' ?>><?php echo link_to(__('About Us'), "corporate/aboutus") ?></li>
                <li <?php echo $action == 'partners' ? 'class="selected"' : '' ?>><?php echo link_to(__('Partners'), "corporate/partners") ?></li>
                <li <?php echo $module == 'press' && $action == 'releases' ? 'class="selected"' : '' ?>><?php echo link_to(__('Press Releases'), "@press-releases") ?></li>
                <li <?php echo $action == 'stories' ? 'class="selected"' : '' ?>><?php echo link_to(__('Success Stories'), "corporate/stories") ?></li>
                <li <?php echo $action == 'privacy' ? 'class="selected"' : '' ?>><?php echo link_to(__('Privacy Policy'), "corporate/privacy") ?></li>
                <li <?php echo $action == 'terms' ? 'class="selected"' : '' ?>><?php echo link_to(__('Terms of Use'), "corporate/terms") ?></li>
                <li <?php echo $action == 'contactus' ? 'class="selected"' : '' ?>><?php echo link_to(__('Contact Us'), "corporate/contactus") ?></li>
            </ul>
        </div>