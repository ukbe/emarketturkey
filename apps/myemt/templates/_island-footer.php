		<footer class="small">
			<div>
				<ul class="_horizontal" style="line-height: 27px;">
					<li><?php echo link_to(__('About Us'), '@lobby.aboutus') ?></li>
                    <li><?php echo link_to(__('For Suppliers'), '@lobby.for-suppliers') ?></li>
                    <li><?php echo link_to(__('For Individuals'), '@lobby.for-individuals') ?></li>
                    <li><?php echo link_to(__('Privacy Policy'), '@lobby.privacy') ?></li>
                    <li><?php echo link_to(__('Terms of Use'), '@lobby.terms') ?></li>
                    <li><? echo form_tag($sf_request->getUri()) ?>
                        <?php echo select_tag('lang', options_for_select(array('tr' => 'Türkçe', 'en' => 'English'), $sf_user->getCulture()), 'class=ui-corner-all onchange=submit();') ?>
                        </form></li>
                    <li class="_right"><?php echo __('All rights reserved') ?>&nbsp;&nbsp;EMTPORT A.Ş.</li>
				</ul>
			</div>
		</footer>