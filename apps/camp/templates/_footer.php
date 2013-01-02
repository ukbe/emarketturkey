		<footer style="position:relative;z-index:20">
			<dl>
				<dt><?php echo link_to(__('eMarketTurkey<sup>&reg;</sup> at a glance'), '@aboutus') ?></dt>
				<dd><?php echo link_to(__('For Individuals'), '@for-individuals') ?></dd>
				<dd><?php echo link_to(__('For Suppliers'), '@for-suppliers') ?></dd>
				<dd><?php echo link_to(__('For Chambers, Societies and Associations'), '@for-associations') ?></dd>
				<dt><?php echo link_to(__('Start Using'), '@services') ?></dd>
				<dd><?php echo link_to(__('Signup Free'), "@myemt.signup") ?></dd>
				<dd><?php echo link_to(__('Upgrade'), '@myemt.premium-services') ?></dd>
				<dd><?php echo link_to(__('Premium Services'), '@premium') ?></dd>
			</dl>

            <dl class="_ftAd">
                <dt></dt>
                <dd class="_ft_full_seal"><?php echo link_to(image_tag('layout/badges/ekonomi-seal-whitebg.S.tr.png'), '@gov-approved') ?></dd>
            </dl>

			<dl>
                <dt><?php echo link_to(__('Usage Terms'), '@terms') ?></dt>
                <dd><?php echo link_to(__('Terms of Use'), '@terms') ?></dd>
                <dd><?php echo link_to(__('Service Provider Policy'), '@terms') ?></dd>
                <dt><?php echo link_to(__('Privacy'), '@privacy') ?></dt>
                <dd><?php echo link_to(__('Privacy Policy'), '@privacy') ?></dd>
                <dd><?php echo link_to(__('Privacy Settings'), "@myemt.setup-privacy") ?></dd>
                <dd class="_ft_truste"><?php echo link_to(image_tag('//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_m.png', array('alt' => __('TRUSTe online privacy certification'), 'style' => 'border: none;')), '//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_m', array('title' => __('TRUSTe online privacy certification'), 'target' => '_blank')) ?></dd>
			</dl>

			<dl>

				<dt class="_ftLn"><a href="">International</a> : </dt><dd class="_ftLn">
                    <?php echo form_tag($sf_request->getUri(), 'method=GET') ?>
                        <div><?php echo select_tag('x-cult', options_for_select(array('en' => 'English', 'tr' => 'Türkçe'), $sf_user->getCulture()), array('onchange' => "$(this).closest('form').submit();")) ?></div>
                    </form></dd>

                <dt><?php echo link_to(__('Support'), '@support') ?></dt>
                <dd><?php echo link_to(__('Help Center'), '@help-center') ?></dd>
                <dd><?php echo link_to(__('Frequently Asked Questions (FAQ)'), '@faq') ?></dd>
                <dt><?php echo link_to(__('Contact Us'), '@contactus') ?></dt>
                <dd><?php echo link_to(__('Corporate Communications'), '@contactus?topic='.CustomerMessagePeer::CM_TPC_CORPORATE_COMM) ?></dd>
                <dd><?php echo link_to(__('Work for eMarketTurkey'), '@contactus?topic='.CustomerMessagePeer::CM_TPC_WORK_FOR_EMT) ?></dd>
                <dd class="_ftSM">eMarketTurkey  <sup>&reg;</sup></dd>
                <dd class="_ft_SMfb" title="Facebook"><a href="http://www.facebook.com/eMarketTurkey" target="_blank">Facebook</a></dd>
                <dd class="_ft_SMli" title="LinkedIn"><a href="http://www.linkedin.com/company/emarketturkey-business-services" target="_blank">LinkedIn</a></dd>
                <dd class="_ft_SMtw" title="Twitter"><a href="http://twitter.com/#!/emarketturkey" target="_blank">Twitter</a></dd>
			</dl>

		</footer>