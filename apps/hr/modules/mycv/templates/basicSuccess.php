<?php use_helper('Date') ?>
<div class="col_948">

    <div class="col_180">
    <?php if ($photo = $resume->getPhoto()): ?>
        <div class="box_180 txtCenter">
            <a class="editable-image" href="<?php echo url_for('@mycv-action?action=materials') ?>">
                <?php echo image_tag($photo->getMediumUri()) ?>
                <span class="edittag"><?php echo __('Change Photo') ?></span>
            </a>
        </div>
    <?php endif ?>
        <div class="col_180">
<?php include_partial('mycareer/leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_576">

        <div class="box_576">
            <h4><?php echo __('Basic Information') ?></h3>
            <div class="_noBorder pad-0">
                <?php echo form_errors() ?>
                <?php echo form_tag('@mycv-action?action=basic') ?>
                <?php echo input_hidden_tag('done', __('Done')) ?>
                <?php echo input_hidden_tag('next', __('Next')) ?>
                <dl class="_table">
                    <dt class="_req"><?php echo emt_label_for('rsmtitle', __('CV Title')) ?></dt>
                    <dd><?php echo input_tag('rsmtitle', $sf_request->getParameter('rsmtitle', $resume->getTitle()), 'size=30 maxlength=50') ?>
                        <em class="ln-example"><?php echo __('Just for your reference') ?></em></dd>
                    <dt><?php echo emt_label_for('namelname', __('Name, Lastname')) ?></dt>
                    <dd class="_noInput"><?php echo $sesuser ?></b>&nbsp;<?php echo link_to('(change)', '@myemt.account', array('title' => __('Go to Profile page to change your name'), 'query_string' => "_ref=$_here", 'class' => 'bluelink hover')) ?></dd>
                    <dt><?php echo emt_label_for('dofbirth', __('Date Of Birth')) ?></dt>
                    <dd class="_noInput"><?php echo format_date($sesuser->getBirthDate('U'), 'D') ?></b>&nbsp;<?php echo link_to('(change)', '@myemt.profile-edit', array('title' => __('Go to Profile page to change your birthdate'), 'query_string' => "_ref=$_here", 'class' => 'bluelink hover')) ?></dd>
                    <dt><?php echo emt_label_for('maritalstatus', __('Marital Status')) ?></dt>
                    <dd class="_noInput"><?php if ($profile): ?>
                        <?php echo UserProfilePeer::$MaritalStatus[$profile->getMaritalStatus()] ?>&nbsp;
                        <?php else: ?>
                        <?php echo __('Not Specified') ?>&nbsp;
                        <?php endif ?>
                        <?php echo link_to('(change)', '@myemt.profile-edit', array('title' => __('Go to Profile page to change your marital status'), 'query_string' => "_ref=$_here", 'class' => 'bluelink hover')) ?></dd>
                    <dt class="_req"><?php echo emt_label_for('rsmpositionid', __('Desired Position')) ?></dt>
                    <dd><?php echo select_tag('rsmpositionid', options_for_select(JobPositionPeer::getOrderedNames(true), $sf_params->get('rsmpositionid', $resume->getJobPositionId()), array('include_custom' => __('select desired position')))) ?></dd>
                    <dt class="_req"><?php echo emt_label_for('rsmjobgradeid', __('Position Level')) ?></dt>
                    <dd><?php echo select_tag('rsmjobgradeid', options_for_select(JobGradePeer::getSortedList(), $sf_params->get('rsmjobgradeid', $resume->getJobGradeId()), array('include_custom' => __('select position level')))) ?></dd>
                    <dt><?php echo emt_label_for('rsmobjective', __('Objective')) ?></dt>
                    <dd><?php echo textarea_tag('rsmobjective', $sf_request->getParameter('rsmobjective', $resume->getObjective()), 'rows=6 cols=60') ?></dd>
                </dl>
                <div class="txtCenter clear">
                    <?php echo link_to(__('Back'), '@mycv-action?action=review', 'class=action-button _left')?>
                    <?php echo submit_tag(__('Next'), 'class=action-button _right')?>
                    <?php echo submit_tag(__('Done'), 'class=action-button')?>&nbsp;&nbsp;<?php echo link_to(__('Cancel'), '@mycv-action?action=review', 'class=bluelink hover') ?>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('cv-steps-right', array('sesuser' => $sesuser, 'resume' => $resume)) ?>
        
    </div>
</div>
