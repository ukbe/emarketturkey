<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('tasks/leftmenu', array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_576">
        <h4><?php echo __('Tasks') ?></h4>
        <div class="box_576 _titleBG_Transparent">

<div class="column span-103 role-index append-2">
<h2><?php echo __('Edit Parameters') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('Business Sectors'), 'admin/businessSectors') ?></li>
<li><?php echo link_to(__('Business Types'), 'admin/businessTypes') ?></li>
<li><?php echo link_to(__('Product Categories'), 'admin/productCategories') ?></li>
<li><?php echo link_to(__('Payment Terms'), 'admin/paymentTerms') ?></li>
<li><?php echo link_to(__('Country & Languages'), 'admin/countryLanguages') ?></li>
<li><?php echo link_to(__('City & States'), 'admin/cityStates') ?></li>
<li><?php echo link_to(__('Job Positions'), 'admin/jobPositions') ?></li>
<li><?php echo link_to(__('Job Grades'), 'admin/jobGrades') ?></li>
</ol>
<div class="hrsplit-1"></div>
<h2><?php echo __('Edit Services') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('Edit Applications'), 'admin/applications') ?></li>
<li><?php echo link_to(__('Edit Services'), 'admin/services') ?></li>
<li><?php echo link_to(__('Marketing Packages'), 'admin/packages') ?></li>
<li><?php echo link_to(__('Membership Types'), 'admin/membership') ?></li>
</ol>
<div class="hrsplit-1"></div>
<h2><?php echo __('Manage Users') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('Users'), 'admin/users') ?></li>
<li><?php echo link_to(__('Roles'), 'admin/roles') ?></li>
<li><?php echo link_to(__('Companies'), 'admin/companies') ?></li>
<li><?php echo link_to(__('Media Items'), 'admin/mediaItems') ?></li>
<li><?php echo link_to(__('E-mail Transactions'), 'admin/emailTransactions') ?></li>
<li><?php echo link_to(__('Customer Messages'), 'admin/messages') ?></li>
</ol>
<div class="hrsplit-1"></div>
<h2><?php echo __('Manage Ads') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('Platform Ads'), 'admin/platformAds') ?></li>
</ol>
</div>

        </div>

    </div>

    <div class="col_180">
<div class="sidebar-header"><?php echo __('Statistics') ?></div>
<ol class="column span-50" style="font: 9px arial; color: #444444; margin: 5px; padding:0px;">
<li class="column span-50">
<?php $member_num = UserPeer::countRecentMembers($sf_user->getUser()->getLastLoginDate());
echo format_number_choice('[0]No new users.|[1]<b>1 new member.</b>|(1,+Inf]<b>%1 new members.</b>', 
                 array('%1' => $member_num), $member_num) ?>
</li>
<li class="column span-50">
<?php $company_num = CompanyPeer::countRecentMembers($sf_user->getUser()->getLastLoginDate());
echo format_number_choice('[0]No new companies.|[1]<b>1 new company.</b>|(1,+Inf]<b>%1 new companies.</b>', 
                 array('%1' => $company_num), $company_num) ?>
</li>
<li class="column span-50">
<?php $invites = InviteFriendPeer::doCount(new Criteria());
      $c = new Criteria();
      $c->add(InviteFriendPeer::IS_READ, 1);
      $readinvites = InviteFriendPeer::doCount($c);
echo __('%1 of %2 invites were read.', array('%1' => $readinvites, '%2' => $invites)) ?>
</li>
<li class="column span-50">
<?php $c = new Criteria();
      $c->addJoin(UserPeer::ID, InviteFriendPeer::INVITER_ID, Criteria::INNER_JOIN);
      $c->add(InviteFriendPeer::INVITER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
      $c->setDistinct();
      $inviters = UserPeer::doCount($c);
echo __('%1 users have sent invitations.', array('%1' => $inviters)) ?>
</li>
<li class="column span-50">
<?php $tokens = ConsentLoginPeer::doCount(new Criteria());
      $consentcontacts = ConsentContactPeer::doCount(new Criteria());
echo __('%1 contacts were retrieved via %2 consent tokens.', array('%1' => $consentcontacts, '%2' => $tokens)) ?>
</li>
<li class="column span-50">
<?php $sql = "SELECT * FROM (
                select count(distinct emt_resume.id) RESUME,
                count(distinct emt_resume_school.id) SCHOOL,
                count(distinct emt_resume_work.id) WORK, 
                count(distinct emt_resume_course.id) COURSE, 
                count(distinct emt_resume_award.id) AWARD,
                count(distinct emt_resume_reference.id) REFERENCE, 
                count(distinct emt_resume_skill.id) SKILL,
                count(distinct emt_resume_organisation.id) ORGY,
                count(distinct emt_resume_language.id) LANG
                from emt_resume
                left join emt_contact on emt_resume.contact_id=emt_contact.id
                left join emt_contact_address on emt_contact.id=emt_contact_address.contact_id
                left join emt_contact_phone on emt_contact.id=emt_contact_phone.contact_id
                left join emt_resume_school on emt_resume.id=emt_resume_school.resume_id
                left join emt_resume_skill on emt_resume.id=emt_resume_skill.resume_id 
                left join emt_resume_reference on emt_resume.id=emt_resume_reference.resume_id 
                left join emt_resume_award on emt_resume.id=emt_resume_award.resume_id 
                left join emt_resume_organisation on emt_resume.id=emt_resume_organisation.resume_id 
                left join emt_user on emt_resume.user_id=emt_user.id 
                left join emt_resume_work on emt_resume.id=emt_resume_work.resume_id 
                left join emt_resume_language on emt_resume.id=emt_resume_language.resume_id 
                left join emt_resume_course on emt_resume.id=emt_resume_course.resume_id 
                )
";
    $con = Propel::getConnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);
echo __('%1 resumes were created.', array('%1' => $rs['RESUME'])) . link_to_function(__('details'), "jQuery('.rsmdetails').slideToggle();", 'class=rsmdetails') ?>
<table class="rsmdetails ghost" style="border: solid 1px #BDBEBD; background-color: #F7F7F7;">
<tr><td><?php echo __('Schools') ?></td><td><?php echo $rs['SCHOOL'] ?></td></tr>
<tr><td><?php echo __('Works') ?></td><td><?php echo $rs['WORK'] ?></td></tr>
<tr><td><?php echo __('Courses') ?></td><td><?php echo $rs['COURSE'] ?></td></tr>
<tr><td><?php echo __('Awards') ?></td><td><?php echo $rs['AWARD'] ?></td></tr>
<tr><td><?php echo __('References') ?></td><td><?php echo $rs['REFERENCE'] ?></td></tr>
<tr><td><?php echo __('Skills') ?></td><td><?php echo $rs['SKILL'] ?></td></tr>
<tr><td><?php echo __('Organisations') ?></td><td><?php echo $rs['ORGY'] ?></td></tr>
<tr><td><?php echo __('Languages') ?></td><td><?php echo $rs['LANG'] ?></td></tr>
</table>
</li>
<li class="column span-50">
<?php $sql = "SELECT COUNT(*) APPLIED, COUNT(UNIQUE emt_user_job.job_id) JOB 
            FROM EMT_USER_JOB
            WHERE TYPE_ID=2";
    $con = Propel::getConnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);
echo __('%1 users applied to %2 jobs.', array('%1' => $rs['APPLIED'], '%2' => $rs['JOB'])) ?>
</li>
<li class="column span-50">
<?php $c = new Criteria();
    $c->add(JobPeer::STATUS, JobPeer::JSTYP_ONLINE);
    $onlinejobs = JobPeer::doCount($c);
    $jobs = JobPeer::doCount(new Criteria());
echo __('%1 online jobs out of %2.', array('%1' => $onlinejobs, '%2' => $jobs)) ?>
</li>
<li class="column span-50">
<?php $users = UserPeer::doCount(new Criteria());
echo __('%1 total users.', array('%1' => $users)) ?>
</li>
<li class="column span-50">
<?php $companies = CompanyPeer::doCount(new Criteria());
echo __('%1 total companies.', array('%1' => $companies)) ?>
</li>
<li class="column span-50">
<?php $sql = "SELECT COUNT(DISTINCT EMT_COMPANY.ID) COMPANY, COUNT(DISTINCT EMT_PRODUCT.ID) PRODUCT 
            FROM EMT_PRODUCT
            INNER JOIN EMT_COMPANY ON EMT_PRODUCT.COMPANY_ID=EMT_COMPANY.ID";
    $con = Propel::getConnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);
echo __('Up to %1 products from %2 companies.', array('%1' => $rs['PRODUCT'], '%2' => $rs['COMPANY'])) ?>
</li>
</ol>
    </div>
</div>
