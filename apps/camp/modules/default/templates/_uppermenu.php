<ol class="homemenu">
    <li><?php echo link_to(__('Welcome'), '@homepage', (($sf_context->getRouting()->getCurrentRouteName()=='homepage' || $sf_context->getRouting()->getCurrentRouteName()=='homepage1') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Corporate Info'), '@aboutus', ($sf_context->getRouting()->getCurrentRouteName()=='aboutus' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('For Individuals'), '@for-individuals', ($sf_context->getRouting()->getCurrentRouteName()=='for-individuals' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('For Suppliers'), '@for-suppliers', ($sf_context->getRouting()->getCurrentRouteName()=='for-suppliers' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('FAQ'), '@faq', ($sf_context->getRouting()->getCurrentRouteName()=='faq' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Contact Us'), '@contactus', ($sf_context->getRouting()->getCurrentRouteName()=='contactus' ? 'class=selected' : '')) ?></li>
</ol>