<ol class="homemenu">
    <li><?php echo link_to(__('Academy Home'), '@homepage', (($sf_context->getRouting()->getCurrentRouteName()=='homepage' || $sf_context->getRouting()->getCurrentRouteName()=='homepage1') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Articles'), '@articles', ($sf_context->getRouting()->getCurrentRouteName()=='articles' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('News'), '@news-home', ($sf_context->getRouting()->getCurrentRouteName()=='news-home' ? 'class=selected' : '')) ?></li>
</ol>