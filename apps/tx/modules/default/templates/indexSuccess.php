<div class="col_948">
<div class="presentation">

    <div class="boxTitle">
        <h2>
            Translators Directory
        </h2>
    </div>

    <div class="boxContent tabs noBorder">

        <dl class="_translation">
        </dl>
    </div>

    <div class="slidetabs">
        <a href="#">Translators Directory</a>
    </div>
</div>
    
    <div class="hrsplit-2"></div>

    <div class="col_312">
        <div class="box_312 noBorder">
            <div>
                <div class="pad-2">
                <?php echo image_tag('layout/background/translation-cloud.png', 'width=280') ?>
                </div>
            </div>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 pad-3 noBorder presentation">
            <h2><?php echo __('Welcome to eMarketTurkey Translation') ?></h2>
            <div class="hrsplit-2"></div>
            <h3><?php echo __('Are you a Translator?') ?></h3>
            <p><?php echo __('We are now calling Translators and Interpreters to register to Translators Directory. Apply for a translator account and once approved, get listed. You will be receiving translation requests.') ?></p>
            <h3><?php echo __('Corporate or Professional. All good!') ?></h3>
            <p><?php echo __('Are you running an agency? You may create a corporate account for your agency and receive translation requests for your business.') ?></p>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Register Now'), '@apply', 'class=dark-button') ?>
        </div>
    </div>

<?php $sql = "
select trunc(created_at), count(*) 
from emt_user
group by trunc(created_at)
";
$con = Propel::getConnection();
$stmt = $con->prepare($sql);
$stmt->execute();
 ?>
<div class="statwin">
<?php while ($row = $stmt->fetch(PDO::FETCH_NUM)): ?>
<div style="height: <?php echo $row[1] ?>px;" title="<?php echo $row[0] ?>"><?php echo $row[1] ?></div>
<?php endwhile ?>
</div>
<style>
.statwin { width: 90%; }
.statwin div { float: left; width: 10px; border: solid 1px black; background-color: red; color: white; font-size: 9px; padding: 2px;}
</style>
</div>
<?php echo javascript_tag("
$(function() {
    $('.slidetabs').tabs('.tabs > dl', {
        effect: 'fade',
        rotate: true
    }).slideshow({
        clickable: false,
        autoplay:true,
        interval:20000
    });
});

") ?>
