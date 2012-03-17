<?php

class JobPeer extends BaseJobPeer
{
    CONST JSTYP_OFFLINE             = 1;
    CONST JSTYP_ONLINE              = 2;
    CONST JSTYP_SUSPENDED           = 3;
    CONST JSTYP_OBSOLETE            = 4;
    
    public static $typeNames    = array (1 => 'Offline',
                                         2 => 'Online',
                                         3 => 'Suspended',
                                         4 => 'Obsolete'
                                         );

    public static function getFeaturedJobs($maxnum = 12, $space = 15) // 15 = Spot Listing
    {
        $con = Propel::getConnection();
        
        $sql = "
            SELECT * FROM EMT_JOB_VIEW
            LEFT JOIN EMT_JOB_SPEC ON EMT_JOB_VIEW.ID=EMT_JOB_SPEC.JOB_ID
            WHERE EMT_JOB_VIEW.STATUS=".JobPeer::JSTYP_ONLINE." AND EMT_JOB_SPEC.TYPE_ID=$space 
            AND EMT_JOB_SPEC.SPEC_ID=1
        ";

        if ($maxnum)
        {
            $sql = "SELECT * FROM ($sql) WHERE ROWNUM <= $maxnum";
        }
        
        $stmt = $con->prepare($sql);
        
        $stmt->execute();
        $js = JobPeer::populateObjects($stmt);
        return $maxnum == 1 && count($js) ? $js[0] : $js;
    }
    
    public static function retrieveByGuid($guid)
    {
        $c = new Criteria();
        $c->add(JobPeer::GUID, $guid);
        return JobPeer::doSelectOne($c);
    }

    public static function getJobFromUrl(sfParameterHolder $ph)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt')
        {
            return self::retrieveByGuid($ph->get('guid'));
        }
        
        $con = Propel::getConnection();
        
        $sql = "SELECT * FROM EMT_JOB_VIEW WHERE GUID='{$ph->get('guid')}' AND STATUS=".JobPeer::JSTYP_ONLINE;
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $res = JobPeer::populateObjects($stmt);
        
        return count($res) ? $res[0] : null;
    }

}
