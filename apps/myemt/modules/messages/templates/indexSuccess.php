<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('messages/toolbar', array('sesuser' => $sesuser, 'props' => $props, 'account' => $account, 'accparam' => $accparam)) ?>

    <div class="col_180">

<?php include_partial('messages/leftmenu', array('sesuser' => $sesuser, 'account' => $account, 'folders' => $folders, 'folder' => $folder, 'accparam' => $accparam)) ?>

    </div>

    <div class="col_762">

        <div class="box_762 _titleBG_Transparent">

<?php include_partial($folder, array('messages' => $messages, 'account' => $account, 'folder' => $folder)) ?>                
            
        </div>

    </div>

    <div class="col_180">
    </div>
</div>
