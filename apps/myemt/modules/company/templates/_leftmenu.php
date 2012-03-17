<ol class="manage-menu">
<li class="light"><span><?php echo link_to($company->getLogo()?__('Change Logo'):__('Upload Logo'), "@upload-company-logo?hash={$company->getHash()}", 'class=logo-11px') ?></span></li>
<li class="light"><span><?php echo link_to(__('Go to Profile'), $company->getProfileUrl(), 'class=profile-11px') ?></span></li>
</ol>
<ol class="manage-menu">
<li><span><?php echo link_to(__('Company Info'), "@company-info?hash={$company->getHash()}", 'class=info-11px') ?></span></li>
<li><span><?php echo link_to(__('Products&Services'), "@manage-products?hash={$company->getHash()}", 'class=product-11px') ?></span></li>
<li><span><?php echo link_to(__('Leads'), "@manage-leads?hash={$company->getHash()}", 'class=product-11px') ?></span></li>
<?php /*
       *<li><span><?php echo link_to(__('Events'), "@company-events?hash={$company->getHash()}", 'class=event-11px') ?></span></li>
       *  
       */ ?>
<li><span><?php echo link_to(__('Jobs'), "@company-jobs-action?action=overview&hash={$company->getHash()}", 'class=job-11px') ?></span></li>
<?php /*
       *<li><span><?php echo link_to(__('Account'), "@company-account?hash={$company->getHash()}", 'class=account-11px') ?></span></li>
       */ ?>
</ol>