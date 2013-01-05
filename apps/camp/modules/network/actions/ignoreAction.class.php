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
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->redirect404();
        }

        if (!is_numeric($user_id = $this->getRequestParameter('user')))
        {
            $this->redirect404();
        }
        $con = Propel::getConnection();
         
        if ($this->getRequestParameter('ignore') == 'true' && !$this->sesuser->hasIgnoredUser($user_id))
        {
            try {
                $con->beginTransaction();
                $ignore = new IgnoreAdvise();
                $ignore->setUserId($this->sesuser->getId());
                $ignore->setRelatedUserId($user_id);
                $ignore->save();
                $con->commit();
            }
            catch (Exception $e)
            {
                $con->rollBack();
                return $this->renderText($this->getContext()->getI18N()->__('Error Occured!'));
            }
            return $this->renderText("<script>jQuery('#r$user_id').closest('tr').hide();</script>");
        }
        else
        {
            return $this->renderText($this->getContext()->getI18N()->__('Invalid Request!'));
        }
    }
}