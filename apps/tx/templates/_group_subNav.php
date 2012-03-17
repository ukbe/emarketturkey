        <dl id="subNav">
            <dt><a href=""><?php echo __('Control Panel') ?></a></dt>
            <dd class="<?php echo checkActivePage('@companies', null, false, '_selected') ?>"><?php echo link_to(__('Overview'), 'http://tx.geek.emt/tr/default/AdminPage') ?></dd>
            <dd class="<?php echo checkActivePage('@companies', null, false, '_selected') ?>"><?php echo link_to(__('Company Information'), '@companies') ?></dd>
            <dd class="<?php echo checkActivePage('@homepage', null, true, '_selected') ?>"><?php echo link_to(__('Products and Services'), 'http://tx.geek.emt/tr/default/productEdit') ?></dd>
            <dd class="<?php echo checkActivePage('@homepage', null, true, '_selected') ?>"><?php echo link_to(__('Network Settings'), '@homepage') ?></dd>
            <dd class="<?php echo checkActivePage('@homepage', null, false, '_selected') ?>"><?php echo link_to(__('Calendar'), '@homepage') ?></dd>
            <dd class="<?php echo checkActivePage('http://tx.geek.emt/tr/default/jobs', null, true, '_selected') ?>"><?php echo link_to(__('Jobs'), 'http://tx.geek.emt/tr/default/jobs') ?></dd>
            <dd class="ui-corner-tr <?php echo checkActivePage('@products', null, true, '_selected') ?>"><?php echo link_to(__('Account Settings'), '@products') ?></dd>
            <dd class="_sp <?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('PREMIUM Services'), '@homepage') ?></dd>
        </dl>

		<div class="_comMng_header">
			<a href="" class="_comMng_logo"><img src="" alt="" /></a>
			<div class="_comMng_select">
				<strong class="ui-corner-all"><span>Firma-2 İsmi Uzun Ünvan</span></strong>
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
			</div>
			<ul class="hr_link_list">
				<li><a href="">Profile Git</a></li>
				<li><a href="">Logo Yükle / Değiştir</a></li>
				<li class="_last_item"><a href="">Mesajlar</a></li>
			</ul>
		</div>
