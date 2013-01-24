<?php

class CountryPeer extends BaseCountryPeer
{
    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(myTools::NLSFunc(CountryI18nPeer::NAME, 'SORT'));
        
        if ($for_select)
        {
            $cats = self::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getIso()] = $cat->getName();
            }
            return $catys;
        }
        
        return self::doSelectWithI18n($c);
    }

    public static function retrieveByISO($iso)
    {
        $c = new Criteria();
        $c->add(CountryPeer::ISO, $iso);
        return self::doSelectOne($c);
    }

    public static function retrieveByName($name, $culture = null)
    {
        $culture = $culture ? $culture : sfContext::getInstance()->getUser()->getCulture();
        $c = new Criteria();
        $c->addJoin(CountryPeer::ID, CountryI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->add(CountryI18nPeer::CULTURE, $culture);
        $c->add(CountryI18nPeer::NAME, myTools::NLSFunc(CountryI18nPeer::NAME, 'UPPER', $culture).'='.myTools::NLSFunc("'$name'", 'UPPER', $culture), Criteria::CUSTOM);
        return self::doSelectOne($c);
    }

    public static function retrieveByStrippedName($name, $ignore_culture = false)
    {
        $c = new Criteria();
        $c->add(CountryI18nPeer::STRIPPED_NAME, $name);
        if ($ignore_culture)
        {
            $cnts = CountryI18nPeer::doSelect($c);
        }
        else
        {
            $cnts = self::doSelectWithI18n($c);
        }
        if (is_array($cnts) && count($cnts))
        {
            return $ignore_culture ? $cnts[0]->getCountry() : $cnts[0];
        }
        else
        {
            return null;
        }
    }

    public static function validateIdList($list)
    {
        $list = !is_array($list) ? array($list) : $list;
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(self::ISO);
        $c->add(self::ISO, $list, Criteria::IN);
        $valid_st = BasePeer::doSelect($c);
        return $valid_st->fetchAll(PDO::FETCH_COLUMN, 0);
    }

}