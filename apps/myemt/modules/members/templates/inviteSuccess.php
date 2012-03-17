<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('members/members', array('group' => $group)) ?>
        </div>
    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Invite to Group') ?></h4>
                <?php echo __('You can invite friends and companies in your network to join <b>%1g</b>.', array('%1g' => $group)) ?>
                <?php echo __('Start sending invitations by adding people, companies or email addresses to your target list.') ?>
                <?php link_to_function(__('Add Friends or Companies'), '') ?>
                <h5><?php echo __('Target List') ?></h5>
                <div class="pad-1">
                <div id="list-is-empty" class="t_grey t_small t_italic"><?php echo __('Your target list is empty.') ?></div>
                </div>
                <hr />
                <ul class="_horizontal sep">
                    <li>
                        <ul class="_horizontal">
                            <li class="t_grey"><?php echo __('Network:') ?></li>
                            <li><?php echo link_to(__('Add Friends'), "@network-list-add?_l=invgr&_g={$group->getPlug()}&_t=friend", 'class=act user-11px bluelink hover id=add-friends') ?></li>
                            <li><?php echo link_to(__('Add Companies'), "@network-list-add?_l=invgr&_g={$group->getPlug()}&_t=company", 'class=act company-11px bluelink hover id=add-companies') ?></li>
                        </ul>
                    </li>
                    <li>
                        <ul class="_horizontal">
                            <li class="t_grey"><?php echo __('Unlinked:') ?></li>
                            <li><?php echo link_to(__('Add Email Address'), "@network-list-add?_l=invgr&_g={$group->getPlug()}&_t=email", 'class=act at-symbol-11px bluelink hover id=add-emails') ?></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <div class="box_180">
        </div>

    </div>
</div>
<?php echo javascript_tag("
$(function() {
$('#add-friends, #add-companies, #add-emails').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, position: 'window'
    });
    
});

") ?>