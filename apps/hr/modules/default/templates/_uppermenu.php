<ol class="homemenu">
    <li><?php echo link_to(__('Career Home'), '@homepage', (($sf_context->getRouting()->getCurrentRouteName()=='homepage' || $sf_context->getRouting()->getCurrentRouteName()=='homepage1') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('My Career'), '@mycareer', ($sf_context->getModuleName()=='mycareer' || $sf_context->getModuleName()=='hr_cv' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Job Search'), '@homepage', ($sf_context->getRouting()->getCurrentRouteName()=='job-search' ? 'class=selected' : '')) ?></li>
</ol>