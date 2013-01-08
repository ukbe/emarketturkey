<?php $action = sfContext::getInstance()->getActionName(); $module = sfContext::getInstance()->getModuleName(); ?>
        <div class="box_180">
            <ul class="_side">
                <li<?php echo $action == 'overview' ? ' class="_on"' : '' ?>><?php echo link_to(__('Dashboard'), "@admin-action?action=overview") ?></li>
                <li<?php echo ($action == 'users' || $action == 'user') ? ' class="_on"' : '' ?>><?php echo link_to(__('Users'), "@admin-action?action=users") ?></li>
                <li<?php echo ($action == 'companies' || $action == 'company') ? ' class="_on"' : '' ?>><?php echo link_to(__('Companies'), "@admin-action?action=companies") ?></li>
                <li<?php echo ($action == 'groups' || $action == 'group') ? ' class="_on"' : '' ?>><?php echo link_to(__('Groups'), "@admin-action?action=groups") ?></li>
                <li<?php echo ($action == 'emailTransactions' || $action == 'emailTransaction') ? ' class="_on"' : '' ?>><?php echo link_to(__('E-mail Transactions'), "@admin-action?action=emailTransactions") ?></li>
                <li<?php echo ($action == 'paymentTerms' || $action == 'paymentTerm') ? ' class="_on"' : '' ?>><?php echo link_to(__('Payment Terms'), "@admin-action?action=paymentTerms") ?></li>
                <li<?php echo ($action == 'businessSectors' || $action == 'businessSector') ? ' class="_on"' : '' ?>><?php echo link_to(__('Business Sectors'), "@admin-action?action=businessSectors") ?></li>
                <li<?php echo ($action == 'businessTypes' || $action == 'businessType') ? ' class="_on"' : '' ?>><?php echo link_to(__('Business Types'), "@admin-action?action=businessTypes") ?></li>
                <li<?php echo ($action == 'mediaItems' || $action == 'mediaItem') ? ' class="_on"' : '' ?>><?php echo link_to(__('Media Items'), "@admin-action?action=mediaItems") ?></li>
                <li<?php echo ($action == 'jobGrades' || $action == 'jobGrade') ? ' class="_on"' : '' ?>><?php echo link_to(__('Job Grades'), "@admin-action?action=jobGrades") ?></li>
                <li<?php echo ($action == 'jobPositions' || $action == 'jobPosition') ? ' class="_on"' : '' ?>><?php echo link_to(__('Job Positions'), "@admin-action?action=jobPositions") ?></li>
                <li<?php echo ($action == 'products' || $action == 'product') ? ' class="_on"' : '' ?>><?php echo link_to(__('Products'), "@admin-action?action=products") ?></li>
                <li<?php echo ($action == 'announcements' || $action == 'announcement') ? ' class="_on"' : '' ?>><?php echo link_to(__('Announcements'), "@admin-action?action=announcements") ?></li>
            </ul>
        </div>