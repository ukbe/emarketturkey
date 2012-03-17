<ol class="homemenu">
    <li><?php echo link_to(__('B2B Home'), '@homepage', (($sf_context->getRouting()->getCurrentRouteName()=='homepage' || $sf_context->getRouting()->getCurrentRouteName()=='homepage1') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Companies'), '@companies', ($sf_context->getRouting()->getCurrentRouteName()=='companies' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Products'), '@products', ($sf_context->getRouting()->getCurrentRouteName()=='products' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Selling Leads'), '@homepage', ($sf_context->getRouting()->getCurrentRouteName()=='selling-leads' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Buying Leads'), '@homepage', ($sf_context->getRouting()->getCurrentRouteName()=='buying-leads' ? 'class=selected' : '')) ?></li>
</ol>