<div class="col_948">
<?php include_partial('global/search_bar', array('params' => $params)) ?>

<div class="col_678">
    <div class="box_678 _title_Transparent">
        <dl class="grid">
            <dt><?php echo __('Job Posts') ?></dt>
            <?php foreach ($jobs as $job): ?>
            <dd>
                <ul>
                    <li class="_hrBranding"><a rel="spot" href="<?php echo url_for($job->getUrl()) ?>"><span style="background-image:url(<?php echo $job->getOwner()->getHRProfile()->getHRLogo() ? $job->getOwner()->getHRProfile()->getHRLogo()->getThumbnailUri() : $job->getOwner()->getLogo()->getThumbnailUri() ?>)"></span></a></li>
                    <li class="_hrCustomer"><a rel="spot" href="<?php echo url_for($job->getUrl()) ?>"><strong><?php echo $job->getOwner()->getHrProfile()->getName() ? $job->getOwner()->getHrProfile()->getName() : $job->getOwner() ?></strong></a></li>
                    <li class="_hrPosition"><a rel="spot" href="<?php echo url_for($job->getUrl()) ?>"><em><?php echo $job ?></em></a></li>
                </ul>
            </dd>
            <?php endforeach ?>
        </dl>
    </div>
    <div class="box_678">
        <h4><?php echo __('Jobs in Your Network') ?></h4>
        <dl class="grid">
            <dt><?php echo __('Job in Your Network')?></dt>
            <?php foreach ($network_jobs as $job): ?>
            <dd>
                <ul>
                    <li class="_hrBranding"><a rel="net_spot" href="<?php echo url_for($job->getUrl()) ?>"><span style="background-image:url(<?php echo $job->getOwner()->getHRProfile()->getHRLogo() ? $job->getOwner()->getHRProfile()->getHRLogo()->getThumbnailUri() : $job->getOwner()->getLogo()->getThumbnailUri() ?>)"></span></a></li>
                    <li class="_hrCustomer"><a rel="net_spot" href="<?php echo url_for($job->getUrl()) ?>"><strong><?php echo $job->getOwner()->getHrProfile()->getName() ? $job->getOwner()->getHrProfile()->getName() : $job->getOwner() ?></strong></a></li>
                    <li class="_hrPosition"><a rel="net_spot" href="<?php echo url_for($job->getUrl()) ?>"><em><?php echo $job ?></em></a></li>
                </ul>
            </dd>
            <?php endforeach ?>
        </dl>
    </div>
</div>

<div class="col_264">

    <div class="box_264">
        <ul class="jobs-right">
            <?php if ($platinum): ?>
            <li class="spot_mrec"><?php echo link_to(image_tag($platinum->getPlatinumImage()->getUri()), $platinum->getUrl()) ?></li>
            <?php endif ?>
            <?php foreach ($advanced as $adv): ?>
            <li class="spot_nrec"><?php echo link_to(image_tag($adv->getRectBoxImage()->getUri()), $adv->getUrl()) ?></li>
            <?php endforeach ?>
            <li>
            <?php if (count($branded)): ?>
                <ul>
                    <?php foreach ($branded as $brand): ?>
                    <li class="spot_srec"><?php echo link_to(image_tag($brand->getCubeBoxImage()->getUri()), $brand->getUrl()) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            </li>
        </ul>
    </div>

</div>
<br class="clear" />
</div>

<?php echo javascript_tag("
        $(document).ready(function() {
            $('.grid dd a').fancybox({
                titlePosition     : 'inside',
                overlayColor      : '#000',
                opacity           : '1',
                transitionOut : 'none',
                type: 'ajax',
                arrows: true,
                autoSize: true,
                fitToView: true,
                padding: '0'
            });
        });
") ?>