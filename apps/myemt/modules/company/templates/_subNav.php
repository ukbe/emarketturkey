    <header>
<?php slot('pageHeader') ?>
        <hgroup class="_comSel">
            <?php echo link_to(image_tag($company->getProfilePictureUri()), "@upload-company-logo?hash={$company->getHash()}", "class=_comMng_logo") ?>
            <ul class="_horizontal">
                <li><?php echo link_to(__('Go to Profile'), $company->getProfileUrl()) ?></li>
                <li><?php echo link_to($company->getLogo() ? __('Change Logo') : __('Upload Logo'), "@upload-company-logo?hash={$company->getHash()}") ?></li>
                <li class="_last_item"><?php echo link_to(__('Messages'), "@messages") ?></li>
            </ul>
            <dl>
                <dt>
                    <em><?php echo $company->getName() ?></em>
                </dt>
                <dd>
                    <ul>
                        <?php $props = $sf_user->getUser()->getOwnerships() ?>
                        <?php foreach ($props as $prop): ?>
                        <?php if (!($prop->getObjectTypeId()==PrivacyNodeTypePeer::PR_NTYP_COMPANY && $prop->getId() == $company->getId())): ?>
                        <li><?php echo link_to($prop.'<span>switch</span>', $prop->getManageUrl()) ?></li>
                        <?php endif ?>
                        <?php endforeach ?>
                        <li class="_bottom_comMng_links">
                            <?php echo link_to(__('Register Company'), "@register-comp", 'class=_right') ?>
                            <br class="clear" />
                        </li>
                    </ul>
                </dd>
            </dl>
        </hgroup>
<?php end_slot() ?>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('myEMT'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo checkActivePage('@company-manage', null, false, '_selected') ?>"><?php echo link_to(__('Overview'), "@company-manage?hash={$company->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=companyProfile', null, true, '_selected') ?>><?php echo link_to(__('Edit Company Profile'), "@edit-company-profile?hash={$company->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=products', null, true, '_selected') ?><?php echo checkActivePage('module=leads', null, true, '_selected') ?>><?php echo link_to(__('Products and Services'), "@products-overview?hash={$company->getHash()}") ?></dd>
                <dd<?php echo checkActivePage('module=events', null, true, '_selected') ?>><?php echo link_to(__('Events'), "@company-events-action?hash={$company->getHash()}&action=overview") ?></dd>
                <dd<?php echo checkActivePage('module=jobs', null, true, '_selected') ?>><?php echo link_to(__('Jobs'), "@company-jobs-action?hash={$company->getHash()}&action=overview") ?></dd>
                <dd class="ui-corner-tr<?php echo checkActivePage('@company-account', null, false, '_selected') ?>"><?php echo link_to(__('Account'), "@company-account?action=settings&hash={$company->getHash()}") ?></dd>
                <dd class="_sp<?php echo checkActivePage('company/upgrade', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), "@company-account?action=upgrade&hash={$company->getHash()}") ?></dd>
            </dl>
        </nav>
<script type="text/javascript">
$(function() {
    
    $('._comSel dt em').click(function(){
        $('._comSel dl').toggleClass('_open');
        return false;
    });
});
</script>
    </header>