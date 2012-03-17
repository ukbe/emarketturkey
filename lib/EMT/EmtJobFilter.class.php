<?php

class EmtJobFilter
{
    CONST   FTYP_KEYWORD    = 'keyword';
    CONST   FTYP_PERIOD     = 'period';
    CONST   FTYP_COUNTRY    = 'country';
    CONST   FTYP_GRADE      = 'grade';
    CONST   FTYP_EDULEVEL   = 'edulevel';
    CONST   FTYP_SCHEME     = 'scheme';
    CONST   FTYP_MSERVICE   = 'mservice';
    CONST   FTYP_GENDER     = 'gender';
    CONST   FTYP_SCASE      = 'scase';
    
    public static $typeLabels = array(
                    self::FTYP_KEYWORD  => 'Keyword',
                    self::FTYP_PERIOD   => 'Period',
                    self::FTYP_COUNTRY  => 'Locations',
                    self::FTYP_GRADE    => 'Job Position Level',
                    self::FTYP_EDULEVEL => 'Education Level',
                    self::FTYP_SCHEME   => 'Working Schedule',
                    self::FTYP_MSERVICE => 'Military Service',
                    self::FTYP_GENDER   => 'Gender',
                    self::FTYP_SCASE    => 'Special Cases',
                );
    
    public static $typeClasses = array(
                    self::FTYP_KEYWORD  => 'JFKeyword',
                    self::FTYP_PERIOD   => 'JFPeriod',
                    self::FTYP_COUNTRY  => 'JFCountry',
                    self::FTYP_GRADE    => 'JobGrade',
                    self::FTYP_EDULEVEL => 'ResumeSchoolDegree',
                    self::FTYP_SCHEME   => 'JobWorkingScheme',
                    self::FTYP_MSERVICE => 'JFMilService',
                    self::FTYP_GENDER   => 'JFGender',
                    self::FTYP_SCASE    => 'JobSpecialCases',
                );
    
    public static $typeIDs = array(
                    self::FTYP_KEYWORD  => 'job_keyword',
                    self::FTYP_PERIOD   => 'period',
                    self::FTYP_COUNTRY  => 'cnt[]',
                    self::FTYP_GRADE    => 'grd[]',
                    self::FTYP_EDULEVEL => 'edu[]',
                    self::FTYP_SCHEME   => 'sch[]',
                    self::FTYP_MSERVICE => 'mserv[]',
                    self::FTYP_GENDER   => 'gen[]',
                    self::FTYP_SCASE    => 'scs[]',
                );
    
    protected $_sections = array();
    
    public function __construct($sect_params= null)
    {
        if (isset($sect_params) && is_array($sect_params))
        {
            foreach ($sect_params as $sect => $vals)
            {
                $this->_sections[$sect] = new EmtJobFilterSection($this, $sect, $vals);
            }
        }
    }
    
    public function getSections()
    {
        return $this->_sections;
    }

    public function getSection($type)
    {
        return $this->_sections[$type];
    }
}

class EmtJobFilterSection
{
    protected $_filter, $_type = null;
    protected $_items = array();
    
    public function __construct($filter, $type, $vals = array())
    {
        $this->_filter = ($filter instanceof EmtJobFilter ? $filter : null);
        
        $this->_type = $type;
        $vals = is_array($vals) ? $vals : array($vals);
        foreach ($vals as $val)
        {
            $this->_items[] = new EmtJobFilterItem($this, $val);
        }
    }
    
    public function getType()
    {
        return $this->_type;
    }

    public function getLabel()
    {
        return EmtJobFilter::$typeLabels[$this->_type];
    }

    public function getFormId()
    {
        return EmtJobFilter::$typeIDs[$this->_type];
    }

    public function getObjectClass()
    {
        return EmtJobFilter::$typeClasses[$this->_type];
    }

    public function getItems()
    {
        return $this->_items;
    }
}

class EmtJobFilterItem
{
    protected $_section, $_val, $_label, $_object = null;
    
    public function __construct($section, $val)
    {
        $this->_section = $section;
        $this->_type = $section->getType();
        $this->_val = $val;
        $this->_object = call_user_func("{$this->getSection()->getObjectClass()}Peer::retrieveByPk", $val);
    }
    
    public function getLabel()
    {
        return $this->_object ? $this->_object : '';
    }
    
    public function getObject()
    {
        return $this->_object;
    }
    
    public function getValue()
    {
        return $this->_val;
    }
    
    public function getSection()
    {
        return $this->_section;
    }
    
}

class JFKeywordPeer
{
    public static function retrieveByPk($keyword)
    {
        return new JFKeyword($keyword);
    }
}
class JFKeyword
{
    protected $_keyword = null;

    public function __construct($keyword)
    {
        $this->_keyword = $keyword;
    }
    
    public function __toString()
    {
        return $this->_keyword;
    }
}
class JFPeriodPeer
{
    public static $periodLabels = array(
                        1   => 'Posts of Today',
                        360 => 'All Job Posts'
                   );

    public static function retrieveByPk($key)
    {
        return new JFPeriod($key);
    }
}
class JFPeriod
{
    protected $key = null;

    public function __construct($key)
    {
        $this->_key = $key;
    }
    
    public function __toString()
    {
        sfLoader::loadHelpers('I18n');
        return (isset(JFPeriodPeer::$periodLabels[$this->_key]) ? __(JFPeriodPeer::$periodLabels[$this->_key]) : __('%1 Days', array('%1' => $this->_key)));
    }
}
class JFMilServicePeer
{
    public static function retrieveByPk($key)
    {
        return new JFMilService($key);
    }
}
class JFMilService
{
    protected $key = null;

    public function __construct($key)
    {
        $this->_key = $key;
    }
    
    public function __toString()
    {
        sfLoader::loadHelpers('I18n');
        return (isset(ResumePeer::$mservLabels[$this->_key]) ? __(ResumePeer::$mservLabels[$this->_key]) : '');
    }
}
class JFGenderPeer
{
    public static function retrieveByPk($key)
    {
        return new JFGender($key);
    }
}
class JFGender
{
    protected $key = null;

    public function __construct($key)
    {
        $this->_key = $key;
    }
    
    public function __toString()
    {
        sfLoader::loadHelpers('I18n');
        return (isset(ResumePeer::$genderOptLabels[$this->_key]) ? __(ResumePeer::$genderOptLabels[$this->_key]) : '');
    }
}
class JFCountryPeer
{
    public static function retrieveByPk($key)
    {
        return CountryPeer::retrieveByISO($key);
    }
}
