<style>
a.home {background: url(/images/layout/icon/home-grey.png) left top no-repeat; padding: 8px 0px 8px 35px; height: 29px; display: block;text-decoration: none; font: bold 11pt arial; color: #BBBABA;}
a.home:hover {background: url(/images/layout/icon/home-black.png) left top no-repeat; color: #000000;}
a.comments {background: url(/images/layout/icon/comments-grey.png) left top no-repeat; padding: 8px 0px 8px 35px; height: 29px; display: block;text-decoration: none; font: bold 11pt arial; color: #BBBABA;}
a.comments:hover {background: url(/images/layout/icon/comments-black.png) left top no-repeat;  color: #000000;}
</style>
<div class="hrsplit-3"></div>
<div style="border: solid 2px #E8E7E7; width: 500px; padding: 20px; text-align: left; float: left; margin-left: 229px;">
<div style="text-align: right;margin-bottom: 20px;"><?php echo image_tag('layout/newlogo/logo-'.$selection.'.png', 'width=180px') ?></div>
<h1><?php echo __('Thank you!') ?></h1>
<p><?php echo __('Your choice has been saved and will definitely help us deciding the right way.<br />We appreciate your participation in our new logo poll.') ?></p>
<p><?php echo __('eMarketTurkey Team') ?></p>
<div class="hrsplit-3"></div>
<div>
<div class="column" style="margin-right: 25px;">
<?php echo link_to(__('eMarketTurkey Home'), '@homepage', array('class' => 'home', 'title' => __('Go to eMarketTurkey Home'))) ?>
</div>
<div class="column">
<?php echo link_to(__('Read Poll Comments'), 'newlogo/index', array('class' => 'comments', 'title' => __('Read Poll Comments'))) ?>
</div>
</div>