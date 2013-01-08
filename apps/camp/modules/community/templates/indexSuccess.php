<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

<div class="col_948" class="position: relative;">

    <div class="col_471" style="height: 389px; width: 480px;margin: -10px 0px 0px -3px; border-bottom: solid 1px #ddd; padding: 10px 0px;
    -moz-box-shadow:0px 1px 0px 0px #f5f5f5;
    -webkit-box-shadow:0px 1px 0px 0px #f5f5f5;
    box-shadow:0px 1px 0px 0px #f5f5f5;
    ">
        <div class="box_471">
        
            <div class="_noBorder pad-3" style="height: 170px;">
                <h2 style="margin-bottom: 15px; font: bold 18px georgia;"><?php echo __('Search in Community')?></h2>
                <?php echo form_tag("@search-users", 'method=get') ?>
                <div class="txtCenter">
                <p><?php echo __('Search people or groups in community.')?></p>
                <?php echo input_tag('keyword', '', 'style=width: 300px; margin-top: 0px;padding: 5px; font: 13px arial;')?>
                <div class="hrsplit-2"></div>
                <?php echo submit_tag(__('Search'), 'class=submit-link')?>
                </div>
                </form>
            </div>
            <hr classs="split" />
            <div class="_noBorder pad-3" style="height: 170px;">
                <h2 style="margin-top: 5px; font: bold 18px georgia;"><?php echo __('Join the Community')?></h2>
                <div class="txtCenter" style="margin-top: 20px;">
                <p><?php echo __('Create your own group, and invite friends.')?></p>
                <?php echo link_to(__('Sign Up'), '@myemt.signup', 'class=submit-link margin-r2')?>
                <?php echo link_to(__('Create Group'), '@myemt.group-start', 'class=submit-link')?>
                </div>
            </div>
        </div>
        
    </div>
            <?php echo image_tag('layout/button/community-search.png', 'class=cm-search')?>
            <?php echo image_tag('layout/button/community-signup.png', 'class=cm-signup')?>

    <div class="col_471" style="width: 479px;margin: -10px -3px 0px 0px; background-color: #f6f7fb; border-left: solid 1px #eee; border-bottom: solid 1px #ddd; padding: 10px 0px;
 background: -webkit-gradient(linear,left center,right center,from(#f3f5fb),to(#f6f7fb));
    -moz-box-shadow:0px 1px 0px 0px #f5f5f5;
    -webkit-box-shadow:0px 1px 0px 0px #f5f5f5;
    box-shadow:0px 1px 0px 0px #f5f5f5;
    ">
        <div class="txtCenter" style="position: relative;">
            <?php echo image_tag('layout/background/emt-cm.png') ?>
        </div>
        
    </div>

    <div class="_left" style="width: 954px; margin: -3px 0px 0px;">

        <div class="box_471" style="width: 468px;">
            <h4 class="" style="border: none;"><?php echo __('Open Events') ?></h4>
            <div class="_noBorder" style="height: 90px; padding: 15px 10px;">
                <?php $events = EventPeer::doSelect(new Criteria()) ?>
                <table style="width: 100%; text-align: center; line-height: 14px;">
                <tr>
                <?php $i = 0 ?>
                <?php foreach ($events as $key => $event): ?>
                <?php if (!$event->getLogo()) continue; ?>
                <?php $i++ ?>
                <?php if ($i > 4) break; ?>
                <td style="vertical-align: top;"><?php echo link_to(image_tag($event->getLogoUri()), $event->getUrl()) ?>
                <span class="ln-example"><?php echo $event->getLocationText()?></span></td>
                <?php endforeach ?>
                </tr>
                </table>
            </div>
        </div>
        
        <div class="box_471" style="border-left: solid 1px #ddd;">
            <h4 style="border: none;"><?php echo __('Trending Groups') ?></h4>
            <div class="_noBorder" style="height: 90px; padding: 15px 10px;">
            <?php $c = new Criteria();
                  $c->addJoin(GroupPeer::ID, MediaItemPeer::OWNER_ID);
                  $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
                   ?>
            <?php $groups = GroupPeer::doSelect($c) ?>
                <table style="width: 100%; text-align: left; line-height: 14px;">
                <tr>
                <?php $i = 0 ?>
                <?php foreach ($groups as $group): ?>
                <?php $i++ ?>
                <?php if ($i > 2) break; ?>
                <td style="vertical-align: top;"><?php echo link_to(image_tag($group->getProfilePictureUri()), $group->getProfileUrl()) ?></td>
                <td style="vertical-align: top; padding: 5px;"><?php echo link_to($group, $group->getProfileUrl()) ?></td>
                <?php endforeach ?>
                </tr>
                </table>
            </div>
        </div>
    
    </div>
    
<style>
.cm-search { position: absolute; left: 457px; top: 85px; z-index: 20; }
.cm-signup { position: absolute; left: 457px; top: 300px; z-index: 20; }
hr.split { height: 1px; line-height: 1px; margin: 20px 5px; border: solid 1px #ccc; }

a.large-button, input.large-button {
    -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
    -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
    box-shadow:inset 0px 1px 0px 0px #ffffff;
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f5f5f5), color-stop(1, #cfcfcf) );
    background:-moz-linear-gradient( center top, #f5f5f5 5%, #cfcfcf 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5', endColorstr='#cfcfcf');
    background-color:#f5f5f5;
    -moz-border-radius:6px;
    -webkit-border-radius:6px;
    border-radius:6px;
    border:1px solid #dcdcdc;
    display:inline-block;
    color:#444;
    font-family:arial;
    font-size:15px;
    font-weight:normal;
    padding:6px 24px;
    text-decoration:none;
    text-shadow:1px 1px 0px #eee;
    cursor: pointer;
}
a.large-button:hover, input.large-button:hover {
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dddcdc), color-stop(1, #e5e5e5) );
    background:-moz-linear-gradient( center top, #dddcdc 5%, #e5e5e5 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dddcdc', endColorstr='#e5e5e5');
    background-color:#cfcfcf;
    text-shadow:1px 1px 0px #e3e3e3;
    -moz-box-shadow:inset 0px 1px 0px 0px #f5f5f5;
    -webkit-box-shadow:inset 0px 1px 0px 0px #f5f5f5;
    box-shadow:inset 0px 1px 0px 0px #f5f5f5;
}
</style>
</div>
