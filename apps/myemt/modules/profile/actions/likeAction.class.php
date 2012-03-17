<?php

class likeAction extends EmtAction
{
    
    public function execute($request)
    {
        $dislike = ($this->getRequestParameter('r') == 'true');
        $item = $this->getRequestParameter('item') ? myTools::unplug($this->getRequestParameter('item')) : null;

        if ($item)
        {
            $like = $this->sesuser->likes($item);
            if ($dislike)
            {
                if ($like) $like->delete();
            }
            elseif (!$like)
            {
                $like = new LikeIt();
                $like->setPosterId($this->sesuser->getId());
                $like->setPosterTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $like->setItemId($item->getId());
                $like->setItemTypeId($item->getObjectTypeId());
                $like->save();
            }
        }
        if ($this->_ref) $this->redirect($this->_ref);
        elseif ($this->getRequest()->getReferer()!='') $this->redirect($this->getRequest()->getReferer());
        else $this->redirect('@homepage');
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