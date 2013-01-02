<?php

class faqAction extends EmtAction
{
    public function execute($request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(FaqItemPeer::CATEGORY_ID);
        
        $this->faqs = FaqItemPeer::doSelect($c);
    }
    
    public function handleError()
    {
    }
    
}
