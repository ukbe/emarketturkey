<ol class="homemenu">
    <li><?php echo link_to(__('Community Home'), '@homepage', (($sf_context->getRouting()->getCurrentRouteName()=='homepage' || $sf_context->getRouting()->getCurrentRouteName()=='homepage1') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('People'), '@people', ($sf_context->getRouting()->getCurrentRouteName()=='people' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Groups'), '@groups', ($sf_context->getRouting()->getCurrentRouteName()=='groups' ? 'class=selected' : '')) ?></li>
</ol>