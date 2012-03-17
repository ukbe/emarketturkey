<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('groupProfile/editProfile', array('group' => $group)) ?>
        </div>
    </div>
<?php echo $sf_user->getFlash('message') ?>
    <div class="col_576">
            <section>
                <h4><?php echo __('Group Logo') ?></h4>
                <div class="_center">
                    <br class="clear" />
                    <table style="margin: 0px; width: 100%; border: solid 2px #ddd; background-color: #F6F6F6;">
                        <tr>
                            <td style="margin: 0px; width: 400px; vertical-align: middle; text-align: center;"> 
                            <div id="cropbox" class="_comMng_nologo" style="width: 400px; height: 300px; text-align: center;background-color: white;">
                                <?php echo $logo ? image_tag($logo->getOriginalFileUri()) : '' ?>
                            </div>
                            </td>
                            <td style="background-color: #EFEFEF; vertical-align: middle; text-align: center;">
                                <div id="preview" style="margin: auto;"></div>
                                <?php echo form_tag("@upload-group-logo?hash={$group->getHash()}") ?>
                                <?php echo input_hidden_tag('process', 'thumb') ?>
                                <?php echo input_hidden_tag('crop', $logo ? $logo->getCrop() : '') ?>
                                <?php echo input_hidden_tag('ref', $logo ? $logo->getGuid() : '') ?>
                                <?php echo input_hidden_tag('coords', $logo ? $logo->getOffsetCoords() : '') ?>
                                <?php echo submit_tag(__('Save'), 'id=savephoto') ?>&nbsp;&nbsp;
                                <?php echo link_to_function(__('Remove'), 'id=removephoto') ?>
                                </form>
                            </td>
                        </tr>
                    </table> 
                
                    <br class="clear" />
                    <div class="clear">
                        <!-- the tabs -->
                        <ul class="tabs">
                            <li><a href="#"><?php echo __('Upload Logo') ?></a></li>
                            <li><a href="#"><?php echo __('Select Existing') ?></a></li>
                        </ul>
                        
                        <!-- tab "panes" -->
                        <div class="panes">
                            <div class="pad-2">
                                <?php echo form_tag("@upload-group-logo?hash={$group->getHash()}", array('enctype' => 'multipart/form-data', 'id' => 'thumbform')) ?>
                                <div class="error-block"></div>
                                <dl class="_table">
                                <dt class="frm-st-select"><?php echo emt_label_for('grouplogo', 'Please select a file') ?></dt>
                                <dd class="frm-st-select"><?php echo input_file_tag('grouplogo') ?></dd>
                                <dt class="frm-st-select"></dt>
                                <dd class="frm-st-select"><?php echo submit_tag(__('Upload Photo'), 'class=frm-submit') ?></dd>
                                <dt class="frm-st-process"></dt>
                                <dd class="frm-st-process"><?php echo __('Loading .. ') . image_tag('layout/icon/loading.gif') ?></dd>
                                <dt class="frm-st-process"></dt>
                                <dd class="frm-st-process"><?php echo link_to_function(__('Cancel Upload'), '', 'id=cancelupload') ?></dd>
                                </dl>
                                </form>
                            </div>
                            <div class="pad-2">
                                <?php $images = $group->getMediaItems() ?>
                                <?php if (count($images)): ?>
                                <ul id="gallery">
                                <?php foreach ($images as $img): ?>
                                    <li><?php echo image_tag($img->getThumbnailUri(), 'alt='.$img->getOriginalFileUri()) ?></li>
                                <?php endforeach ?>
                                </ul>
                                <?php else: ?>
                                <?php endif ?>
                            </div>
                        </div>

    <style>
    #gallery { height: 50px; }
    .beijing { background: #eee; border: solid 2px #596d94; }
    #gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
    #gallery li h5 { margin: 0 0 0.4em; cursor: move; }
    #gallery li a { float: right; }
    #gallery li a.ui-icon-zoomin { float: left; }
    #gallery li img { cursor: move; border: solid 1px #dedede; }


    #croptoggle.active {background: url(/images/layout/icon/minimize.png) no-repeat left top;}
    #croptoggle {display: inline-block; background: url(/images/layout/icon/maximize.png) no-repeat left top; width: 16px; height: 16px; line-height: 16px; }

    .state-hover {border-color: red;}
        
    </style>

                    </div>
                </div>
            </section>
    </div>

    <div class="col_180">

    </div>
    
</div>

<?php echo javascript_tag("
$(function(){
        $('ul.tabs').tabs('div.panes > div');
        $('#cropbox').logoWidget({formSelector: '#thumbform', imageUrl: '', prwDims: [100, 50], crop: ".($logo && $logo->getCrop() ? 'true' : 'false').", left: ".($logo && is_numeric($logo->getOffsetCoord('x')) ? $logo->getOffsetCoord('x') : 'undefined').", top: ".($logo && is_numeric($logo->getOffsetCoord('y')) ? $logo->getOffsetCoord('y') : 'undefined').", right: ".($logo && is_numeric($logo->getOffsetCoord('x2')) ? $logo->getOffsetCoord('x2') : 'undefined').", bottom: ".($logo && is_numeric($logo->getOffsetCoord('y2')) ? $logo->getOffsetCoord('y2') : 'undefined')."});
});

") ?>
