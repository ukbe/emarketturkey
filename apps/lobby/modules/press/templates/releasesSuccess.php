<?php use_helper('Date') ?>
<div class="col_948">

    <div class="col_180">
<?php include_partial('corporate/leftmenu')?>
    </div>

    <div class="col_576">
        <div class="box_576 noBorder">

            <h4><?php echo __('Press Releases') ?></h4>
            <div>
                <table class="press-releases">
                    <tr>
                        <td><?php echo link_to(image_tag('http://medya.todayszaman.com/todayszaman/images/logo/todays_yenilogo.bmp'), 'http://www.todayszaman.com/newsDetail_getNewsById.action?newsId=243390')?></td>
                        <td><h2><?php echo link_to('eMarketTurkey to increase awareness of Turkish companies', 'http://www.todayszaman.com/newsDetail_getNewsById.action?newsId=243390') ?></h2>
                            <span class="date"><?php echo format_date(mktime(0, 0, 0, 5, 9, 2011), 'D') ?></span>
                            <p>Turkey’s next generation Business-2-Business (B2B) Directory Services and Trade Portal eMarketTurkey aims to increase awareness of Turkish companies in the international arena with its large-scale database.</p>
                            </td>
                        <td><?php echo link_to(__('Website'), 'http://www.todayszaman.com/newsDetail_getNewsById.action?newsId=243390', 'class=action-button target=_blank') ?></td></tr>
                </table>
            </div>

        </div>
    </div>

</div>