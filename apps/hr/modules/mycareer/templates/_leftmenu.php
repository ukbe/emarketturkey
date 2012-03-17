<?php $action = sfContext::getInstance()->getActionName() ?>
<?php $module = sfContext::getInstance()->getModuleName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_profile<?php echo $action == 'index' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Overview'), '@mycareer') ?></li>
                <li class="_cv<?php echo $module == 'mycv' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('My CV'), "@mycv-action?action=review") ?>
                <?php if ($module=='mycv'): ?>
                    <dl>
                        <dt><?php echo __('My CV Sections') ?></dt>
                        <dd><?php echo link_to(__('Basic Information'), '@mycv-action?action=basic', $action=='basic' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Contact Information'), '@mycv-action?action=contact', $action=='contact' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Education Status'), '@mycv-action?action=education', $action=='education' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Work Experience'), '@mycv-action?action=work', $action=='work' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Courses & Certificates'), '@mycv-action?action=courses', $action=='courses' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Languages'), '@mycv-action?action=languages', $action=='languages' ? 'class=selected' : '') ?></dd>
                        <?php /* ?>
                        <dd><?php echo link_to(__('Expertise and Skills'), '@mycv-action?action=skills', $action=='skills' ? 'class=selected' : '') ?></dd>
                        */  ?>
                        <dd><?php echo link_to(__('Publications'), '@mycv-action?action=publications', $action=='publications' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Awards & Honors'), '@mycv-action?action=awards', $action=='awards' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('References'), '@mycv-action?action=references', $action=='references' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Organisations'), '@mycv-action?action=organisations', $action=='organisations' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Custom Information'), '@mycv-action?action=custom', $action=='custom' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Materials'), '@mycv-action?action=materials', $action=='materials' ? 'class=selected' : '') ?></dd>
                    </dl>
                <?php endif ?>
                </li>
                <li class="_save<?php echo $action=='bookmarks' || $action=='employers' || $action=='jobs' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'._('Bookmarks'), "@mycareer-action?action=bookmarks") ?>
                <?php if ($action=='bookmarks' || $action=='employers' || $action=='jobs'): ?>
                    <dl>
                        <dt><?php echo __('Bookmarks') ?></dt>
                        <dd><?php echo link_to(__('Jobs'), '@myjobs', $action=='jobs' ? 'class=selected' : '') ?></dd>
                        <dd><?php echo link_to(__('Employers'), '@myemployers', $action=='employers' ? 'class=selected' : '') ?></dd>
                    </dl>
                <?php endif ?>
                </li>
            </ul>
        </div>
