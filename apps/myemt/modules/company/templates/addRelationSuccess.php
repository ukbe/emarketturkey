<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('company/account', array('company' => $company)) ?>
        </div>

    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($typ == 'parent'): ?>
            <h4><?php echo __('Add Parent Company') ?></h4>
            <?php elseif ($typ == 'subsidiary'): ?>
            <h4><?php echo __('Add Subsidiary Company') ?></h4>
            <?php else: ?>
            <h4><?php echo __('Add Parent or Subsidiary Company') ?></h4>
            <?php endif ?>
            <?php echo __('Please type company name to setup a relation with.') ?>
            <div class="hrsplit-2"></div>
            <?php echo form_tag("@company-account?action=relations&act=$act&hash={$company->getHash()}") ?>
            <dl class="_table">

                <dt><?php echo emt_label_for("relation_keyword", __('Company Name')) ?></dt>
                <dd class="organiser-case-1<?php echo $rlcomp ? ' ghost' : '' ?>"><?php echo input_tag("relation_keyword", $sf_params->get('relation_keyword'), array('style' => 'width:200px;', 'maxlength' => 255)) ?></dd>
                <dd class="organiser-case-2<?php echo $rlcomp ? '' : ' ghost' ?>"><?php echo input_hidden_tag("company_id", $sf_params->get('company_id', $rlcomp ? $rlcomp->getId() : '')) ?>
                      <div id="organiser-block">
                      <?php if ($rlcomp): ?>
                      <?php include_partial('company/company', array('company' => $rlcomp)) ?>
                      <?php endif ?>
                      </div><?php echo link_to_function(__('change'), "$('.organiser-case-2').addClass('ghost');$(this).siblings('input').val('');$('#organiser-block').html('');$('#relation_keyword').val('');$('.organiser-case-1').removeClass('ghost');") ?></dd>

                <dt class="organiser-case-1<?php echo $rlcomp ? ' ghost' : '' ?>"></dt>
                <dd class="organiser-case-1<?php echo $rlcomp ? ' ghost' : '' ?>"><?php echo submit_tag(__('Search Company'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), "@company-account?action=relations&hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
                <dt class="organiser-case-2<?php echo $rlcomp ? '' : ' ghost' ?>"><?php echo emt_label_for('typ', __('Select Relation Type')) ?></dt>
                <dd class="organiser-case-2<?php echo $rlcomp ? '' : ' ghost' ?>"><?php echo select_tag('typ', options_for_select(array('parent' => __('Parent Company'), 'subsidiary' => __('Subsidiary Company')), $sf_params->get('typ'), array('include_custom' => __('Please Select')))) ?></dd>
                <dt class="organiser-case-2<?php echo $rlcomp ? '' : ' ghost' ?>"></dt>
                <dd class="organiser-case-2<?php echo $rlcomp ? '' : ' ghost' ?>"><?php echo submit_tag(__('Save Relation'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), "@company-account?action=relations&hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
            </dl>
            </form>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <?php include_partial('company/upgradeBox', array('company' => $company)) ?>
    </div>

</div>
<?php echo javascript_tag("
    $('#relation_keyword').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: 'http://my.geek.emt/en/company/query',
                dataType: 'jsonp',
                data: {
                    maxRows: 12,
                    typ: 'cmp',
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
                    typ: 2
                },
                success: function( data ) {
                    $('#organiser-block').html(data);
                    $('#company_id').val(ui.item.id);
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
            .append('<a>' + (item.logo ? '<img src=\"http://vault.geek.emt/content/2/' + item.id + '/S/' + item.logo + '\" />' : '') + '<b>' + (item.label.length > 50 ? item.label.substr(0, 50) + '...' : item.label) + '</b><br>' + item.desc + '</a>')
            .appendTo(ul);
    };    

") ?>