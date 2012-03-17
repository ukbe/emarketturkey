<div class="column span-39 append-1">
<div class="pad-1"><em><?php echo $user ?></em></div>
<?php echo generateMenu(array(
        __('Inbox').($user->getUnreadMessageCount()?' ('.$user->getUnreadMessageCount().')':'') => 'messages/index?cls=inbox',
        __('Sent') => 'messages/index?cls=sent',
        __('Archived') => 'messages/index?cls=archived'
        )) ?>
<?php if ($companies): ?>
<?php foreach ($companies as $company): ?>
<div class="pad-1"><em><?php echo $company->getName() ?></em></div>
<?php echo generateMenu(array(
        __('Inbox').($company->getUnreadMessageCount()?' ('.$company->getUnreadMessageCount().')':'') => 'messages/index?cls=inbox&mod=cm',
        __('Sent') => 'messages/index?cls=sent&mod=cm',
        __('Archived') => 'messages/index?cls=archived&mod=cm'
        )) ?>
<?php endforeach ?>
<?php endif ?>
</div>