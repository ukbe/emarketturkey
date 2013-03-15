<?php

class ProductPeer extends BaseProductPeer
{
    CONST PR_STAT_APPROVED          = 1;
    CONST PR_STAT_PENDING_APPROVAL  = 2;
    CONST PR_STAT_EDITING_REQUIRED  = 3;
    CONST PR_STAT_DELETED_BY_OWNER  = 4;
    
    public static $typeNames     = array (
        self::PR_STAT_APPROVED          => 'Approved',
        self::PR_STAT_PENDING_APPROVAL  => 'Approval Pending',
        self::PR_STAT_EDITING_REQUIRED  => 'Editing Required',
        self::PR_STAT_DELETED_BY_OWNER  => 'Deleted by Owner',
    );
    
    public static function getProductsOfCategory($catid, $include_childs=false)
    {
        $c = new Criteria();
        if ($include_childs)
        {
            $c->addJoin(ProductPeer::COMPANY_ID, CompanyPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ProductPeer::CATEGORY_ID, ProductCategoryPeer::ID, Criteria::LEFT_JOIN);
            $c->add(ProductCategoryPeer::ID, ProductPeer::ID." IS NOT NULL
                        START WITH ".ProductCategoryPeer::ID."=".$catid."
                        CONNECT BY PRIOR ".ProductCategoryPeer::ID."=".ProductCategoryPeer::PARENT_ID,
                Criteria::CUSTOM);
            $c->add(CompanyPeer::AVAILABLE, 1);
            $c->add(ProductPeer::ACTIVE, 1);
            $c->add(ProductPeer::IS_DELETED, null, Criteria::ISNULL);
        }
        else
        {
            $c->add(ProductPeer::CATEGORY_ID, $catid);
        }
        $c->setDistinct();
        return ProductPeer::doSelect($c);
    }
    
    public static function getFeaturedProducts($maxnum = 20, $rand = false)
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT * FROM
                (
                    SELECT EMT_PRODUCT.*, rank() over (partition by company_id order by EMT_PRODUCT.CREATED_AT desc) rank
                    FROM EMT_PRODUCT
                    LEFT JOIN EMT_COMPANY ON EMT_PRODUCT.COMPANY_ID=EMT_COMPANY.ID
                    WHERE EMT_PRODUCT.ACTIVE=1 AND EMT_PRODUCT.DELETED_AT IS NULL AND EMT_COMPANY.AVAILABLE=1 AND EMT_COMPANY.IS_FEATURED=1
                          AND EXISTS (
                                        SELECT 1 FROM EMT_MEDIA_ITEM MI 
                                        WHERE MI.OWNER_ID=EMT_PRODUCT.ID 
                                            AND MI.OWNER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_PRODUCT." 
                                            AND MI.ITEM_TYPE_ID=".MediaItemPeer::MI_TYP_PRODUCT_PICTURE."
                                    ) 
                    ORDER BY ".($rand ? "DBMS_RANDOM.VALUE" : "EMT_PRODUCT.CREATED_AT DESC")."
                )
                WHERE rank <= 3 and rownum <=$maxnum";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return ProductPeer::populateObjects($stmt);
    }

    public static function getProductFromUrl(sfParameterHolder $ph, $company = null, $force_active = false)
    {
        if (!preg_match("/^\d+$/", $ph->get('id'))) return null;

        if (is_null($company)) $company = CompanyPeer::getCompanyFromUrl($ph);
        
        if (!$company) return null;

        $product = $company->getProduct($ph->get('id'));
        
        return !$force_active || ($force_active && $product && $product->getActive() && $product->getApprovalStatus() == ProductPeer::PR_STAT_APPROVED) ? $product : null;
    }
}
