<?php

class byCategoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->categories = ProductCategoryPeer::getBaseCategories();
    }

}
