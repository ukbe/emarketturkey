<?php

class routeAction extends EmtAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            if ($this->getRequestParameter('cp') == 'true')
            {
                try
                {
                    $this->sesuser->getLogin()->setPassword($this->getRequestParameter('new_password'));
                    $this->sesuser->getLogin()->save();
                    $p = 'window.parent.OnChangeComplete(1, []);';
                    return $this->renderText("<script>$p</script>");
                }
                catch (Exception $e)
                {
                    $p = 'window.parent.OnChangeComplete(0, []);';
                    return $this->renderText("<script>$p</script>");
                }
            }
        }
    }

    public function validate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$this->sesuser->getLogin()->checkPassword($this->getRequestParameter('old_password', '%NO_BLANK%')))
            {
                $this->getRequest()->setError('old_password', $this->getContext()->getI18N()->__('Type your old password correctly.'));
            }
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $messages = array();
        foreach ($this->getRequest()->getErrors() as $key => $err)
        {
            $messages[] = array($key, $this->getContext()->getI18N()->__($err));
        }
        if(count($messages))
        {
            $p = "window.parent.OnChangeComplete(0, ".json_encode($messages).");";
            return $this->renderText("<script>$p</script>");
        }
    }
}
