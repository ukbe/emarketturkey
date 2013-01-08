<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

<?php slot('footer') ?>
<?php include_partial('global/footer_hr') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_180">
    <?php if ($photo = $resume->getPhoto()): ?>
        <div class="box_180 txtCenter">
            <a class="editable-image" href="<?php echo url_for('@mycv-action?action=materials') ?>">
                <?php echo image_tag($photo->getMediumUri()) ?>
                <span class="edittag"><?php echo __('Change Photo') ?></span>
            </a>
        </div>
    <?php endif ?>
        <div class="col_180">
<?php include_partial('mycareer/leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_576">

        <div class="box_576">
            <h4><?php echo __('CV Materials') ?></h3>
            <div class="_noBorder pad-0">
                <div class="two_columns">
                    <div>
                        <div class="assetbox margin-r1">
                            <h5><?php echo __('CV Photo') ?></h5>
                            <div class="content">
                                <div class="_left margin-r2"><? echo photo_box($resume->getPhoto(), MediaItemPeer::LOGO_TYP_SMALL, MediaItemPeer::MI_TYP_RESUME_PHOTO) ?></div>
                                <div class="txtCenter margin-t2 margin-b2">
                                    <?php echo form_tag('@mycv-action?action=materials', 'multipart=true') ?>
                                    <?php echo input_file_tag('resume-photo', 'class=ghost-upload-input') ?>
                                    <?php echo $sf_request->hasError('resume-photo') ? '<span class="t_red">'.$sf_request->getError('resume-photo').'</span>' : ''?>
                                    <div><?php echo link_to_function(__('Upload New'), '', 'class=inherit-font bluelink hover upload-trigger') ?></div>
                                     </form>
                                    <div><?php echo __('or') ?></div>
                                    <?php echo form_tag('@mycv-action?action=materials', 'multipart=true') ?>
                                    <?php input_hidden_tag('resume-photo-select', '') ?>
                                    <div><?php echo link_to_function(__('Select Existing'), '', 'class=inherit-font bluelink hover upload-trigger id=select-ex') ?></div>
                                    </form>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="loader-spin">
                                <div class="dott">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="assetbox">
                            <h5><?php echo __('Hardcopy CV') ?></h5>
                            <div class="content">
                                <?php if ($hc = $resume->getHardcopyCV()): ?>
                                <div class="_left margin-r2"><?php echo image_tag($hc->getIcon()) ?></div>
                                <div class="_left"><strong><?php echo __('Static CV') ?></strong>
                                     <em class="ln-example"><?php echo __('Uploaded at %1date', array('%1date' => format_date($hc->getCreatedAt('U'), 'f'))) ?></em>
                                     <ul class="sepdot">
                                        <li><?php echo link_to(__('Download'), $hc->getOriginalFileUri(), 'class=bluelink') ?></li>
                                        <li><?php echo link_to(__('Delete'), "@mycv-action?action=materials&act=rmhcv", 'class=bluelink ajax-enabled id=remhcv') ?></li>
                                        <li><?php echo $sf_request->hasError('resume-hccv') ? '<span class="t_red">'.$sf_request->getError('resume-hccv').'</span>' : ''?>
                                            <?php echo form_tag('@mycv-action?action=materials', 'multipart=true') ?>
                                            <?php echo input_file_tag('resume-hccv', 'class=ghost-upload-input') ?>
                                            <?php echo link_to_function(__('Upload New'), '', 'class=bluelink upload-trigger id=upload-hccv') ?>
                                            </form></li>
                                     </ul>
                                 </div>
                                 <div class="clear"></div>
                                <?php else: ?>
                                <div class="txtCenter margin-t2 margin-b2">
                                    <?php echo $sf_request->hasError('resume-hccv') ? '<span class="t_red">'.$sf_request->getError('resume-hccv').'</span>' : ''?>
                                    <?php echo form_tag('@mycv-action?action=materials', 'multipart=true') ?>
                                    <?php echo input_file_tag('resume-hccv', 'class=ghost-upload-input') ?>
                                    <?php echo link_to_function(__('Upload Hardcopy CV'), '', 'class=inherit-font bluelink hover upload-trigger')?>
                                    </form>
                                </div>
                                <?php endif ?>
                            </div>
                            <div class="loader-spin">
                                <div class="dott">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hrsplit-1"></div>
                <div class="assetbox">
                    <h5>
                    <div class="_right">
                        <?php if (count($portfolio) > 4): ?>
                        <?php echo link_to_function(__('Upload New Item'), '', array('class' => 't_grey', 'title' => __('You should delete at least one of old items in order to upload new items.'))) ?>
                        <?php else: ?>
                        <?php echo form_tag('@mycv-action?action=materials', 'multipart=true') ?>
                        <?php echo input_file_tag('resume-portfolio', 'class=ghost-upload-input') ?>
                        <?php echo link_to_function(__('Upload New Item'), '', 'class=bluelink hover upload-trigger') ?>
                        <?php endif ?>
                        </form>
                    </div>
                    <?php echo __('Portfolio Items') ?></h5>
                    <div class="content">
                        <?php echo $sf_request->hasError('resume-portfolio') ? '<div class="pad-3 t_red">'.$sf_request->getError('resume-portfolio').'</div>' : ''?>
                        <?php if (count($portfolio)): ?>
                        <?php foreach ($portfolio as $pitem): ?>
                        <div class="_left margin-r2"><?php echo image_tag($pitem->getIcon()) ?></div>
                        <div class="_left"><strong><?php echo $pitem->getFilename() ?></strong>
                             <em class="ln-example"><?php echo __('Uploaded at %1date', array('%1date' => format_date($pitem->getCreatedAt('U'), 'f'))) ?></em>
                             <ul class="sepdot">
                                <li><?php echo link_to(__('Download'), $pitem->getOriginalFileUri(), 'class=bluelink') ?></li>
                                <li><?php echo link_to(__('Delete'), "@mycv-action?action=materials&act=rmpit&id={$pitem->getId()}", "class=bluelink ajax-enabled id=rempit{$pitem->getId()}") ?></li>
                             </ul>
                         </div>
                         <div class="hrsplit-2"></div>
                        <?php endforeach ?>
                        <?php else: ?>
                        <div>
                        <?php echo __('You may upload portfolio files like Project Presentations, Sample Workshop Items, Past Client Items or other files in several file formats.') ?>
                        </div>
                        <div class="hrsplit-1"></div>
                        <?php echo form_tag('@mycv-action?action=materials', 'multipart=true') ?>
                        <?php echo input_file_tag('resume-portfolio', 'class=ghost-upload-input') ?>
                        <?php echo link_to_function(__('Upload New Portfolio Item'), '', 'class=inherit-font bluelink hover upload-trigger') ?>
                        </form>
                        <?php endif ?>
                    </div>
                    </form>
                    <div class="loader-spin">
                        <div class="dott">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('cv-steps-right', array('sesuser' => $sesuser, 'resume' => $resume)) ?>
        
    </div>
</div>
<?php echo javascript_tag("
$(function(){
    $('.ghost-upload-input').change(function(){ $(this).closest('form').submit();  return false; });
    $('.upload-trigger').click(function(){ $(this).closest('form').find('input[type=file]').click(); $(this).closest('form').submit(function(){ $(this).closest('.content').parent().addClass('loading'); }); return false; });
    $('.ajax-enabled').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
        loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, position: 'window'
        });
});
") ?>