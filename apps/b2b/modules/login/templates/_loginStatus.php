<?php use_helper('Form') ?>
<table id="topmenu" cellpadding="0" cellspacing="0" align="right">
<tr>
<?php if ($sf_user->getUser()): ?>
<td>
    <?php echo link_to("<sup>".($mescnt = $sf_user->getUser()->getUnreadMessageCount())."</sup>", '@myemt.messages', array('id' => 'messages', 'class' => 'toplink'. ($mescnt ? ' new': ''), 'title' => __('Messages'))) ?>
</td>
<td>
    <?php echo link_to("<sup>".($notcnt = $sf_user->getUser()->getNotificationCount())."</sup>", '@cm.notifications', array('id' => 'notifications', 'class' => 'toplink'. ($notcnt ? ' new': ''), 'title' => __('Notifications'))) ?>
</td>
<td>
    <?php echo link_to("<sup>".($reqcnt = $sf_user->getUser()->getRequestCount())."</sup>", $reqcnt ? '@cm.requests' : '@cm.network', array('class' => 'toplink contacts'. ($reqcnt ? ' new': ''), 'title' => __('Contacts'))) ?>
</td>
<?php $roles = $sf_user->getUser()->getLogin()->getRoles() ?>
<?php if (count($roles)>1): ?>
<td>
    <?php echo link_to(__('Tasks'), '@myemt.tasks', 'class=toplink') ?>
</td>
<?php endif ?>
<td class="island">
    <?php echo link_to_function(__('Account'), "toggleAccount()", array('class' => 'toplink', 'style' => "padding: 0px; margin: 0px; line-height: 21px;")) ?>
    <div id="hover-account" class="top-submenu first">
        <ol>
        <li><?php echo link_to(__('My Profile'), $sf_user->getUser()->getProfileUrl()) ?></li>
        <li><?php echo link_to(__('Account Settings'), '@myemt.account') ?></li>
        <li><?php echo link_to(__('Privacy Settings'), '@myemt.setup-privacy') ?></li>
        <li><?php echo link_to(__('Logout'), '@myemt.logout') ?></li>
        </ol>
    </div>
</td>
<?php else: ?>
<td>
    <?php echo link_to_function(__('Login'), "toggleLogin()", array('class' => 'toplink', 'style' => "padding: 0px; margin: 0px; line-height: 21px;")) ?>
    <div id="hover-login">
    <div>
        <?php echo form_tag('@myemt.login') ?>
        <ol>
        <li><?php echo emt_label_for('email_e', __('E-mail')) ?></li>
        <li><?php echo input_tag('email', '', array('id' => 'email_e', 'name' => 'email')) ?></li>
        <li><?php echo emt_label_for('password_e', __('Password')) ?></li>
        <li><?php echo input_password_tag('password', '', array('id' => 'password_e', 'name' => 'password')) ?></li>
        <li class="hrsplit-2"></li>
        <li><?php echo checkbox_tag('remember_e', '1', false, array('id' => 'remember_e', 'name' => 'remember')) ?>
            <?php echo label_for('remember_e', __('Remember Me')) ?></li>
        <li class="hrsplit-2"></li>
        <li><?php echo submit_tag(__('Login')) ?></li>
        <li style="text-align: right"><em><?php echo link_to(__('Forgot Password?'), '@myemt.forgot-password') ?></em></li>
        </ol>
        <?php echo "</form>" ?>
        </div>
    </div>
</td>
<td>
    <?php echo !$sf_user->getUser()?link_to(__('Sign Up'), '@myemt.signup', 'class=toplink')."&nbsp;":"" ?>
</td>
<?php endif ?>
<td class="island">
    <?php echo __('Language').':' ?>
    <span>
    <?php echo link_to_function(format_language($sf_user->getCulture()),
                    "jQuery('#langselect').toggle();", array('class' => 'toplink', 'onmouseover' => "jQuery('#langselect').show();", 'onmouseout' => "jQuery('#langselect').hide();", 'style' => "padding: 0px; margin: 0px; line-height: 21px;")) ?>
    </span>
    <div id="langselect" class="top-submenu" onmouseover="jQuery('#langselect').show();" onmouseout="jQuery('#langselect').hide();">
        <ol>
        <li><?php echo link_to(__('Türkçe'), myTools::localizedUrl('tr')) ?></li>
        <li><?php echo link_to(__('English'), myTools::localizedUrl('en')) ?></li>
        </ol>
    </div>
</td>
</tr>
</table>
<?php echo javascript_tag("
function toggleLogin()
{
    jQuery('#hover-login').closest('td').toggleClass('overit').find('#email_e').focus();    
}
function toggleAccount()
{
    jQuery('#hover-account').closest('td').toggleClass('overit');    
}
jQuery(document).click(function(event) {
    if (jQuery(event.target).closest('td.overit').length==0 && jQuery('td.overit #hover-login').is(':visible')) {
         toggleLogin();
    }
    if (jQuery(event.target).closest('td.overit').length==0 && jQuery('td.overit #hover-account').is(':visible')) {
         toggleAccount();
    }
    if (jQuery(event.target).closest('ol.searchbox').length==0 && jQuery('#select-src-type').is(':visible')) {
         jQuery('#select-src-type').toggle();
    }
});
") ?>