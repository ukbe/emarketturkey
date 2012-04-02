<?php

class geoLocateAction extends EmtAction
{
    public function execute($request)
    {
        header('Content-type: application/json');

        // Geolocation detection with JavaScript, HTML5 and PHP
        // http://locationdetection.mobi/
        // Andy Moore
        // http://andymoore.info/
        // this is linkware if you use it please link to me:
        // <a href="http://web2txt.co.uk/">Mp3 Downloads</a>

        $geo = 'http://maps.google.com/maps/api/geocode/xml?latlng='.htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))).'&sensor=true';
        $xml = simplexml_load_file($geo);

        foreach($xml->result->address_component as $component){
            if($component->type=='street_address'){
                $geodata['precise_address'] = (string)$component->long_name;
            }
            if($component->type=='natural_feature'){
                $geodata['natural_feature'] = (string)$component->long_name;
            }
            if($component->type=='airport'){
                $geodata['airport'] = (string)$component->long_name;
            }
            if($component->type=='park'){
                $geodata['park'] = (string)$component->long_name;
            }
            if($component->type=='point_of_interest'){
                $geodata['point_of_interest'] = (string)$component->long_name;
            }
            if($component->type=='premise'){
                $geodata['named_location'] = (string)$component->long_name;
            }
            if($component->type=='street_number'){
                $geodata['house_number'] = (string)$component->long_name;
            }
            if($component->type=='route'){
                $geodata['street'] = (string)$component->long_name;
            }
            if($component->type=='locality'){
                $geodata['town_city'] = (string)$component->long_name;
            }
            if($component->type=='administrative_area_level_3'){
                $geodata['district_region'] = (string)$component->long_name;
            }
            if($component->type=='neighborhood'){
                $geodata['neighborhood'] = (string)$component->long_name;
            }
            if($component->type=='colloquial_area'){
                $geodata['locally_known_as'] = (string)$component->long_name;
            }
            if($component->type=='administrative_area_level_2'){
                $geodata['county_state'] = (string)$component->long_name;
            }
            if($component->type=='postal_code'){
                $geodata['postcode'] = (string)$component->long_name;
            }
            if($component->type=='country'){
                $geodata['country'] = (string)$component->long_name;
            }
        }
        list($lat,$long) = explode(',',htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))));
        $geodata['latitude'] = $lat;
        $geodata['longitude'] = $long;
        
        $res = json_encode(array('result' => $geodata));
        return $this->renderText($this->getRequestParameter('callback') != '' ? "{$this->getRequestParameter('callback')}($res);" : $res);
    }
}