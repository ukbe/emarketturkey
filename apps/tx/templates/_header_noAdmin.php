	<hgroup>
		<h1>
			<a href="<?php echo url_for('@homepage') ?>" title="<?php echo __('eMarketTurkey Homepage') ?>" tabindex="0">
				<abbr title="electronic">e</abbr><em>Market</em><em>Turkey</em>
			</a>
		</h1>
	</hgroup>

	<dl id="language_field">
		<dt><?php echo __('INTERNATIONAL:') ?></dt>
		<dd><?php echo link_to('ENGLISH', myTools::localizedUrl('en')) ?></dd>
		<dd><?php echo link_to('TÜRKÇE', myTools::localizedUrl('tr')) ?></dd>
		<dd class="more ghost"><a href=""></a></dd>
	</dl>

	<nav>
		<div class="nav_container">

			<ul class="menu">
				<li class="liTop" style="float:left;margin-right:3px;"><a class="open" href="#url" tabindex="1">
					<img src="/images/layout/icon/icon-home.gif" alt="home for international commerce" style="margin-top:11px;float:left;" /><!--[if gte IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<div>
            <?php if ($sf_user->isLoggedIn()): ?>
						<ul class="drop">
                            <li><?php echo link_to(__('My Profile'), $sf_user->getUser()->getProfileUrl()) ?></li>
                            <li><?php echo link_to(__('Edit Profile'), '@myemt.profile-edit') ?></li>
                            <?php foreach ($sf_user->getUser()->getOwnerships() as $item): ?>
                            <li><?php echo link_to($item, $item->getProfileUrl()) ?></li>
                            <?php endforeach ?>
						</ul>
			<?php endif ?>
					</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
			</ul>
			<ul class="menu">
				<li class="liTop selected"><a class="open" href="<?php echo url_for('@b2b.homepage') ?>" tabindex="2" id="btn-b2b"><b><?php echo __('B2B') ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<div id='btn-b2b-box'>
						<ul class="drop extended">
							<li id="floated">
								<!-- <a href=""><img src="images/300x250.gif" alt="" /></a> -->
								<div class="wrap5">
									<a href="#x">
										<img src='images/300x250(2).jpg' alt='' />
										<i></i>
										<p>
											<b>The Mini</b>
											<span>The Mini is a small car that was made by the British Motor Corporation (BMC) and its successors from 1959 until 2000.</span> 
										</p>
									</a>
								</div>
							</li>
                            <li><?php echo link_to(__('Companies'), '@companies') ?></li>
                            <li><?php echo link_to(__('Products and Services'), '@products') ?></li>
                            <li><?php echo link_to(__('Selling Leads'), '@homepage') ?></li>
                            <li><?php echo link_to(__('Buying Leads'), '@homepage') ?></li>
                            <li><?php echo link_to(__('Trade Shows'), '@homepage') ?></li>
                            <li><?php echo link_to(__('Trade Xperts'), '@homepage') ?></li>
                            <li><?php echo link_to(__('Transportation Directory'), '@homepage') ?></li>
							<li><a href="#url" style="margin-top:7em"><span style="color:red;">TR</span>ADE Xperts <sup>®</sup> <span class="hoverImg"><img src="images/300x250.jpg" alt="" /></span></a></li>
							<li><a href="s5.html">em<span style="color:red;">TR</span>UST <sup>®</sup> <span class="hoverImg"><img src="images/300x250(3).jpg" alt="" /></span></a></li>
						</ul>
					</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
			</ul>
			<ul class="menu">
				<li class="liTop"><a class="open" href="<?php echo url_for('@hr.homepage') ?>" tabindex="3" id="btn-hr"><b><?php echo __('JOBS') ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<div id='btn-hr-box'>
						<ul class="drop" style="width:auto">
                            <li><?php echo link_to(__('Job Search'), '@hr.homepage') ?></li>
                            <li><?php echo link_to(__('My Career'), '@hr.mycareer') ?></li>
							<li><a href="#url"><span style="color:red;">TR</span>ADE Xperts <sup>®</sup></a></li>
							<li><a class="last" href="#url">cv<span style="color:red;">TR</span>UST <sup>®</sup></a></li>
							<li style="padding:0;text-align:center;">
								<img src='images/180x150(3).png' alt='' />
							</li>
						</ul>
					</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
			</ul>
			<ul class="menu">
				<li class="liTop"><a class="open" href="<?php echo url_for('@ac.homepage') ?>" tabindex="4" id="btn-ac"><b><?php echo __('ACADEMY') ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<div id='btn-ac-box'>
						<ul class="drop">
                            <li><?php echo link_to(__('Articles'), '@ac.articles') ?></li>
                            <li><?php echo link_to(__('News'), '@ac.news-home') ?></li>
                            <li><?php echo link_to(__('Foreign Trade Glossary'), '@homepage') ?></li>
                            <li><?php echo link_to(__('Country Profiles'), '@homepage') ?></li>
						</ul>
					</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
			</ul>
			<ul class="menu">
				<li class="liTop"><a class="open" href="<?php echo url_for('@cm.homepage') ?>" tabindex="5" id="btn-cm"><b><?php echo __('COMMUNITY') ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<div id='btn-cm-box'>
						<ul class="drop">
                            <li><?php echo link_to(__('People'), '@cm.people') ?></li>
                            <li><?php echo link_to(__('Groups'), '@cm.groups') ?></li>
                            <li><?php echo link_to(__('Events'), '@cm.homepage') ?></li>
                            <li><?php echo link_to(__('Public Bulletin'), '@cm.homepage') ?></li>
						</ul>
					</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
			</ul>
			<ul class="menu">
				<li class="liTop"><a class="open" href="<?php echo url_for('@homepage') ?>" tabindex="6" id="btn-tx"><b><?php echo __('TRANSLATION') ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<div id='btn-tx-box'>
					</div>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
			</ul>

			<ul id="buttons">

				<!--// LOGGED OFF //-->
				<li id="btn_signUp" class="nologin" title="<?php echo __('Sogn Up') ?>"><a href="<?php echo url_for('@lobby.signup') ?>" tabindex="7"><?php echo __('Sign Up') ?></a></li>
				<li  tabindex="7" id="btn_signIn" class="nologin" title="<?php echo __('Sign in') ?>"><span class="ui-icon ui-icon-power"></span><b><?php echo link_to(__('Sign in'), '@myemt.login') ?></b></li>

				<!--// LOGGED IN //-->
				<li title="<?php echo __('Messages') ?>"><b><?php echo link_to(__('Messages').'<span id="btn_messages-newtag"></span>', 'default/boxtest', 'id=btn_messages') ?></b></li>
				<li id="btn_notifications" title="<?php echo __('Notifications') ?>"><b><?php echo link_to(__('Notifications'), '@myemt.homepage') ?></b></li>
				<li id="btn_contacts" title="<?php echo __('Contacts') ?>"><b><?php echo link_to(__('Contacts'), '@cm.network') ?></b></li>
				<li id="btn_tasks" title="<?php echo __('Tasks') ?>"><b><?php echo link_to(__('Tasks'), '@myemt.tasks') ?></b></li>
				<li id="btn_account" title="<?php echo __('Account') ?>"><b><?php echo link_to(__('Account'), '@myemt.account') ?></b></li>
			</ul>

			<div id="btn_messages-box">
				<ul id="subscr_messages" class="list btn_subscr">
					<li class="_lHead"></li>
					<li class="_lPadd header">
						<strong><?php echo __('Messages') ?></strong>
					</li>
					<li class="temp">
						<a href="_LINK_">
							<img src="_IMG_" alt="" width="50" height="50" />
							<span class="_nam">_NAME_ _LASTNAME_</span>
							<span class="_msg">_MSG_</span>
							<span class="_dat">_DATE_</span>
						</a>
					</li>
					<li class="_lFoot ui-corner-bottom">
						<?php echo link_to(__('Compose'), '@myemt.compose-message', 'class=_left') ?>
						<?php echo link_to(__('All Messages'), '@myemt.messages', 'class=_right') ?>
					</li>
				</ul>
			</div>

            <?php if ($sf_user->isLoggedIn()): ?>
			<div id="btn_account-box" class="ghost">
				<ul id="subscr_account" class="list">
                    <li class="header"><?php echo $sf_user->getUser() ?></li>
                    <li class="item"><?php echo link_to(__('My Profile'), $sf_user->getUser()->getProfileUrl()) ?></li>
                    <li class="item"><?php echo link_to(__('Account Settings'), '@myemt.account') ?></li>
                    <li class="item"><?php echo link_to(__('Privacy Settings'), '@lobby.privacy') ?></li>
                    <li class="item"><?php echo link_to(__('Logout'), '@myemt.logout') ?></li>
				</ul>
			</div>
			<?php endif ?>

			<ul style="position:absolute;top:0px;right:0px;margin:0;padding:0;font-size:10px;z-index:500;xbackground:#85b2cb;">
				<li>
<?php $search = array(PrivacyNodeTypePeer::PR_NTYP_COMPANY  => array(__('Companies'), url_for('@companies')),
                      PrivacyNodeTypePeer::PR_NTYP_PRODUCT  => array(__('Products'), url_for('@products')),
                      PrivacyNodeTypePeer::PR_NTYP_USER     => array(__('People'), url_for('@cm.people')),
                      PrivacyNodeTypePeer::PR_NTYP_GROUP    => array(__('Groups'), url_for('@cm.groups')),
                      PrivacyNodeTypePeer::PR_NTYP_JOB     => array(__('Jobs'), url_for('@cm.people'))) ?>
<?php $srctyp = $sf_user->getAttribute('srctype', PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
<?php $srcdata = $search[$srctyp] ?>
<?php $js = array() ?> 
                    <?php echo form_tag($srcdata[1], 'class=search method=get id=searchForm') ?>
						<fieldset id="search_field" class="ui-corner-left">
							<legend><span title="<?php echo __('Click out of the box to close') ?>"><?php echo __('[ CLOSE ]') ?></span></legend>
							<p id="search_option">
                            <?php foreach ($search as $key => $data): ?>
								<?php echo radiobutton_tag("within", $key, $srcdata === $data ? true : false, "id=_sf$key") ?><?php echo emt_label_for("_sf$key", $data[0]) ?>
                            <?php endforeach ?>
							</p>
                            <?php echo input_tag('srcKey', '', array('id' => 'search_keywords', 'placeholder' => __('Arama'))) ?>
							<button type="submit" id="search_button"><span class="ui-icon ui-icon-search"></span></button>
						</fieldset>
					</form>
				</li>
			</ul>

		</div> <!--// .nav_container //-->
	</nav>
