            <ul class="_side">
                <li<?php echo checkActivePage('@edit-company-profile', null) ?>><?php echo link_to(__('Profile Contents'), "@edit-company-profile?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@upload-company-logo', null) ?>><?php echo link_to(__('Company Logo'), "@upload-company-logo?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@company-corporate', null) ?>><?php echo link_to(__('Corporate Information'), "@company-corporate?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@company-contact', null) ?>><?php echo link_to(__('Contact Details'), "@company-contact?hash={$company->getHash()}") ?></li>
            </ul>