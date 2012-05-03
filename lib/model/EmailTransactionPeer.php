<?php

class EmailTransactionPeer extends BaseEmailTransactionPeer
{

    CONST           EML_TR_STAT_WAIT            = 0;
    CONST           EML_TR_STAT_DELIVERED       = 1;
    CONST           EML_TR_STAT_FAILED          = 2;
    CONST           EML_TR_STAT_CANCELLED       = 3;
    
    public static $statusNames    = array(0 => 'Pending',
                                          1 => 'Delivered',
                                          2 => 'Failed',
                                          3 => 'Cancelled',
                                      );

    public static function CreateTransaction(array $vars, $deliver = true)
    {
        $tr = new EmailTransaction();
        $pref_cult = "en";
        $cults = sfConfig::get('app_i18n_cultures');
        
        if (array_key_exists('culture', $vars))
        {
            $pref_cult = $vars['culture'];
        }
        
        $usr = UserPeer::retrieveByPK($vars["user_id"]);
        if ($usr)
        {
            $prof = $usr->getUserProfile();
            if ($prof &&  in_array($prof->getPreferredLanguage(), $cults))
            {
                $pref_cult = $prof->getPreferredLanguage();
            }
        }
        $tr->setRcpntUserId($vars["user_id"]);
        $tr->setRcpntCompanyId(isset($vars["company_id"])?$vars["company_id"]:null);
        $tr->setEmail($vars["email"]);
        $tr->setNamespaceId($vars["namespace"]);
        $tr->setPreferredLang($pref_cult);
        $tr->save();

        $pholder = $vars["data"];
        $pholder->set('culture', $pref_cult);
        $con = Propel::getConnection();
        
        $sql = "UPDATE EMT_EMAIL_TRANSACTION 
                SET data=:data
                WHERE id=:id
        ";
        
        $stmt = $con->prepare($sql);
        $j_data = $pholder->serialize();
        $stmt->bindValue(':id', $tr->getId());
        $stmt->bindParam(':data', $j_data, PDO::PARAM_STR, strlen($j_data));
        $stmt->execute();

        //if ($deliver) $tr->deliver();
        return $tr;
    }
    
    public static function CommitTransaction(int $id)
    {
        $tr = self::retrieveByPk($id);
        if ($tr)
        {
            $tr->deliver();
        }
    }
    
}
