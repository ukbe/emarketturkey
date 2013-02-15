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

            <?php if ($sf_user->getCulture() == 'tr'): ?>
            <dl class="_ftAd">
                <dt></dt>
                <dd class="_ft_iskur"><?php echo image_tag('layout/icon/badge/iskur-oib-262x262.png') ?>
                    <div style="font-size:10px;">hr.emarketturkey.com, EMT İnsan Kaynakları ve Danışmanlık Ltd. Şti.'ne ait bir kariyer platformudur.</div>
                    <div class="hrsplit-1"></div>
                    EMT İnsan Kaynakları ve Danışmanlık Ltd. Şti. Türkiye İş Kurumu 17.03.2011 tarih 455 numaralı izin belgesi ile faaliyetlerini sürdürmektedir.
                    4904 sayılı Türkiye İş Kurumu Kanunu gereğince iş arayanlardan ücret alınması yasaktır.
                    </dd>
            </dl>
            <?php else: ?>
            <div class="subsection _ftAd"></div>
            <?php endif ?>

			<dl>
                <dt><?php echo link_to(__('Usage Terms'), '@terms') ?></dt>
                <dd><?php echo link_to(__('Terms of Use'), '@terms') ?></dd>
                <dd><?php echo link_to(__('Service Provider Policy'), '@terms') ?></dd>
                <dt><?php echo link_to(__('Privacy'), '@privacy') ?></dt>
                <dd><?php echo link_to(__('Privacy Policy'), '@privacy') ?></dd>
                <dd><?php echo link_to(__('Privacy Settings'), "@myemt.setup-privacy") ?></dd>
                <dd class="_ft_truste">
                    <div id="6441f5cf-ba19-4f40-914b-f06a38962c54"> <script type="text/javascript" src="//privacy-policy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/asc?rid=6441f5cf-ba19-4f40-914b-f06a38962c54"></script><a href="//privacy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/validation?rid=eef0516a-87b9-4e06-accc-f2ff9ec5c83a" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/privacy-seal/EMTPORT-Bilgi-Teknolojileri-A-S-/seal?rid=eef0516a-87b9-4e06-accc-f2ff9ec5c83a" alt="TRUSTe online privacy certification"/></a></div>
                </dd>
			</dl>

			<dl>

				<dt class="_ftLn"><a href="">International</a> : </dt><dd class="_ftLn">
                    <?php echo form_tag($sf_request->getUri(), 'method=GET') ?>
                        <div><?php echo select_tag('x-cult', options_for_select(array('en' => 'English', 'tr' => 'Türkçe', 'ru' => 'РУССКИЙ'), $sf_user->getCulture()), array('onchange' => "$(this).closest('form').submit();")) ?></div>
                    </form></dd>

                <dt><?php echo link_to(__('Support'), '@support') ?></dt>
                <dd><?php echo link_to(__('Help Center'), '@help-center') ?></dd>
                <dd><?php echo link_to(__('Frequently Asked Questions (FAQ)'), '@faq') ?></dd>
                <dt><?php echo link_to(__('Contact Us'), '@contactus') ?></dt>
                <dd><?php echo link_to(__('Corporate Communications'), '@contactus?topic='.CustomerMessagePeer::CM_TPC_CORPORATE_COMM) ?></dd>
                <dd><?php echo link_to(__('Work for eMarketTurkey'), '@contactus?topic='.CustomerMessagePeer::CM_TPC_WORK_FOR_EMT) ?></dd>
                <dd class="_ftSM">eMarketTurkey  <sup>&reg;</sup></dd>
                <dd class="_ft_SMgp" title="Google+"><a href="https://plus.google.com/113684589093964444271" target="_blank">Google+</a></dd>
                <dd class="_ft_SMtw" title="Twitter"><a href="http://twitter.com/#!/emarketturkey" target="_blank">Twitter</a></dd>
                <dd class="_ft_SMli" title="LinkedIn"><a href="http://www.linkedin.com/company/emarketturkey-business-services" target="_blank">LinkedIn</a></dd>
                <dd class="_ft_SMfb" title="Facebook"><a href="http://www.facebook.com/eMarketTurkey" target="_blank">Facebook</a></dd>
			</dl>

		</footer>