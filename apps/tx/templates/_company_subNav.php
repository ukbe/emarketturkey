		<header>
			<hgroup class="_comSel">
				<a href=""><img src="abcd" alt="logo" width="200" height="50" /></a>
				<ul class="_horizontal">
					<li><a href="">Profile Git</a></li>
					<li><a href="">Logo Yükle / Değiştir</a></li>
					<li><a href="">Mesajlar</a></li>
				</ul>
				<dl>
					<dt>
						<em>ABC</em>
					</dt>
					<dd>
						<ul>
							<li><a href="">Firma-1 Kısa Ünvan</a></li>
							<li><a href="">Firma-3 Kısa Ünvan</a></li>
							<li><a href="">Firma-4 Kısa Ünvan</a></li>
							<li class="_bottom_comMng_links">
								<a href="" class="_left">Firma Düzenle</a>
								<a href="" class="_right">Firma Ekle</a>
								<br class="clear" />
							</li>
						</ul>
					</dd>
				</dl>

			</hgroup>
			<nav>
		        <dl id="subNav">
		            <dt><a href=""><?php echo __('Control Panel') ?></a></dt>
		            <dd<?php echo checkActivePage('@companies', null, true, '_selected') ?>><?php echo link_to(__('Overview'), 'http://tx.geek.emt/tr/default/AdminPage') ?></dd>
		            <dd<?php echo checkActivePage('default/companyEdit', null, true, '_selected') ?>><?php echo link_to(__('Company Information'), 'default/companyEdit') ?></dd>
		            <dd<?php echo checkActivePage('default/productEdit', null, true, '_selected') ?>><?php echo link_to(__('Products and Services'), 'default/productEdit') ?></dd>
		            <dd<?php echo checkActivePage('@homepage', null, true, '_selected') ?>><?php echo link_to(__('Network Settings'), '@homepage') ?></dd>
		            <dd<?php echo checkActivePage('@homepage', null, true, '_selected') ?>><?php echo link_to(__('Calendar'), '@homepage') ?></dd>
		            <dd<?php echo checkActivePage('default/jobs', null, true, '_selected') ?>><?php echo link_to(__('Jobs'), 'default/jobs') ?></dd>
		            <dd class="ui-corner-tr <?php echo checkActivePage('@products', null, true, '_selected') ?>"><?php echo link_to(__('Account Settings'), '@products') ?></dd>
		            <dd class="_sp <?php echo checkActivePage('--UPGRADE', null, true, '_selected') ?>"><?php echo link_to(__('PREMIUM Services'), '@homepage') ?></dd>
		        </dl>
			</nav>
		</header>

