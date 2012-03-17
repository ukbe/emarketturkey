<?php

class boxtestAction extends EmtAction
{
    public function execute($request)
    {
        var_dump($_SERVER);
        return $this->renderText('{"totalResultsCount":74,"geonames":[{"alternateNames":[{"name":"إزمير","lang":"ar"},{"name":"İzmir","lang":"az"},{"name":"Измир","lang":"bg"},{"name":"İzmir","lang":"cs"},{"name":"Измир","lang":"cv"},{"name":"İzmir","lang":"de"},{"name":"Σμύρνη","lang":"el"},{"name":"İzmir","lang":"en"},{"name":"Izmiro","lang":"eo"},{"name":"Esmirna","lang":"es"},{"name":"Izmir","lang":"fi"},{"name":"İzmir","lang":"fr"},{"name":"איזמיר","lang":"he"},{"name":"Izmir","lang":"hr"},{"name":"İzmir","lang":"hu"},{"name":"IZM","lang":"iata"},{"name":"Izmir","lang":"id"},{"name":"Smirne","lang":"it"},{"name":"イズミル","lang":"ja"},{"name":"იზმირი","lang":"ka"},{"name":"http://en.wikipedia.org/wiki/%C4%B0zmir","lang":"link"},{"name":"Izmiras","lang":"lt"},{"name":"Izmira","lang":"lv"},{"name":"Izmir","lang":"nl"},{"name":"Izmir","lang":"pl"},{"name":"Esmirna","lang":"pt"},{"name":"Измир","lang":"ru"},{"name":"Измир","lang":"sr"},{"name":"Izmir","lang":"sv"},{"name":"İzmir","lang":"tk"},{"name":"İzmir","lang":"tr"},{"name":"Izmir","lang":"uz"},{"name":"伊兹密尔","lang":"zh"}],"countryName":"Turkey","adminCode1":"35","fclName":"city, village,...","score":30.4437255859375,"countryCode":"TR","lng":27.138376,"adminName2":"","adminName3":"","fcodeName":"seat of a first-order administrative division","adminName4":"","timezone":{"dstOffset":3,"gmtOffset":2,"timeZoneId":"Europe/Istanbul"},"toponymName":"İzmir","fcl":"P","continentCode":"AS","name":"İzmir","fcode":"PPLA","geonameId":311046,"lat":38.412726,"adminName1":"İzmir","population":2500603},{"alternateNames":[{"name":"Izmya","lang":"en"},{"name":"Izmja","lang":"no"},{"name":"Измя","lang":"ru"}],"countryName":"Russia","adminCode1":"73","fclName":"city, village,...","score":23.270360946655273,"countryCode":"RU","lng":50.39397,"adminName2":"","adminName3":"","fcodeName":"populated place","adminName4":"","timezone":{"dstOffset":4,"gmtOffset":3,"timeZoneId":"Europe/Moscow"},"toponymName":"Izmya","fcl":"P","continentCode":"EU","name":"Izmya","fcode":"PPL","geonameId":554810,"lat":56.105191,"adminName1":"Tatarstan","population":0},{"alternateNames":[{"name":"İzmit","lang":"en"},{"name":"Kocaeli","lang":"fr"},{"name":"Izmit","lang":"hu"},{"name":"Nicomedia","lang":"it"},{"name":"イズミット","lang":"ja"},{"name":"http://en.wikipedia.org/wiki/%C4%B0zmit","lang":"link"},{"name":"Izmit","lang":"nl"},{"name":"Izmit","lang":"pl"},{"name":"Коджаэли","lang":"ru"},{"name":"İzmit","lang":"tr"},{"name":"伊兹密特","lang":"zh"}],"countryName":"Turkey","adminCode1":"41","fclName":"city, village,...","score":23.153547286987305,"countryCode":"TR","lng":29.9169444,"adminName2":"","adminName3":"","fcodeName":"seat of a first-order administrative division","adminName4":"","timezone":{"dstOffset":3,"gmtOffset":2,"timeZoneId":"Europe/Istanbul"},"toponymName":"İzmit","fcl":"P","continentCode":"AS","name":"İzmit","fcode":"PPLA","geonameId":745028,"lat":40.7669444,"adminName1":"Kocaeli","population":196571},{"countryName":"Pakistan","adminCode1":"05","fclName":"city, village,...","score":20.26677703857422,"countryCode":"PK","lng":68.78757,"adminName2":"","adminName3":"","fcodeName":"populated place","adminName4":"","timezone":{"dstOffset":5,"gmtOffset":5,"timeZoneId":"Asia/Karachi"},"toponymName":"Izmāt","fcl":"P","continentCode":"AS","name":"Izmāt","fcode":"PPL","geonameId":1402748,"lat":27.790413,"adminName1":"Sindh","population":0},{"countryName":"Afghanistan","adminCode1":"28","fclName":"city, village,...","score":19.94602394104004,"countryCode":"AF","lng":67.551067,"adminName2":"","adminName3":"","fcodeName":"populated place","adminName4":"","timezone":{"dstOffset":4.5,"gmtOffset":4.5,"timeZoneId":"Asia/Kabul"},"toponymName":"Izmat","fcl":"P","continentCode":"AS","name":"Izmat","fcode":"PPL","geonameId":1147887,"lat":32.604299,"adminName1":"Zabul","population":0}]}');
        
        if ($this->getRequest()->isXmlHttpRequest())
        {
            header('Content-type: text/html');
            sfLoader::loadHelpers('Url');
            if ($this->hasRequestParameter('settings'))
            {
                return $this->renderPartial('tempSettings');
            }
            else if ($this->hasRequestParameter('advanced'))
            {
                return $this->renderPartial('tempAdvanced');
            }
            else if ($this->hasRequestParameter('notify'))
            {
                return $this->renderText(
                    json_encode(array('NEW' => 3, 'ITEMS' => array(
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Ukbe', 'LASTNAME' => 'Akdoğan', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Hakan', 'LASTNAME' => 'Gürsoy', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Kazım', 'LASTNAME' => 'Tatlı', 'MESSAGE' => 'seni Yok Artık grubuna davet etti', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Mahmut', 'LASTNAME' => 'Özen', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => false),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Özlem', 'LASTNAME' => 'Kurnaz', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => false),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Jale', 'LASTNAME' => 'Özenç', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => false),
                    ))
                ));
            }
            else
            {
                return $this->renderText(
                    json_encode(array('NEW' => 5, 'ITEMS' => array(
                        array('NAME' => 'Can', 'LASTNAME' => 'Akdoğan', 'MESSAGE' => 'Slm dostum, naber?', 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('NAME' => 'Ukbe', 'LASTNAME' => 'Akdoğan', 'MESSAGE' => 'Slm dostum, naber?', 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('NAME' => 'Kaan', 'LASTNAME' => 'Kural', 'MESSAGE' => 'Yarınki toplantı iptal oldu', 'OCCURENCE' => '15 May 14:33', 'NEW' => true),
                        array('NAME' => 'İbrahim', 'LASTNAME' => 'Tokat', 'MESSAGE' => 'Abi noldu bizim iş', 'OCCURENCE' => '15 May 15:35', 'NEW' => false),
                        array('NAME' => 'Zeynel', 'LASTNAME' => 'Abidin', 'MESSAGE' => 'Gönder abi bizim elemanı', 'OCCURENCE' => '15 May 23:55', 'NEW' => false),
                        array('NAME' => 'Kaan', 'LASTNAME' => 'Abidin', 'MESSAGE' => 'Gönder abi bizim elemanı', 'OCCURENCE' => '15 May 23:55', 'NEW' => false),
                        array('NAME' => 'Kazım', 'LASTNAME' => 'Abidin', 'MESSAGE' => 'Gönder abi bizim elemanı', 'OCCURENCE' => '15 May 23:55', 'NEW' => false),
                    ))
                ));
            }
        }
    }
    
    public function handleError()
    {
    }
    
}
