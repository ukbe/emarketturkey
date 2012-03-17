<?php

class JobSpec extends BaseJobSpec
{
    public function __toString()
    {
        return $this->getRelatedObjectOrValue()->__toString();
    }

    public function getRelatedObjectOrValue()
    {
        switch ($this->getTypeId())
        {
            case JobSpecPeer::JSPTYP_DRIVERS_LICENSE : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_EXPERIENCE_YEAR : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_GENDER : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_JOB_FUNCTION : 
                return JobFunctionPeer::retrieveByPK($this->getSpecId());
            case JobSpecPeer::JSPTYP_JOB_GRADE : 
                return JobGradePeer::retrieveByPK($this->getSpecId());
            case JobSpecPeer::JSPTYP_MILSERV_POSTYEAR : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_MILSERV_STATUS : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_SCHOOL_DEGREE : 
                return ResumeSchoolDegreePeer::retrieveByPK($this->getSpecId());
            case JobSpecPeer::JSPTYP_SMOKING_STATUS : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_SPECIAL_CASE : 
                return JobSpecialCasesPeer::retrieveByPK($this->getSpecId());
            case JobSpecPeer::JSPTYP_TRAVEL_PERCENT : 
                return $this->getSpecId();
            case JobSpecPeer::JSPTYP_WORKING_SCHEME : 
                return JobWorkingSchemePeer::retrieveByPK($this->getSpecId());
        }
    }
}
