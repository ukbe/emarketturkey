<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>

<div class="hrsplit-1"></div>

    <div class="col_180">
<?php include_partial('leftmenu', array('company' => $company))?>

    </div>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576 _title_BoldColor">
                <h4><?php echo __("Upload Photo") ?></h4>
                <div>
                    <?php if ($own_company): ?>
                    <div class="pad-3">
                        <?php echo form_errors() ?>
                        <?php echo form_tag($company->getProfileActionUrl('upload'), 'multipart=true') ?>
                        <?php echo input_hidden_tag('act', 'upl')?>
                        <?php echo input_file_tag('photo') ?>
                        <div class="hrsplit-2"></div>
                        <?php echo submit_tag(__('Upload Photo'), 'class=green-button') ?>
                        </form>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if ($own_company): ?>
            <?php include_partial('owner_actions', array('company' => $company)) ?>
            <?php endif ?>
            
        </div>

    </div>
</div>