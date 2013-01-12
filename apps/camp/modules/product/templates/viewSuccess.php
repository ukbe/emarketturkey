<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<?php use_helper('Date') ?>
<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <?php if ($lead->getTypeId() == B2bLeadPeer::B2B_LEAD_BUYING): ?>
            <li><?php echo link_to(__('Buying Leads'), '@buying-leads') ?></li>
            <?php else: ?>
            <li><?php echo link_to(__('Selling Leads'), '@selling-leads') ?></li>
            <?php endif ?>
            <li><?php echo link_to($lead->getProductCategory()->__toString(), "@leads-dir?type_code={$lead->getTypeCode()}&substitute={$lead->getProductCategory()->getStrippedCategory()}") ?></li>
            <li><span><?php echo $lead ?></span></li>
        </ul>
    </div>

    <div class="hrsplit-2"></div>

    <div class="col_180">
    <?php if (count($photos) && ($photo = $photos[0])): ?>
        <div class="box_180 txtCenter">
            <?php echo link_to_function(image_tag($photo->getMediumUri()), '') ?>
        </div>
    <?php endif ?>
        <div class="box_180 txtCenter">
            <div class="_noBorder txtCenter">
                <div class="t_smaller t_grey"><?php echo __('Valid by:') ?></div>
                <div class="clndr-leaf" style="display: inline-block">
                    <div><?php echo strtoupper(format_date($lead->getExpiresAt('U'), 'MMMM')) ?></div>
                    <?php echo $lead->getExpiresAt('d') ?>
                </div>
            </div>
        </div>
        <div class="hrsplit-2"></div>
        <div class="box_180 txtCenter">
            <div class="_noBorder txtCenter">
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style" style="display: inline-block;">
                    <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact"><?php echo __('Bookmark/Share')?></a>
                </div>
                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
                <!-- AddThis Button END -->
                <div class="hrsplit-2"></div>
                <?php echo like_button($lead) ?>
            </div>
        </div>
    </div>
            
    <div class="col_576 b2bProduct">

        <h3 class="pname"><?php echo $lead ?></h3>
        <div>
            <div class="box_576">
                <div class="_noBorder pad-0">
                <?php if ($lead->getDescription()): ?>
                <div class="pad-2">
                    <?php echo $lead->getDescription() ?>
                </div>
                <?php endif ?>
                <div>
                    <h4<?php echo !$lead->getDescription() ? '  class="margin-t0"' : '' ?>><?php echo __('Specifications') ?></h4>
                    <table class="infoTable margin-2" style="width: 542px;">
                        <tr><th><?php echo __('Lead Type') ?></th>
                            <td><?php echo __(B2bLeadPeer::$typeNames[$lead->getTypeId()]) ?></td></tr>
                        <tr><th><?php echo __('Category') ?></th>
                            <td><?php echo link_to($lead->getProductCategory()->__toString(), "@leads-dir?type_code={$lead->getTypeCode()}&substitute={$lead->getProductCategory()->getStrippedCategory()}") ?></td></tr>
                    </table>
                </div>
                <div>
                    <h4><?php echo __('Payment and Shipping') ?></h4>
                    <dl class="_table _noInput">
                        <dt><?php echo emt_label_for('none', __('Payment Terms')) ?></dt>
                        <dd class="two_columns" style="width: 400px;">
                            <?php foreach ($payment_terms as $term): ?>
                            <div><?php echo $term->__toString() ?></div>
                            <?php endforeach?>
                        </dd>
                    </dl>
                </div>
                
                <div>
                    <h4><?php echo __('Product Photos') ?></h4>
                    <?php if (count($photos)): ?>
                    <div class="photoGallery _noBorder">
                        <dl>
                            <dt><?php echo __('Product Photos') ?></dt>
                            <?php foreach ($photos as $ph): ?>
                            <dd>
                                <?php echo link_to(image_tag($ph->getThumbnailUri()), $ph->getUrl()) ?>
                            </dd>
                            <?php endforeach ?>
                        </dl>
                    </div>
                    <?php else: ?>
                    <div class="pad-2">
                    <?php echo __('No photos') ?>
                    </div>
                    <?php endif ?>
                </div>

                </div>
            </div>
        </div>

    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
            <h3><?php echo $lead->getTypeId() == B2bLeadPeer::B2B_LEAD_BUYING ? __('Buyer Information') : __('Supplier Information') ?></h3>
            <div class="t_smaller">
                <div class="txtCenter"><?php echo $company->getLogo() ? link_to(image_tag($company->getLogo()->getThumbnailUri()), $company->getProfileUrl()) : '' ?></div>
                <h4 class="txtCenter"><?php echo $company->__toString() ?></h4>
                <strong><?php echo __('Industry') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $company->getBusinessSector()->__toString() ?></div>
                <strong><?php echo __('Business Type') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $company->getBusinessType()->__toString() ?></div>
                <strong><?php echo __('Location') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $company->getLocationLabel() ?></div>
                <p><?php echo link_to(__('Go to Company Profile'), $company->getProfileUrl(), 'class=bluelink hover')?></p>
                <p><?php echo link_to($lead->getTypeId() == B2bLeadPeer::B2B_LEAD_BUYING ? __('Contact Buyer') : __('Contact Supplier'), $company->getProfileActionUrl('contact'), array('query_string' => "rel={$lead->getPlug()}", 'class' => 'contactlink'))?></p>
            </div>
        </div>
    </div>

</div>