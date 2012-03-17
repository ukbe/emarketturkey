<?php

class queryAction extends EmtManageAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('callback'))
        {
            $keyword = $this->getRequestParameter('keyword');
            $maxRows = is_numeric($this->getRequestParameter('maxRows')) ? $this->getRequestParameter('maxRows', '20') : 20;
            $maxRows = $maxRows > 50 ? 50 : $maxRows;
    
            str_replace("'", '', $keyword);
            str_replace('"', '', $keyword);
    
            $con = Propel::getConnection();
            
            if ($this->getRequestParameter('typ') == 'org')
            {
                $sql = "
                    SELECT * FROM
                    (
                        SELECT EMT_COMPANY.ID ID, EMT_COMPANY.NAME, EMT_BUSINESS_SECTOR_I18N.NAME CATEGORY, 2 TYPE FROM EMT_COMPANY
                        LEFT JOIN EMT_BUSINESS_SECTOR ON EMT_COMPANY.SECTOR_ID=EMT_BUSINESS_SECTOR.ID
                        LEFT JOIN EMT_BUSINESS_SECTOR_I18N ON EMT_BUSINESS_SECTOR.ID=EMT_BUSINESS_SECTOR_I18N.ID
                        WHERE EMT_BUSINESS_SECTOR_I18N.CULTURE='{$this->getUser()->getCulture()}'
                        
                        UNION
                        
                        SELECT EMT_GROUP.ID ID, EMT_GROUP.NAME, EMT_GROUP_TYPE_I18N.NAME CATEGORY, 3 TYPE FROM EMT_GROUP
                        LEFT JOIN EMT_GROUP_TYPE ON EMT_GROUP.TYPE_ID=EMT_GROUP_TYPE.ID
                        LEFT JOIN EMT_GROUP_TYPE_I18N ON EMT_GROUP_TYPE.ID=EMT_GROUP_TYPE_I18N.ID
                        WHERE EMT_GROUP_TYPE_I18N.CULTURE='{$this->getUser()->getCulture()}'
                    )
                    WHERE UPPER(NAME) LIKE UPPER('%$keyword%') AND ROWNUM < $maxRows
                ";
            }
            elseif ($this->getRequestParameter('typ') == 'plc')
            {
                $sql = "
                    SELECT EMT_PLACE.ID ID, EMT_PLACE_I18N.NAME NAME, EMT_PLACE_TYPE_I18N.NAME CATEGORY, EMT_PLACE.COUNTRY COUNTRY, EXT_GEONAME.NAME STATE
                    FROM EMT_PLACE
                    LEFT JOIN EMT_PLACE_I18N ON EMT_PLACE.ID=EMT_PLACE_I18N.ID
                    LEFT JOIN EMT_PLACE_TYPE_I18N ON EMT_PLACE.TYPE_ID=EMT_PLACE_TYPE_I18N.ID
                    LEFT JOIN EXT_GEONAME ON EMT_PLACE.STATE=EXT_GEONAME.GEONAME_ID
                    WHERE EMT_PLACE_TYPE_I18N.CULTURE='{$this->getUser()->getCulture()}' AND EMT_PLACE_I18N.CULTURE=EMT_PLACE.DEFAULT_LANG AND
                        UPPER(EMT_PLACE_I18N.NAME) LIKE UPPER('%$keyword%') AND ROWNUM < $maxRows
                ";
            }
            elseif ($this->getRequestParameter('typ') == 'evn')
            {
                
                $sql = "SELECT EMT_EVENT.ID, EMT_EVENT_I18N.NAME NAME, EMT_EVENT.ORGANISER_NAME ORGANISER, TO_CHAR(EMT_TIME_SCHEME.START_DATE, 'DD-MON-YYYY') STARTDATE, 
                    CASE
                    WHEN EMT_PLACE.ID IS NOT NULL THEN EMT_PLACE_I18N.NAME
                    WHEN EMT_PLACE.ID IS NULL THEN EMT_EVENT.LOCATION_NAME
                    END LOCATION
                        FROM EMT_EVENT
                        LEFT JOIN EMT_EVENT_I18N ON EMT_EVENT.ID=EMT_EVENT_I18N.ID
                        LEFT JOIN EMT_PLACE ON EMT_EVENT.PLACE_ID=EMT_PLACE.ID
                        LEFT JOIN EMT_PLACE_I18N ON EMT_PLACE.ID=EMT_PLACE_I18N.ID
                        LEFT JOIN EMT_COMPANY ON EMT_EVENT.ORGANISER_ID=EMT_COMPANY.ID
                        LEFT JOIN EMT_GROUP ON EMT_EVENT.ORGANISER_ID=EMT_GROUP.ID
                        LEFT JOIN EMT_GROUP_I18N ON EMT_GROUP.ID=EMT_GROUP_I18N.ID
                        LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID
                        WHERE  UPPER(EMT_EVENT_I18N.NAME) LIKE UPPER('%$keyword%') AND ROWNUM < $maxRows";
            }
            
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            $events = array('ITEMS' => $stmt->fetchAll(PDO::FETCH_ASSOC));
            
            return $this->renderText($this->getRequestParameter('callback') . "(" . json_encode($events) . ");");
        }
        elseif ($this->hasRequestParameter('id'))
        {
            $event = EventPeer::retrieveByPK($this->getRequestParameter('id'));
            return $event ? $this->renderPartial('events/event', array('event' => $event)) : $this->renderText("NOT FOUND");
        }
        elseif ($this->hasRequestParameter('org'))
        {
            $organiser = PrivacyNodeTypePeer::retrieveObject($this->getRequestParameter('org'), $this->getRequestParameter('typ'));
            return $organiser ? $this->renderPartial('events/organiser', array('organiser' => $organiser)) : $this->renderText("NOT FOUND");
        }
        elseif ($this->hasRequestParameter('plc'))
        {
            $place = PlacePeer::retrieveByPK($this->getRequestParameter('plc'));
            return $place ? $this->renderPartial('events/place', array('place' => $place)) : $this->renderText("NOT FOUND");
        }
        return $this->renderText('Not Applicable');
    }
    
    public function handleError()
    {
    }
    
}
