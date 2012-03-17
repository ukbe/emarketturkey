<?php

class messageTemplateAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function handleAction($isValidationError)
    {
        $this->profile = $this->owner->getHRProfile();

        $this->template = $this->profile->getMessageTemplateById($this->getRequestParameter('id'));
        
        if ($this->template instanceof JobMessageTemplate)
        {
            $this->i18ns = $this->template->getExistingI18ns();
        }
        elseif ($this->getRequestParameter('act') == 'new')
        {
            $this->template = new JobMessageTemplate();
            $this->i18ns = array();
        }
        else
        {
            $this->redirect404();
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $pr = $this->getRequestParameter('template_lang');
                $this->template->setDefaultLang($pr[0]);
                
                $this->template->setName ($this->getRequestParameter('template_name'));
                $this->template->setTypeId($this->getRequestParameter('template_type_id'));
                $this->template->setHrProfileId($this->profile->getId());
                $this->template->save();
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($this->template->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_JOB_MESSAGE_TEMPLATE_I18N 
                                    SET title=:title, content=:content
                                    WHERE id=:id AND culture=:culture
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_JOB_MESSAGE_TEMPLATE_I18N 
                                    (id, culture, title, content)
                                    VALUES
                                    (:id, :culture, :title, :content)
                            ";
                        }
                        
                        $stmt = $con->prepare($sql);
                        $t_content = $this->getRequestParameter("template_content_$key");
                        $stmt->bindValue(':id', $this->template->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':title', $this->getRequestParameter("template_title_$key"));
                        $stmt->bindParam(':content', $t_content, PDO::PARAM_STR, strlen($t_content));
                        $stmt->execute();
                    }
                }
                if (!$this->template->isNew() && count($diff = array_diff($this->i18ns, $pr))) $this->template->removeI18n($diff);

                $con->commit();
                $this->redirect("{$this->route}&action=messageTemplates");
            }
            catch(Exception $e)
            {
                $con->rollBack();
                ErrorLogPeer::Log($this->owner->getId(), $this->otyp, $e->getMessage(). ';' . $e->getFile() . ';' . $e->getLine());
            }
                
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
        $pr = $this->getRequestParameter('template_lang');
        $pr = is_array($pr)?$pr:array();
        
        sfLoader::loadHelpers('I18n');
        
        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $this->getRequest()->setError("template_lang_$key", __('Please select a language which you will provide template information in.'));
            if (trim($this->getRequestParameter("template_name")) == '')
                $this->getRequest()->setError("template_name", __('Please specify a template name'));
            if (mb_strlen($this->getRequestParameter("template_name")) > 50)
                $this->getRequest()->setError("template_name", __('Template name must be maximum %1 characters long.', array('%1' => 400)));
            if (trim($this->getRequestParameter("template_title_$key")) == '')
                $this->getRequest()->setError("template_title_$key", $lang ? __('Please enter a template title for %1 language', array('%1' => format_language($lang))) : __('Please enter a template title.'));
            if (mb_strlen($this->getRequestParameter("template_title_$key")) > 200)
                $this->getRequest()->setError("template_title_$key", $lang ? __('Template title for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 200)) : __('Template title must be maximum %1 characters long.', array('%1' => 200)));
            if (trim($this->getRequestParameter("template_content_$key")) == '')
                $this->getRequest()->setError("template_content_$key", $lang ? __('Please enter template content for %1 language', array('%1' => format_language($lang))) : __('Please enter template content.'));
            if (mb_strlen($this->getRequestParameter("template_content_$key")) > 5000)
                $this->getRequest()->setError("template_content_$key", $lang ? __('Template content for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 5000)) : __('Template content must be maximum %1 characters long.', array('%1' => 5000)));
        }
        return !$this->getRequest()->hasErrors();
    }
}