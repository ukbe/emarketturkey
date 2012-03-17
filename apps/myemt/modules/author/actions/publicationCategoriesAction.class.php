<?php

class publicationCategoriesAction extends EmtAjaxAction
{
    public function execute($request)
    {
        return  $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        //if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                if ($this->hasRequestParameter('category_id') && is_numeric($this->getRequestParameter('category_id')))
                {
                    $this->category = PublicationCategoryPeer::retrieveByPK($this->getRequestParameter('category_id'));
                }
                if (!$this->category)
                {
                    //return 1;
                }
                
                $categories = $this->category->getSubCategories();
                $this->categories = array();
                foreach ($categories as $cat)
                    $this->categories[] = array('ID' => $cat->getId(), 'NAME' => $cat->getName());
                return $this->renderText(json_encode(array('ITEMS' => $this->categories)));
            }
            else
            {
                // error, so display error message
                return 2;
            }
        }
        //else return 3;
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}