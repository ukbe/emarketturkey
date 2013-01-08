<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class ignoreAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->user = myTools::unplug($this->getRequestParameter('user'), true);

        if (!$this->user && ($this->getRequest()->isXmlHttpRequest() || $this->hasRequestParameter('callback'))) return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
        if (!$this->user) $this->redirect('@myemt.homepage');

        header('Content-type: text/html');

        $con = Propel::getConnection();
         
        if (!$this->sesuser->hasIgnoredUser($this->user->getId()) && !$this->sesuser->isFriendsWith($this->user->getId()))
        {
            try {
                $con->beginTransaction();
                $ignore = new IgnoreAdvise();
                $ignore->setUserId($this->sesuser->getId());
                $ignore->setRelatedUserId($this->user->getId());
                $ignore->save();
                $con->commit();
            }
            catch (Exception $e)
            {
                $con->rollBack();
                return $this->renderText($this->getContext()->getI18N()->__('Error Occured!'));
            }
            if ($this->getRequest()->isXmlHttpRequest())
                return $this->renderPartial('people/ajaxIgnore', array('plug' => $this->user->getPlug(), 'message' => 'Contact is ignored!'));
            elseif ($this->hasRequestParameter('callback'))
                return $this->renderText($this->getRequestParameter('callback')."(".json_encode(array('content' => $this->getPartial('people/ajaxIgnore', array('plug' => $this->user->getPlug(), 'message' => $this->getContext()->getI18N()->__('Contact is ignored!'), 'redir' => $this->_ref ? $this->_ref : null)))).");");
        }
        else
        {
            return $this->renderText($this->getContext()->getI18N()->__('Invalid Request!'));
        }
    }
}