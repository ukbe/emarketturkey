<?php

class PostVideoPeer extends BasePostVideoPeer
{
    CONST PVID_SERVICE_YOUTUBE      = 1;
    CONST PVID_SERVICE_DAILYMOTION  = 2;
    CONST PVID_SERVICE_VIMEO        = 3;

    public static $serviceNames = array(self::PVID_SERVICE_YOUTUBE      => 'Youtube',
                                        self::PVID_SERVICE_DAILYMOTION  => 'DailyMotion',
                                        self::PVID_SERVICE_VIMEO        => 'Vimeo',
                                    );

    public static $urlParsers   = array(self::PVID_SERVICE_YOUTUBE      => 'parseYoutubeUrl',
                                        self::PVID_SERVICE_DAILYMOTION  => 'parseDailyMotionUrl',
                                        self::PVID_SERVICE_VIMEO        => 'parseVimeoUrl',
                                    );

    public static $titleQuery   = array(self::PVID_SERVICE_YOUTUBE      => 'span#eow-title',
                                        self::PVID_SERVICE_DAILYMOTION  => 'h1.dmco_title .title',
                                        self::PVID_SERVICE_VIMEO        => 'div#header > .title',
                                    );

    public static $thumbUrl     = array(self::PVID_SERVICE_YOUTUBE      => 'http://i4.ytimg.com/vi/#videoid#/default.jpg',
                                        self::PVID_SERVICE_DAILYMOTION  => 'http://www.dailymotion.com/thumbnail/160x120/video/#videoid#',
                                    );

    public static function parseVideoUrl($url)
    {
        // parse url to retrieve service information
        $domain = parse_url(strtolower($url), PHP_URL_HOST);
        if (strpos($domain, 'youtube.com') !== false) $service_id = self::PVID_SERVICE_YOUTUBE;
        else if (strpos($domain, 'dailymotion.com') !== false) $service_id = self::PVID_SERVICE_DAILYMOTION;
        else if (strpos($domain, 'vimeo.com') !== false) $service_id = self::PVID_SERVICE_VIMEO;

        $video_id = call_user_func('self::' . self::$urlParsers[$service_id], $url);
        
        $html = HtmlDom::file_get_html($url);

        if ($service_id == self::PVID_SERVICE_VIMEO)
        {
            $xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
            $thumb = (string)$xml->video->thumbnail_medium;
            $title = (string)$xml->video->title;
        }
        else
        {
            $thumb = str_replace('#videoid#', $video_id, self::$thumbUrl[$service_id]);
            $title = $html->find(self::$titleQuery[$service_id], 0)->innertext;
        }

        $videodata = array('video_id' => $video_id, 
                           'service_id' => $service_id,
                           'title' => $title,
                           'thumb' => $thumb,
                           'stat' => ($video_id && $service_id && $title && $thumb) ? 'success' : 'fail'
                           );

        return $videodata;
    }

    public static function parseYoutubeUrl($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $vals);
        return isset($vals['v']) ? $vals['v'] : null;
    }

    public static function parseDailyMotionUrl($url)
    {
        preg_match('/\/([a-z]+)_/', $url, $slashed);
        return count($slashed) > 1 ? $slashed[1] : null;
    }

    public static function parseVimeoUrl($url)
    {
        preg_match('/\/([0-9]+)[\?]*/', $url, $slashed);
        return count($slashed) > 1 ? $slashed[1] : null;
    }

    public static function getRemoteThumbUrl($post_video)
    {
        if (!($post_video instanceof PostVideo)) $post_video = PrivacyNodeTypePeer::retrieveObject($post_video, PrivacyNodeTypePeer::PR_NTYP_POST_VIDEO);

        if ($post_video->getServiceId() == self::PVID_SERVICE_VIMEO)
        {
            $xml = simplexml_load_file("http://vimeo.com/api/v2/video/{$post_video->getVideoId()}.xml");
            return (string)$xml->video->thumbnail_medium;
        }
        else
        {
            return str_replace('#videoid#', $post_video->getVideoId(), self::$thumbUrl[$post_video->getServiceId()]);
        }
    }
}
