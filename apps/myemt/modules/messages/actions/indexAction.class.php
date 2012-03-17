<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtAction
{
    
    public function execute($request)
    {
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->hasRequestParameter('callback'))
        {
            $con = Propel::getConnection();

            $sql = "
    SELECT * FROM
    (
        SELECT EMT_MESSAGE_RECIPIENT.* 
        FROM EMT_MESSAGE
        LEFT JOIN EMT_MESSAGE_RECIPIENT ON EMT_MESSAGE.ID=EMT_MESSAGE_RECIPIENT.MESSAGE_ID
        LEFT JOIN
        (
            SELECT {$this->sesuser->getId()} ID, ".PrivacyNodeTypePeer::PR_NTYP_USER." TYPE_ID FROM DUAL

            UNION ALL

            SELECT COMPANY_ID ID, ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." TYPE_ID FROM EMT_COMPANY_USER_VIEW
            LEFT JOIN EMT_COMPANY ON EMT_COMPANY_USER_VIEW.COMPANY_ID=EMT_COMPANY.ID
            WHERE ROLE_ID=".RolePeer::RL_CM_OWNER." AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND OBJECT_ID={$this->sesuser->getId()}

            UNION ALL

            SELECT GROUP_ID ID, ".PrivacyNodeTypePeer::PR_NTYP_GROUP." TYPE_ID FROM EMT_GROUP_MEMBERSHIP_VIEW
            LEFT JOIN EMT_GROUP ON EMT_GROUP_MEMBERSHIP_VIEW.GROUP_ID=EMT_GROUP.ID
            WHERE ROLE_ID=".RolePeer::RL_GP_OWNER." AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND OBJECT_ID={$this->sesuser->getId()}
        ) OBJ ON OBJ.ID=EMT_MESSAGE_RECIPIENT.RECIPIENT_ID
        WHERE EMT_MESSAGE_RECIPIENT.RECIPIENT_TYPE_ID=OBJ.TYPE_ID
        ORDER BY EMT_MESSAGE.CREATED_AT DESC
    )
    WHERE ROWNUM < 10
            ";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $messages = MessageRecipientPeer::populateObjects($stmt);
            $items = array();
            
            sfLoader::loadHelpers(array('Url', 'Date'));
            
            foreach ($messages as $mess)
            {
                $items[] = array('IMG' => $mess->getMessage()->getSender()->getProfilePictureUri(), 'NAME' => $mess->getMessage()->getSender()->__toString(), 'MSG' => $mess->getMessage()->getBody(), 'LINK' => url_for('@homepage', true), 'DATE' => format_datetime($mess->getMessage()->getCreatedAt('U'), 'r'), 'NEW' => !$mess->getIsRead());
            }
            $items = array('NEW' => count($items), 'ITEMS' => $items);
            
            return $this->renderText($this->getRequestParameter('callback') . "(" . json_encode($items) . ");");
        }
        return $this->renderText('Not Applicable');
        
        // Codes below are expected to be replaces
        $filter  = array('inbox' => 1,
                         'sent' => 2,
                         'archived' => 3);
        
        $this->user = $this->getUser()->getUser();
        $this->company = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());
        if ($this->company && !$this->user->isOwnerOf($this->company)) $this->redirect404();
        
        $this->mod = $this->getRequestParameter('mod');
        $this->companies = $this->user->getCompanies(RolePeer::RL_CM_OWNER);
        
        if (array_key_exists($this->getRequestParameter('cls', 'inbox'), $filter))
            $this->folder = $this->getRequestParameter('cls', 'inbox');
        else
            $this->folder = 'inbox';
            
        if ($this->folder == 'sent')
        {
            $this->messages = ($this->mod=='cm'&&$this->company)?$this->company->getSentMessages():$this->user->getSentMessages();
        }
        elseif ($this->folder == 'archived')
        {
            $this->messages = ($this->mod=='cm'&&$this->company)?$this->company->getArchivedMessages():$this->user->getArchivedMessages();
        }
        else
        {
            $this->messages = ($this->mod=='cm'&&$this->company)?$this->company->getMessages():$this->user->getMessages();
        }
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        return $this->handleAction(true);
        return sfView::SUCCESS;
    }
}