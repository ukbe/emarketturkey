<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('tasks/toolbar', array('sesuser' => $sesuser)) ?>

    <div class="col_180">

<?php include_partial('leftmenu', array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_762">

        <div class="box_762 _titleBG_Transparent">
            <section><?php $params = array('sesuser' => $sesuser, 'author' => $author); ?>
                <?php echo $objhandler->render($object, $act, $params) ?>
            </section>
        </div>

    </div>

</div>