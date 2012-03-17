            <ul class="_side">
                <li<?php echo checkActivePage('@products-overview', null) ?>><?php echo link_to(__('Products Overview'), "@products-overview?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@add-product', null) ?>><?php echo link_to(__('Add Product'), "@add-product?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@list-products', null) ?>><?php echo link_to(__('Manage Products'), "@list-products?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@list-product-groups', null) ?>><?php echo link_to(__('Product Groups'), "@list-product-groups?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@product-statistics', null) ?>><?php echo link_to(__('Statistics'), "@product-statistics?hash={$company->getHash()}") ?></li>
            </ul>
            <br />
            <ul class="_side">
                <li<?php echo checkActivePage('@post-selling-lead', null) ?>><?php echo link_to(__('Post Selling Lead'), "@post-selling-lead?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@post-buying-lead', null) ?>><?php echo link_to(__('Post Buying Lead'), "@post-buying-lead?hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('@list-leads', null) ?>><?php echo link_to(__('Manage Leads'), "@list-leads?hash={$company->getHash()}") ?></li>
            </ul>