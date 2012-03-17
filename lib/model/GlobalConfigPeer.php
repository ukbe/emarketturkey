<?php

class GlobalConfigPeer extends BaseGlobalConfigPeer
{

    // CONFIG INDEX
    CONST GC_AUTO_ACTIVATE_PRODUCT  = 1;
    CONST GC_NEW_PRODUCT_STATUS     = 2;
    CONST GC_NUM_PRODUCT_PHOTOS     = 3;
    CONST GC_NUM_PRODUCT_GROUPS     = 4;
    CONST GC_VERIFY_USER_EMAIL      = 5;

    public static $defaults     = array (
        self::GC_AUTO_ACTIVATE_PRODUCT     => array('Auto Activate Product', 'BOOLEAN', TRUE),
        self::GC_NEW_PRODUCT_STATUS        => array('New Product Approval Status', 'INT', 2), // 2 = ProductPeer::PR_STAT_PENDING_APPROVAL
        self::GC_NUM_PRODUCT_PHOTOS        => array('Maximum Number of Product Photos Allowed', 'INT', 1),
        self::GC_NUM_PRODUCT_GROUPS        => array('Maximum Number of Product Groups Allowed', 'INT', 10),
        self::GC_VERIFY_USER_EMAIL         => array('Email Address Verification ', 'BOOLEAN', TRUE),
    );

    public static function getConfigObj($c_index)
    {
        $cfg = self::retrieveByPK($c_index);
        
        if (!$cfg && isset(self::$defaults[$c_index]))
        {
            $cfg = new GlobalConfig();
            $cfg->setId($c_index);
            $cfg->setName(self::$defaults[$c_index][0]);
            $cfg->setType(self::$defaults[$c_index][1]);
            $cfg->setValue(self::$defaults[$c_index][2]);
            $cfg->save();
        }

        return $cfg;
    }

    public static function getConfig($c_index)
    {
        $cfg = self::getConfigObj($c_index);
        $val = $cfg->getValue();
        settype($val, $cfg->getType());
        return $val;
    }

}
