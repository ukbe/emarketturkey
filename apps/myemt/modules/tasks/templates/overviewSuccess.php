<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('tasks/toolbar', array('sesuser' => $sesuser)) ?>

    <div class="col_180">

<?php include_partial('tasks/leftmenu', array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_576">
        <h4><?php echo __('Tasks') ?></h4>
        <div class="box_576 _titleBG_Transparent">

<div class="column span-198 pad-1">
<?php foreach ($sf_user->getUser()->getLogin()->getRoles() as $role): ?>
<?php if ($role->getModule()): ?>
<div class="rounded-border">
<span><?php echo link_to(image_tag('layout/icon/role/'.$role->getSysname(), 'width=20 height=20'), $role->getModule().'/index') ?>
<?php echo link_to($role->getName(), $role->getModule().'/index') ?></span>
<div><div>
<?php include_partial($role->getModule().'/panel') ?>
</div>
</div>
</div>
<div class="hrsplit-2"></div>
<?php endif ?>
<?php endforeach ?>
</div>
        </div>

    </div>

    <div class="col_180">
    </div>
</div>
