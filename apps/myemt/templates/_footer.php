		<footer style="position:relative;z-index:20">
			<dl>
				<dt><?php echo link_to(__('eMarketTurkey<sup>&reg;</sup> at a glance'), '@camp.aboutus') ?></dt>
				<dd><?php echo link_to(__('For Individuals'), '@camp.for-individuals') ?></dd>
				<dd><?php echo link_to(__('For Suppliers'), '@camp.for-suppliers') ?></dd>
				<dd><?php echo link_to(__('For Chambers, Societies and Associations'), '@camp.for-associations') ?></dd>
				<dt><?php echo link_to(__('Start Using'), '@camp.services') ?></dd>
				<dd><?php echo link_to(__('Signup Free'), "@signup") ?></dd>
				<dd><?php echo link_to(__('Upgrade'), '@premium-services') ?></dd>
				<dd><?php echo link_to(__('Premium Services'), '@camp.premium') ?></dd>
			</dl>

			<div class="subsection _ftAd">

			</div>

			<dl>
                <dt><?php echo link_to(__('Usage Terms'), '@camp.terms') ?></dt>
                <dd><?php echo link_to(__('Terms of Use'), '@camp.terms') ?></dd>
                <dd><?php echo link_to(__('Service Provider Policy'), '@camp.terms') ?></dd>
                <dt><?php echo link_to(__('Privacy'), '@camp.privacy') ?></dt>
                <dd><?php echo link_to(__('Privacy Policy'), '@camp.privacy') ?></dd>
                <dd><?php echo link_to(__('Privacy Settings'), "@setup-privacy") ?></dd>
                <dd class="_ft_truste">
                    <div id="6441f5cf-ba19-4f40-914b-f06a38962c54"> <script type="text/javascript" src="//privacy-policy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/asc?rid=6441f5cf-ba19-4f40-914b-f06a38962c54"></script><a href="//privacy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/validation?rid=eef0516a-87b9-4e06-accc-f2ff9ec5c83a" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/seal?rid=eef0516a-87b9-4e06-accc-f2ff9ec5c83a" alt="TRUSTe online privacy certification"/></a></div>
                </dd>
			</dl>

			<dl>

				<dt class="_ftLn"><a href="">International</a> : </dt><dd class="_ftLn">
                    <?php echo form_tag($sf_request->getUri(), 'method=GET') ?>
                        <div><?php echo select_tag('x-cult', options_for_select(array('en' => 'English', 'tr' => 'Türkçe', 'ru' => 'РУССКИЙ'), $sf_user->getCulture()), array('onchange' => "$(this).closest('form').submit();")) ?></div>
                    </form></dd>

                <dt><?php echo link_to(__('Support'), '@camp.support') ?></dt>
                <dd><?php echo link_to(__('Help Center'), '@camp.help-center') ?></dd>
                <dd><?php echo link_to(__('Frequently Asked Questions (FAQ)'), '@camp.faq') ?></dd>
                <dt><?php echo link_to(__('Contact Us'), '@camp.contactus') ?></dt>
                <dd><?php echo link_to(__('Corporate Communications'), '@camp.contactus?topic='.CustomerMessagePeer::CM_TPC_CORPORATE_COMM) ?></dd>
                <dd><?php echo link_to(__('Work for eMarketTurkey'), '@camp.contactus?topic='.CustomerMessagePeer::CM_TPC_WORK_FOR_EMT) ?></dd>
                <dd class="_ftSM">eMarketTurkey  <sup>&reg;</sup></dd>
                <dd class="_ft_SMgp" title="Google+"><a href="https://plus.google.com/113684589093964444271" target="_blank">Google+</a></dd>
                <dd class="_ft_SMtw" title="Twitter"><a href="http://twitter.com/#!/emarketturkey" target="_blank">Twitter</a></dd>
                <dd class="_ft_SMli" title="LinkedIn"><a href="http://www.linkedin.com/company/emarketturkey-business-services" target="_blank">LinkedIn</a></dd>
                <dd class="_ft_SMfb" title="Facebook"><a href="http://www.facebook.com/eMarketTurkey" target="_blank">Facebook</a></dd>
			</dl>

		</footer>