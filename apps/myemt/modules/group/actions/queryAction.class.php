<?php

class queryAction extends EmtManageAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('callback'))
        {
            $keyword = $this->getRequestParameter('keyword');
            $maxRows = is_numeric($this->getRequestParameter('maxRows')) ? $this->getRequestParameter('maxRows', '20') : 20;
            $maxRows = $maxRows > 20 ? 20 : $maxRows;
    
            $con = Propel::getConnection();
            
            if ($this->getRequestParameter('typ') == 'grp' && $keyword)
            {
                $sql = "
                    SELECT DISTINCT PEER.*, (SELECT GUID||'S.'||FILE_EXTENTION FROM EMT_MEDIA_ITEM WHERE OWNER_ID=PEER.ID AND OWNER_TYPE_ID=3 AND ITEM_TYPE_ID=7 AND IS_TEMP!=1  AND ROWNUM=1) LOGO FROM
                    (
                        SELECT EMT_GROUP.ID ID, EMT_GROUP.NAME, EMT_GROUP_TYPE_I18N.NAME CATEGORY FROM EMT_GROUP
                        LEFT JOIN EMT_GROUP_TYPE ON EMT_GROUP.TYPE_ID=EMT_GROUP_TYPE.ID
                        LEFT JOIN EMT_GROUP_TYPE_I18N ON EMT_GROUP_TYPE.ID=EMT_GROUP_TYPE_I18N.ID
                        WHERE EMT_GROUP_TYPE_I18N.CULTURE=:culture
                    ) PEER
                    WHERE UPPER(NAME) LIKE UPPER('%' || :keyword || '%') AND ROWNUM < :maxrows
                ";

                $stmt = $con->prepare($sql);
                $stmt->bindValue(':keyword', $keyword);
                $stmt->bindValue(':culture', $this->getUser()->getCulture());
                $stmt->bindValue(':maxrows', $maxRows);
                $stmt->execute();
                $groups = array('ITEMS' => $stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            else
                $groups = array('ITEMS' => array());
            
            return $this->renderText($this->getRequestParameter('callback') . "(" . json_encode($groups) . ");");
        }
        return $this->renderText('Not Applicable');
    }
    
    public function handleError()
    {
    }
    
}
