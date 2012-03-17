<emtAjaxResponse>
<init>
</init>
<header>
<?php echo cdata_section("Register Your Company Now") ?>
</header>
<body>
<?php echo cdata_section("
<div class='clear pad-2'>
<ol class='column span-80'>
    <li class='column span-15 append-1 right'>" . __('Company') . "</li>
    <li class='column span-63'>" . input_tag('fddf', '') . "</li>
    <li class='column span-15 append-1 right'>" . __('Founded In') . "</li>
    <li class='column span-63'>" . input_tag('fddf', '') . "</li>
    <li class='dubl column span-15 append-1 right'>" . __('Products Range') . "</li>
    <li class='dubl column span-63'>" . input_tag('fddf', '') . "</li>
</ol>
</div>
") ?>
</body>
<footer>
<?php echo cdata_section("
    <span class='left'>" . link_to_function(__('Learn more'), '#', array('class' => 'thin')) . "</span>
    <span class='center'>" . link_to_function(__('Apply'), '#') . link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()") . "</span>
") ?>
</footer>
</emtAjaxResponse>