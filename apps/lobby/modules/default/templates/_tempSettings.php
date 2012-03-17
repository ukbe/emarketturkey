<emtAjaxResponse>
<init>
<?php echo javascript_tag("
$('#stg-redir').dynabox({clickerMethod: 'click', position: 'window', loadMethod: 'ajax', loadType: 'html', autoUpdate: false, keepContent: false });
$('#set-form').dynabox({clickerMethod: 'click', position: 'window', loadMethod: 'ajax', loadType: 'html', autoUpdate: false, keepContent: false, clickerId: '_ID_-submit' });
") ?>
</init>
<header>Account Settings</header>
<body>
<?php echo cdata_section("
<div class='clear pad-2'>
".form_tag('/en/default/boxtest?settings', 'id=set-form')."
<ol class='column span-80'>
    <li class='column span-15 append-1 right'>" . __('Name') . "</li>
    <li class='column span-63'>" . input_tag('ad', '') . "</li>
    <li class='column span-15 append-1 right'>" . __('Lastname') . "</li>
    <li class='column span-63'>" . input_tag('soyad', '') . "</li>
    <li class='dubl column span-15 append-1 right'>" . __('Comment') . "</li>
    <li class='dubl column span-63'>" . input_tag('yroum', '') . "</li>
    <li class='column span-15 append-1 right'>" . __('Date') . "</li>
    <li class='column span-63'>" . button_to_function('add row', '$(this).closest(\'ol\').children().slice(0, 2).clone().appendTo($(this).closest(\'ol\'));') . "</li>
    <li class='column span-15 append-1 right'></li>
    <li class='column span-63'>" . button_to_function('redirect', '', array('id' => 'stg-redir', 'alt' => '/en/default/boxtest?advanced')) . "</li>
</ol>
</form>
</div>
") ?>
</body>
<footer>
<?php echo cdata_section("
    <span class='left'>" . link_to_function(__('Help'), '#', array('class' => 'thin')) . "</span>
    <span class='center'>" . link_to_function(__('Submit'), '#', 'id=set-form-submit') . "</span>
    <span class='right'>" . link_to_function(__('No Thanks'), "$.ui.dynabox.openBox.close()", array('class' => 'thin')) . "</span>
") ?>
</footer>
</emtAjaxResponse>