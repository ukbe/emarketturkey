<div class="column span-196 pad-2">
<h1><?php echo __('Job Postings') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">
<p>
<?php echo __("Companies or other corporations can place job postings on eMarketTurkey Human Resources Platform.
Individual visitors around the world will access your job postings and apply online. Since eMarketTurkey is 
a global platform, employers will have the opportunity to access professionals around the world by simply posting jobs.") ?>
</p>
<div class="hrsplit-1"></div>
<h3><?php echo __('Job Posting Templates')  ?></h3>
<p>
<?php echo __("There are different types of job posting templates. If you wish to use your corporate template, 
then you may consider applying your corporate template to your job postings. This way you will maintain the 
corporate standarts of your company. Also \"Featured Jobs\" option will allow you to maintain your job posting 
on homepage and help job seekers view your job posting faster.") ?>
</p>
<div class="hrsplit-1"></div>
<h3><?php echo __('Single or Multiple Listings')  ?></h3>
<p>
<?php echo __("eMarketTurkey HR, lets you choose the exact option while placing your job postings. 
You might need just a one time to place job postings, or you might be a frequent publisher. Therefore, eMarketTurkey HR 
will provide you the best job postings package which fits your needs.") ?>
</p>
<div class="hrsplit-1"></div>
<h3><?php echo __('One-Stop HR')  ?></h3>
<p>
<?php echo __("The most exciting feature of eMarketTurkey HR is %1. Which will let you automatically place job application 
form on your company's website. This way you will cut costs for a functional HR interface on your corporate website. This will
also let you manage submitted resumés on your MY EMT page, while allowing visitors who are already eMarketTurkey members 
apply to job positions automatically listed on your website by simply using their eMarketTurkey account.", 
        array('%1' => link_to(__('Embedded HR Interface'), 'services/embeddedhri'))) ?>
</p>
</div>
<div class="column span-49 pad-2 divbox">
<h2><?php echo __("Don't wait,<br />Feel the Perfect Match!") ?></h2>
<ol class="column span-48 pad-1">
<li class="column span-48">
<?php echo link_to(__('Place your Job Listing.'), '@myemt.new-job-listing') ?></li>
<li class="column span-48">
<?php echo link_to(__('Create your CV.'), ($sf_user->getUser()?'@hr.mycareer':'@signup'), array('query_string' => 'keepon='.url_for('@hr.hr-cv-create'))) ?></li>
</ol> 
</div>
</div>