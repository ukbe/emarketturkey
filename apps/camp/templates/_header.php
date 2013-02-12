    <div>
	<hgroup>
		<h1>
			<a href="<?php echo url_for('@homepage') ?>" title="<?php echo __('eMarketTurkey Homepage') ?>" tabindex="0">
				<abbr title="electronic">e</abbr><em>Market</em><em>Turkey</em>
                <div class="ghost"><?php echo image_tag('layout/emtlogo.gif', array('alt' => __('eMarketTurkey Logo'))) ?></div>
			</a>
		</h1>
	</hgroup>

	<dl id="language_field">
		<dt><?php echo __('INTERNATIONAL:') ?></dt>
		<dd><?php echo link_to('ENGLISH', isset($urls) && isset($urls['en']) ? $urls['en'] : myTools::localizedUrl('en')) ?></dd>
		<dd><?php echo link_to('TÜRKÇE', isset($urls) && isset($urls['tr']) ? $urls['tr'] : myTools::localizedUrl('tr')) ?></dd>
        <dd><?php echo link_to('РУССКИЙ', isset($urls) && isset($urls['ru']) ? $urls['ru'] : myTools::localizedUrl('ru')) ?></dd>
		<dd class="more ghost"><a href=""></a></dd>
	</dl>

<?php $logged_in = $sf_user->isLoggedIn() ?>
    <nav<?php echo $logged_in ? ' class="_login"' : '' ?>>
        <dl>
            <dt class="_liHome<?php echo !$logged_in ? ' empty' : '' ?>"><?php echo link_to(image_tag('layout/icon/home-black.png', array('alt' => __('Home for International Trade'))), $sf_user->isLoggedIn() ? '@myemt.homepage' : '@homepage', 'tabindex=1 id=btn-home') ?></dt>
            <dd id="btn-home-box">
                <?php if ($logged_in): ?>
                <ul>
                    <li><?php echo link_to(__('My Profile'), $sf_user->getUser()->getProfileUrl()) ?></li>
                    <li><?php echo link_to(__('Edit Profile'), '@myemt.profile-edit') ?></li>
                    <?php foreach ($sf_user->getUser()->getOwnerships() as $item): ?>
                    <li><?php echo link_to($item, $item->getProfileUrl()) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            </dd>
        </dl>
        <dl>
            <dt>
                <a href="<?php echo url_for('@homepage') ?>" tabindex="2" id="btn-b2b"><b><?php echo __('B2B') ?></b></a>
            </dt>
            <dd id='btn-b2b-box'>
                <ul>
                    <li><?php echo link_to(__('Companies'), '@companies') ?></li>
                    <li><?php echo link_to(__('Products and Services'), '@products') ?></li>
                    <li><?php echo link_to(__('Buying Leads'), '@buying-leads') ?></li>
                    <li><?php echo link_to(__('Selling Leads'), '@selling-leads') ?></li>
                    <li><?php echo link_to(__('Trade Shows'), '@tradeshows') ?></li>
                    <li><br /><?php echo link_to(__('<span class="t_red">TR</span>ADE Experts'), '@tradeexperts') ?></li>
                    <li><?php echo link_to(__('emt<span class="t_red">TR</span>UST'), '@premium') ?></li>
                </ul>
            </dd>
        </dl>
        <dl>
            <dt>
                <a href="<?php echo url_for('@jobs') ?>" tabindex="3" id="btn-hr"><b><?php echo __('JOBS') ?></b></a>
            </dt>
            <dd id='btn-hr-box'>
                <ul>
                    <li><?php echo link_to(__('Job Search'), '@jobsearch') ?></li>
                    <li><?php echo link_to(__('My Career'), '@mycareer') ?></li>
                    <li><?php echo link_to(__('Bookmarks'), '@mycareer-action?action=bookmarks') ?></li>
                </ul>
            </dd>
        </dl>
        <dl>
            <dt>
                <a href="<?php echo url_for('@academy') ?>" tabindex="4" id="btn-ac"><b><?php echo __('ACADEMY') ?></b></a>
            </dt>
            <dd id='btn-ac-box'>
                <ul>
                    <li><?php echo link_to(__('Articles'), '@articles') ?></li>
                    <li><?php echo link_to(__('News'), '@news-home') ?></li>
                    <li><?php echo link_to(__('Authors'), '@academy') ?></li>
                    <li><?php echo link_to(__('Knowledgebase'), '@kb') ?></li>
                </ul>
            </dd>
        </dl>
        <dl>
            <dt>
                <a href="<?php echo url_for('@community') ?>" tabindex="5" id="btn-cm"><b><?php echo __('COMMUNITY') ?></b></a>
            </dt>
            <dd id='btn-cm-box'>
                <ul>
                    <li><?php echo link_to(__('People'), '@people') ?></li>
                    <li><?php echo link_to(__('Groups'), '@groups') ?></li>
                    <li><?php echo link_to(__('Events'), '@events') ?></li>
                </ul>
            </dd>
        </dl>
        <dl>
            <dt>
                <a href="<?php echo url_for('@translation') ?>" tabindex="6" id="btn-tx"><b><?php echo __('TRANSLATION') ?></b></a>
            </dt>
            <dd id='btn-tx-box'>
                <ul>
                    <li><?php echo link_to(__('Join Now'), '@tr-apply') ?></li>
                </ul>
            </dd>
        </dl>
        <ul id="buttons">
            <?php if (!$logged_in): ?>
            <!--// LOGGED OFF //-->
            <li class="nologin"><b><?php echo link_to(__('Sign Up'), '@myemt.signup', array('id' => 'btn_signup' , 'tabindex' => 7, 'title' => __('Sign Up'))) ?></b></li>
            <li class="nologin"><b><?php echo link_to(__('Login').'<b></b>', '@myemt.login', array('id' => 'btn_login', 'title' => __('Login'))) ?></b>
                <div id="btn_login-box">
                    <ul class="menu-sub-box list">
                        <li class="header"><?php echo __('Login') ?></li>
                        <li class="item pad-2">
                            <?php echo form_tag('@myemt.login') ?>
                            <?php echo input_hidden_tag('_ref', '') ?>
                                <ul class="pad-0 margin-0 roundInput">
                                    <li><?php echo emt_label_for('email_e', __('E-mail')) ?></li>
                                    <li><?php echo input_tag('email', '', array('id' => 'email_e', 'name' => 'email')) ?></li>
                                    <li><?php echo emt_label_for('password_e', __('Password')) ?></li>
                                    <li><?php echo input_password_tag('password', '', array('id' => 'password_e', 'name' => 'password')) ?></li>
                                    <li><?php echo checkbox_tag('remember_e', '1', false, array('id' => 'remember_e', 'name' => 'remember')) ?>
                                        <?php echo label_for('remember_e', __('Remember Me')) ?></li>
                                    <li><?php echo submit_tag(__('Login')) ?></li>
                                </ul>
                            </form>
                        </li>
                        <li class="footer"><?php echo link_to(__('Forgot Password?'), '@myemt.forgot-password', 'class=_right') ?>
                            <div class="clear"></div>
                        </li>
                    </ul>
                </div>
            </li>
            <?php else: ?>
            <!--// LOGGED IN //-->
            <li><b><?php echo link_to(__('Messages').'<b></b><span class="btn_messages-newtag"></span>', '@myemt.messages', array('id' => 'btn_messages', 'title' => __('Messages'))) ?></b>
                <div id="btn_messages-box">
                    <ul class="menu-sub-box list">
                        <li class="header">
                            <div class="_right new-holder"><?php echo __('%1 new', array('%1' => '<span class="btn_messages-newtag"></span>')) ?></div>
                            <strong><?php echo __('Messages') ?></strong>
                        </li>
                        <li class="empty">
                            <?php echo __("You don't have new messages.") ?>
                        </li>
                        <li class="temp">
                            <a href="_LINK_">
                                <img src="_IMG_" alt="_NAME_" />
                                <div class="_left">
                                    <span class="_nam">_NAME_</span>
                                    <span class="_msg">_MSG_</span>
                                    <span class="_dat">_DATE_</span>
                                </div>
                                <div class="clear"></div>
                            </a>
                        </li>
                        <li class="footer">
                            <?php echo link_to(__('Compose'), '@compose-message', 'class=_left') ?>
                            <?php echo link_to(__('All Messages'), '@messages', 'class=_right') ?>
                            <div class="clear"></div>
                        </li>
                    </ul>
                </div>
            </li>
            <li><b><?php echo link_to(__('Notifications').'<b></b><span class="btn_notifications-newtag"></span>', '@myemt.notifications', array('id' => 'btn_notifications', 'title' => __('Notifications'))) ?></b>
                <div id="btn_notifications-box">
                    <ul class="menu-sub-box list">
                        <li class="header">
                            <div class="_right new-holder"><?php echo __('%1 new', array('%1' => '<span class="btn_notifications-newtag"></span>')) ?></div>
                            <strong><?php echo __('Notifications') ?></strong>
                        </li>
                        <li class="empty">
                            <?php echo __("You don't have new notifications.") ?>
                        </li>
                        <li class="temp">
                            <a href="_LINK_">
                                <img src="_IMG_" alt="_NAME_" />
                                <div class="_left">
                                    <span class="_nam">_NAME_</span>
                                    <span class="_msg">_MSG_</span>
                                    <span class="_dat">_DATE_</span>
                                </div>
                                <div class="clear"></div>
                            </a>
                        </li>
                        <li class="footer">
                            <?php echo link_to(__('All Notifications'), '@myemt.notifications', 'class=_right') ?>
                            <div class="clear"></div>
                        </li>
                    </ul>
                </div>
            </li>
            <li><b><?php echo link_to(__('Contacts').'<b></b>', '@myemt.contacts', array('id' => 'btn_contacts', 'title' => __('Contacts'))) ?></b></li>
            <li><b><?php echo link_to(__('Tasks').'<b></b>', '@myemt.tasks', array('id' => 'btn_tasks', 'title' => __('Tasks'))) ?></b></li>
            <li><b><?php echo link_to(__('Account').'<b></b>', '@myemt.account', array('id' => 'btn_account', 'title' => __('Account'))) ?></b>
                <div id="btn_account-box">
                    <ul class="menu-sub-box list">
                        <li class="header"><?php echo $sf_user->getUser() ?></li>
                        <li class="item"><?php echo link_to(__('My Profile'), $sf_user->getUser()->getProfileUrl()) ?></li>
                        <li class="item"><?php echo link_to(__('Account Settings'), '@myemt.account') ?></li>
                        <li class="item"><?php echo link_to(__('Privacy Settings'), '@myemt.setup-privacy') ?></li>
                        <li class="item"><?php echo link_to(__('Logout'), '@myemt.logout') ?></li>
                        <li class="footer"><div class="clear"></div></li>
                    </ul>
                </div>
            </li>
            <?php endif ?>
        </ul>

        <div style="position:absolute;top:0px;right:0px;margin:0;padding:0;font-size:10px;z-index:500;">
<?php $search = array(PrivacyNodeTypePeer::PR_NTYP_COMPANY  => array(__('Companies'), url_for('@companies')),
                      PrivacyNodeTypePeer::PR_NTYP_PRODUCT  => array(__('Products'), url_for('@products')),
                      PrivacyNodeTypePeer::PR_NTYP_USER     => array(__('People'), url_for('@people')),
                      PrivacyNodeTypePeer::PR_NTYP_GROUP    => array(__('Groups'), url_for('@groups')),
                      PrivacyNodeTypePeer::PR_NTYP_JOB     => array(__('Jobs'), url_for('@jobs'))) ?>
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
                    <?php echo input_tag('srcKey', '', array('id' => 'search_keywords', 'placeholder' => __('Type Keyword'))) ?>
                <input type="submit" id="search_button" />
            </fieldset>
            </form>
        </div>

	</nav>
    </div>