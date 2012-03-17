<?php

class commentAction extends EmtAction
{
    
    public function execute($request)
    {
        if (!$this->sesuser) $this->redirect('@homepage');

        $this->cm = null;
        
        if ($this->getRequestParameter('mod') == 'rm' && $this->hasRequestParameter('hash'))
        {
            $id = base64_decode($this->getRequestParameter('hash'));
            $cm = CommentPeer::retrieveByPK($id);
            if ($cm && $this->sesuser && ($this->sesuser->isOwnerOf($cm->getItemId(), $cm->getItemTypeId()) ||
                    $this->sesuser->isOwnerOf($cm)))
            {
                $cm->setDeletedAt(time());
                $cm->save();
                return $this->renderText($this->getContext()->getI18N()->__('Comment removed.'));
            }
        }
        elseif ($this->hasRequestParameter('i1') && $this->hasRequestParameter('i2') && $this->hasRequestParameter('c1') && $this->hasRequestParameter('c2')
            && is_numeric($this->getRequestParameter('i1')) && is_numeric($this->getRequestParameter('i2')) && is_numeric($this->getRequestParameter('c1')) && is_numeric($this->getRequestParameter('c2')))
        {
            $item = PrivacyNodeTypePeer::retrieveObject($this->getRequestParameter('i1'), $this->getRequestParameter('i2'));
            $commenter = PrivacyNodeTypePeer::retrieveObject($this->getRequestParameter('c1'), $this->getRequestParameter('c2'));
            if ($item && $commenter && $this->getRequestParameter('c2')==1 && $commenter->getId()==$this->sesuser->getId())
            {
                $cm = new Comment();
                $cm->setCommenterId($this->getRequestParameter('c1'));
                $cm->setCommenterTypeId($this->getRequestParameter('c2'));
                $cm->setItemId($this->getRequestParameter('i1'));
                $cm->setItemTypeId($this->getRequestParameter('i2'));
                $cm->setText($this->getRequestParameter('comment-text'));
                $cm->save();
                $this->cm = $cm;
                
                $owner = PrivacyNodeTypePeer::getTopOwnerOf($item);
                $otherCommenters = CommentPeer::retrieveCommenters($item, array($owner->getId(), $commenter->getId()));
                
                // Send notification to item owner
                $data = new sfParameterHolder();
                $data->set('cname', $owner->getName());
                $data->set('uname', $commenter->__toString());
                $data->set('comment', $cm->getText());
                $data->set('declaration', $item->getDefineText($owner, $owner->getPreferredCulture('en')));
                $data->set('link', $item->getUrl());
                
                $vars = array();
                $vars['email'] = $owner->getLogin()->getEmail();
                $vars['user_id'] = $owner->getId();
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_COMMENT;
                
                EmailTransactionPeer::CreateTransaction($vars);
                
                // Send notification to other commenters
                $data = new sfParameterHolder();
                $data->set('uname', $commenter->__toString());
                $data->set('comment', $cm->getText());
                $data->set('link', $item->getUrl());

                foreach ($otherCommenters as $scommenter)
                {
                    $data->set('cname', $scommenter->getName());
                    $data->set('declaration', $item->getDefineText($scommenter, $scommenter->getPreferredCulture('en')));
                    
                    $vars = array();
                    $vars['email'] = $scommenter->getLogin()->getEmail();
                    $vars['user_id'] = $scommenter->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_COMMENT;
                    
                    EmailTransactionPeer::CreateTransaction($vars);
                }
            }
            else
            {
                return $this->renderText($this->getContext()->getI18N()->__('Item does not exist'));
            }
        }
        if ($this->getRequest()->isXmlHttpRequest())
        {
            return sfView::SUCCESS;
        }
        else
        {
            $this->redirect($this->getRequestParameter('ref'));
        }
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