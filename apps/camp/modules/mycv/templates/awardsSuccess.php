<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

<?php slot('footer') ?>
<?php include_partial('global/footer_hr') ?>
<?php end_slot() ?>

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
            <h4><?php echo __('Awards and Honors') ?></h3>
            <div class="_noBorder pad-0">
                <?php  if ($message = $sf_user->getFlash('message')): ?>
                <div class="bubble pad-2"><?php echo __($message)?></div>
                <?php endif ?>
                <?php foreach($awards as $sch): ?>
                <?php if ($award && $sch->getId() == $award->getId()): ?>
                <?php echo $objhandler->render($award, $act) ?>
                <?php else: ?>
                <?php echo $objhandler->render($sch, 'view') ?>
                <?php endif ?>
                <?php endforeach ?>

                <?php if ($act == 'new'): ?>
                <?php echo $objhandler->render($award, 'new') ?>
                <?php else:?>
                <div class="pad-1 margin-b2">
                <?php echo link_to(__('Add Award/Honor'), "@mycv-action?action=awards&act=new", 'id=addnew class=ln-addlink greenspan led add-11px ajax-enabled') ?>
                </div>
                <?php endif ?>

                <?php echo form_errors() ?>
                <?php echo form_tag('@mycv-action?action=awards') ?>
                <?php echo input_hidden_tag('done', __('Done')) ?>
                <?php echo input_hidden_tag('next', __('Next')) ?>
                <div class="txtCenter">
                    <?php echo link_to(__('Back'), '@mycv-action?action=publications', 'class=action-button _left')?>
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
<?php echo javascript_tag("
$(function() {
    $('.ajax-enabled').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
        loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, position: 'window'
        });
});
") ?>