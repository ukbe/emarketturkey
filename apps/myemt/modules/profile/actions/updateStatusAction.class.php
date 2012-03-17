<?php

class updateStatusAction extends EmtUserAction
{
    
    public function execute($request)
    {
        $user = $this->sesuser;
        
        if ($this->hasRequestParameter('msg'))
        {
            $user->setStatusUpdate($this->getRequestParameter('msg'));
        }
        if ($this->getRequest()->isXmlHttpRequest())
        {
            $str =  $this->getRequestParameter('msg');
            return $this->renderText(mb_strlen($str)> 200 ? mb_substr($str, 0, 200, 'utf-8')."<a href=\"#\" onclick=\"javascript:linkread(this);\" class=\"readmorelink\">".$this->getContext()->getI18n()->__('read more')."</a><span class='more'>".mb_substr($str, 200, -1, 'utf-8')."</span>" : $str);
        }
        else
            $this->getRequestParameter('ref')!='' ? $this->redirect($this->getRequestParameter('ref')) : $this->redirect($this->getRequest()->getReferrer());
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