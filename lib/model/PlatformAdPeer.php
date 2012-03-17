<?php

class PlatformAdPeer extends BasePlatformAdPeer
{
    CONST PAD_TYP_IMAGE                     = 1;
    CONST PAD_TYP_FLASH                     = 2;
    
    CONST PAD_STAT_ONLINE                   = 1;
    CONST PAD_STAT_SUSPENDED                = 2;
    
    public static $typeNames    = array (1 => 'Image',
                                         2 => 'Flash',
                                         );
    public static $statusNames  = array (1 => 'Online',
                                         2 => 'Suspended',
                                         );

    public static function grabAdForNs($ns)
    {
        $con = Propel::getConnection();
        
        $sql = "select * from (
                  select * from (
                    select adv.*, ort.aveg, adviews.cont
                    from emt_platform_ad adv, 
                    (
                      select avg(cnt) aveg from (
                        select count(*) cnt, to_date(TO_CHAR(ade.created_at,'YYYY/MM/DD'), 'YYYY/MM/DD') 
                        from emt_platform_ad_event ade
                        left join emt_platform_ad adv on ade.ad_id=adv.id
                        left join emt_platform_ad_namespace adn on adv.ad_namespace_id=adn.id
                        where ade.type_id=1 and adn.ad_namespace='$ns'
                        GROUP BY to_date(TO_CHAR(ade.created_at,'YYYY/MM/DD'), 'YYYY/MM/DD') 
                      )
                    ) ort, 
                    (
                      select adv.id ad_id, nvl(cont, 0) cont from emt_platform_ad adv
                      left join 
                      (
                        select adv.id, count(*) cont from emt_platform_ad adv
                        inner join emt_platform_ad_event ade on adv.id=ade.ad_id
                        left join emt_platform_ad_namespace adn on adv.ad_namespace_id=adn.id
                        where to_date(to_char(ade.created_at, 'YYYY/MM/DD'), 'YYYY/MM/DD')=to_date(sysdate, 'YYYY/MM/DD')
                        and ade.type_id=1 and adv.status=1 and adn.ad_namespace='$ns'
                        GROUP BY adv.id
                      ) evn on adv.id=evn.id
                    ) adviews, emt_platform_ad_namespace adn
                    where adv.id=adviews.ad_id and adv.ad_namespace_id=adn.id and adn.ad_namespace='$ns'
                  ) ping
                  order by ((aveg * view_percentage / 100) - cont) * dbms_random.value(0, 1) desc
                )
                where rownum=1 and valid_from <= sysdate and valid_until >= sysdate
            ";
                
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $ads = PlatformAdPeer::populateObjects($stmt);
        return count($ads) ? $ads[0] : null;
    }
}
