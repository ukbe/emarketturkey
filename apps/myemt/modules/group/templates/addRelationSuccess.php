<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('group/account', array('group' => $group)) ?>
        </div>

    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($typ == 'parent'): ?>
            <h4><?php echo __('Add Parent Group') ?></h4>
            <?php elseif ($typ == 'subsidiary'): ?>
            <h4><?php echo __('Add Subsidiary Group') ?></h4>
            <?php else: ?>
            <h4><?php echo __('Add Parent or Subsidiary Group') ?></h4>
            <?php endif ?>
            <?php echo __('Please type group name to setup a relation with.') ?>
            <div class="hrsplit-2"></div>
            <?php echo form_tag("@group-account?action=relations&act=$act&hash={$group->getHash()}") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for("relation_keyword", __('Group Name')) ?></dt>
                <dd class="organiser-case-1<?php echo $rlgroup ? ' ghost' : '' ?>"><?php echo input_tag("relation_keyword", $sf_params->get('relation_keyword'), array('style' => 'width:200px;', 'maxlength' => 255)) ?></dd>
                <dd class="organiser-case-2<?php echo $rlgroup ? '' : ' ghost' ?>"><?php echo input_hidden_tag("group_id", $sf_params->get('group_id', $rlgroup ? $rlgroup->getId() : '')) ?>
                      <div id="organiser-block">
                      <?php if ($rlgroup): ?>
                      <?php include_partial('group/group', array('group' => $rlgroup)) ?>
                      <?php endif ?>
                      </div><?php echo link_to_function(__('change'), "$('.organiser-case-2').addClass('ghost');$(this).siblings('input').val('');$('#organiser-block').html('');$('#relation_keyword').val('');$('.organiser-case-1').removeClass('ghost');") ?></dd>

                <dt class="organiser-case-1<?php echo $rlgroup ? ' ghost' : '' ?>"></dt>
                <dd class="organiser-case-1<?php echo $rlgroup ? ' ghost' : '' ?>"><?php echo submit_tag(__('Search Group'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), "@group-account?action=relations&hash={$group->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
                <dt class="organiser-case-2<?php echo $rlgroup ? '' : ' ghost' ?>"><?php echo emt_label_for('typ', __('Select Relation Type')) ?></dt>
                <dd class="organiser-case-2<?php echo $rlgroup ? '' : ' ghost' ?>"><?php echo select_tag('typ', options_for_select(array('parent' => __('Parent Group'), 'subsidiary' => __('Subsidiary Group')), $sf_params->get('typ'), array('include_custom' => __('Please Select')))) ?></dd>
                <dt class="organiser-case-2<?php echo $rlgroup ? '' : ' ghost' ?>"></dt>
                <dd class="organiser-case-2<?php echo $rlgroup ? '' : ' ghost' ?>"><?php echo submit_tag(__('Save Relation'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), "@group-account?action=relations&hash={$group->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
            </dl>
            </form>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <?php include_partial('group/upgradeBox', array('group' => $group)) ?>
    </div>

</div>
<?php echo javascript_tag("
    $('#relation_keyword').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: 'http://my.geek.emt/en/group/query',
                dataType: 'jsonp',
                data: {
                    maxRows: 12,
                    typ: 'grp',
                    keyword: request.term
                },
                success: function( data ) {
                    response( $.map( data.ITEMS, function( item ) {
                        return {
                            label: item.NAME,
                            id: item.ID,
                            desc: item.CATEGORY,
                            logo: item.LOGO,
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'html',
                data: {
                    org: ui.item.id,
                    typ: 3
                },
                success: function( data ) {
                    $('#organiser-block').html(data);
                    $('#group_id').val(ui.item.id);
                }
            });
            $('.organiser-case-1').addClass('ghost');
            $('.organiser-case-2').removeClass('ghost');
        },
        open: function() {
            $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
        },
        close: function() {
            $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
        }
    })
    .data( 'autocomplete' )._renderItem = function( ul, item ) {
        return $('<li></li>')
            .data('item.autocomplete', item)
            .append('<a>' + (item.logo ? '<img src=\"http://vault.geek.emt/content/3/' + item.id + '/S/' + item.logo + '\" />' : '') + '<b>' + (item.label.length > 50 ? item.label.substr(0, 50) + '...' : item.label) + '</b><br>' + item.desc + '</a>')
            .appendTo(ul);
    };    

") ?>