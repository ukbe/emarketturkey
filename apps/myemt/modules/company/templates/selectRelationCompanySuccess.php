<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('company/account', array('company' => $company)) ?>
        </div>

    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($typ == 'parent'): ?>
            <h4><?php echo __('Select Parent Company') ?></h4>
            <?php elseif ($typ == 'subsidiary'): ?>
            <h4><?php echo __('Select Subsidiary Company') ?></h4>
            <?php else: ?>
            <h4><?php echo __('Select Parent or Subsidiary Company') ?></h4>
            <?php endif ?>
            <?php echo __('Please select the company which you want to setup a relation with.') ?>
            <div class="hrsplit-2"></div>
            <?php echo __('If the company you have been searching is not listed, then please repeat search by providing more details.') ?>
            <div class="hrsplit-2"></div>
            <?php echo form_tag("@company-account?action=relations&act=$act&hash={$company->getHash()}") ?>
            <dl class="_table">

                <dt><?php echo emt_label_for("relation_keyword", __('Company Name')) ?></dt>
                <dd><?php echo input_tag("relation_keyword", $sf_params->get('relation_keyword'), array('style' => 'width:200px;', 'maxlength' => 255)) ?></dd>
                <dd><?php echo input_hidden_tag("company_id", $sf_params->get('company_id')) ?></dd>
                <dt></dt>
                <dd><?php echo submit_tag(__('Search Company'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), "@company-account?action=relations&hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
            </dl>
            </form>
            <table class="pdd">
            <?php foreach ($companies as $comp): ?>
                <tr><td><?php echo link_to(__('Select'), "@company-account?action=relations&act=add&typ={$typ}&company_id={$comp->getId()}&hash={$company->getHash()}", 'class=selector') ?></td><td><?php include_partial('company/company', array('company' => $comp)) ?></td></tr>
            <?php endforeach ?>
            </table>
            <style>
                .pdd td { padding: 10px; margin: 10px; }
                .pdd tr:hover { background-color: #fffbe2; }
                .pdd tr a.selector { border: solid 1px; background-color: #2e395c; color: #fff;  padding: 3px 5px; }
            </style>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <?php include_partial('company/upgradeBox', array('company' => $company)) ?>
    </div>

</div>