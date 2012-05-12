<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('tasks/toolbar', array('sesuser' => $sesuser)) ?>

    <div class="col_180">

<?php include_partial('leftmenu', array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
        <h4><?php echo __('Author Tasks') ?></h4>
        
<div class="role-index _noBorder">
<h2><?php echo __('My Publications') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('My Articles'), 'author/articles') ?></li>
<li><?php echo link_to(__('My News'), 'author/newss') ?></li>
</ol>
<div class="hrsplit-1"></div>
<?php if ($sf_user->hasCredential('editor')): ?>
<h2><?php echo __('Editorial Tasks') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('Publication Categories'), 'author/categories') ?></li>
<li><?php echo link_to(__('Edit Publication Sources'), 'author/sources') ?></li>
<li><?php echo link_to(__('Authors'), 'author/authors') ?></li>
<li><?php echo link_to(__('All Articles'), 'author/articles', array('query_string' => 'filter=none')) ?></li>
<li><?php echo link_to(__('All News'), 'author/newss', array('query_string' => 'filter=none')) ?></li>
</ol>
<?php endif ?>
<div class="hrsplit-1"></div>
</div>

        </div>

    </div>

    <div class="col_180">
    </div>
</div>
