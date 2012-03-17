<span id="toggleActivateLink<?php echo $product->getId() ?>">
<?php echo emt_remote_link(
                image_tag('layout/icon/'.($product->getActive()?'active-n':'active-grey-n').'.png', array('title' => $product->getActive()?__('De-Activate'):__('Activate'))), 
                'toggleActivateLink'.$product->getId(), 
                "@toggle-product?hash={$company->getHash()}&id={$product->getId()}", 
                array('do' => md5($product->getName().$product->getId().session_id())
           )) ?></span>
