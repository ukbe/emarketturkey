<?php

class parseVideoIdAction extends EmtAction
{
    public function execute($request)
    {
        header('Content-type: application/json');
/*
        $url = $this->getRequestParameter('url');
        
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $vals);
        $youtube_id = isset($vals['v']) ? $vals['v'] : null;
        
        $html = HtmlDom::file_get_html($url);
        
        $videodata = array('video_id' => $youtube_id, 
                           'service_id' => strpos($url, 'youtube.com') !== false,
                           'title' => $html->find('title', 0)->innertext);
  */
        $videodata = PostVideoPeer::parseVideoUrl($this->getRequestParameter('url'));      
        $res = json_encode($videodata);
        return $this->renderText($this->getRequestParameter('callback') != '' ? "{$this->getRequestParameter('callback')}($res);" : $res);
    }
}