		<footer style="position:relative;z-index:20">
			<dl>
				<dt><?php echo link_to(__('eMarketTurkey<sup>&reg;</sup> at a glance'), '@lobby.aboutus') ?></dt>
				<dd><?php echo link_to(__('For Individuals'), '@lobby.for-individuals') ?></dd>
				<dd><?php echo link_to(__('For Suppliers'), '@lobby.for-suppliers') ?></dd>
				<dd><?php echo link_to(__('For Chambers, Societies and Associations'), '@lobby.for-associations') ?></dd>
				<dt><?php echo link_to(__('Start Using'), '@lobby.services') ?></dd>
				<dd><?php echo link_to(__('Signup Free'), "@myemt.signup") ?></dd>
				<dd><?php echo link_to(__('Upgrade'), '@myemt.premium-services') ?></dd>
				<dd><?php echo link_to(__('Premium Services'), '@lobby.premium') ?></dd>
			</dl>

			<div class="subsection _ftAd">

			</div>

			<dl>
                <dt><?php echo link_to(__('Usage Terms'), '@lobby.terms') ?></dt>
                <dd><?php echo link_to(__('Terms of Use'), '@lobby.terms') ?></dd>
                <dd><?php echo link_to(__('Service Provider Policy'), '@lobby.terms') ?></dd>
                <dt><?php echo link_to(__('Privacy'), '@lobby.privacy') ?></dt>
                <dd><?php echo link_to(__('Privacy Policy'), '@lobby.privacy') ?></dd>
                <dd><?php echo link_to(__('Privacy Settings'), "@myemt.setup-privacy") ?></dd>
                <dd class="_ft_truste">
                    <div id="6441f5cf-ba19-4f40-914b-f06a38962c54"> <script type="text/javascript" src="//privacy-policy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/asc?rid=6441f5cf-ba19-4f40-914b-f06a38962c54"></script><a href="//privacy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/validation?rid=eef0516a-87b9-4e06-accc-f2ff9ec5c83a" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/seal?rid=eef0516a-87b9-4e06-accc-f2ff9ec5c83a" alt="TRUSTe online privacy certification"/></a></div>
                </dd>
			</dl>

			<dl>

				<dt class="_ftLn"><a href="">International</a> : </dt><dd class="_ftLn">
                    <?php echo form_tag($sf_request->getUri(), 'method=GET') ?>
                        <div><?php echo select_tag('x-cult', options_for_select(array('en' => 'English', 'tr' => 'Türkçe'), $sf_user->getCulture()), array('onchange' => "$(this).closest('form').submit();")) ?></div>
                    </form></dd>

                <dt><?php echo link_to(__('Support'), '@lobby.support') ?></dt>
                <dd><?php echo link_to(__('Help Center'), '@lobby.help-center') ?></dd>
                <dd><?php echo link_to(__('Frequently Asked Questions (FAQ)'), '@lobby.faq') ?></dd>
                <dt><?php echo link_to(__('Contact Us'), '@lobby.contactus') ?></dt>
                <dd><?php echo link_to(__('Corporate Communications'), '@lobby.contactus?topic='.CustomerMessagePeer::CM_TPC_CORPORATE_COMM) ?></dd>
                <dd><?php echo link_to(__('Work for eMarketTurkey'), '@lobby.contactus?topic='.CustomerMessagePeer::CM_TPC_WORK_FOR_EMT) ?></dd>
                <dd class="_ftSM">eMarketTurkey  <sup>&reg;</sup></dd>
                <dd class="_ft_SMfb" title="Facebook"><a href="http://www.facebook.com/eMarketTurkey" target="_blank">Facebook</a></dd>
                <dd class="_ft_SMli" title="LinkedIn"><a href="http://www.linkedin.com/company/emarketturkey-business-services" target="_blank">LinkedIn</a></dd>
                <dd class="_ft_SMtw" title="Twitter"><a href="http://twitter.com/#!/emarketturkey" target="_blank">Twitter</a></dd>
			</dl>

		</footer>