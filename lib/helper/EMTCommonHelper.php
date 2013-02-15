<?php

function _message($type, $message, $title, $is_html = false)
{
   $html = '';
   $html .= '<div class="' . $type . '-message">' . NL;
   $html .= '<div class="message-content">' . NL;
   $html .= '<div class="message-min-height"></div>' . NL;

   if ($title)
   {
      $html .= '   <h2>' . $title . '</h2>' . NL;
   }
   
   if (is_array($message) || ($message instanceof sfOutputEscaperArrayDecorator))
   {
      $list_type = (isset($message['list_type']) ? $message['list_type'] : 'p');
      
      if ($list_type == 'ul')
      {
         $html .= '   <ul>';
         foreach ($message as $_message)
         {
            $html .= '      <li>' . $_message . '</li>' . NL;
         }
         $html .= '   </ul>';
      }
      else
      {
         foreach ($message as $_message)
         {
            $html .= '   <p>' . $_message . '</p>' . NL;
         }
      }
   }
   elseif ($is_html)
   {
      $html .= $message;
   }
   else
   {   
      $html .= '   <p>' . $message . '</p>' . NL;
   }

   $html .= '</div>' . NL;
   $html .= '</div>' . NL;
   $html .= '<div class="clearer-1"></div>' . NL;
   return $html;
}

function error_message($message, $title = 'Error', $is_html = false)
{
   return _message('error', $message, $title, $is_html);
}

function success_message($message, $title = 'Success', $is_html = false)
{
   return _message('success', $message, $title, $is_html);
}

function info_message($message, $title = 'Information', $is_html = false)
{
   return _message('info', $message, $title, $is_html);
}

function form_errors()
{
    if(sfContext::getInstance()->getRequest()->hasErrors())
    {
        $content  = '<div id="error" class="tipbox"><p class="error"><img src="/images/layout/icon/exclamation-yellow.png" style="margin-right: 10px; float: left;">'.__('Please correct the errors listed below:').'</p>'.NL;
        $content .= '<ul class="error">';
        $errors = sfContext::getInstance()->getRequest()->getErrors();
        $i = 0;
        foreach ($errors as $key => $error)
        {
            $i++;
            $content .= NL. "<li><em class=\"err\">$i</em> " . __($error) . '</li>'; 
        }
        $content .= NL.'</ul>'.NL;
        $content .= '</div>'.NL;
        return $content;
    }
    return false;
}

function emt_label_for($ids, $label, $options = array(), $span = true)
{ 
    $errorclass = '';
    
    if (substr(trim($label), -1) == '*')
    {
        $label = rtrim($label,'*').'<em>*</em>';
    }
    
    if(!is_array($ids))
    {
        $ids = array($ids);
    }

    foreach ($ids as $id)
    {
        if(sfContext::getInstance()->getRequest()->hasError($id))
        {
            $class = (isset($options['class'])) ? $options['class'] : '';
            $options['class'] = trim($class . ' error');
        }        
    }
    
    $errors = array_keys(sfContext::getInstance()->getRequest()->getErrors());
    if($span)
    {
        $label = (isset($class) ? '<em class="err">' . (array_search($ids[0], $errors) + 1) . "</em>" : '') . '<span>' . $label . '</span>';
    }
    
    return label_for($ids[0], $label, $options);
}

function emt_label_for_radio($ids, $label, $options = array())
{
    return emt_label_for($ids, $label, $options, false);
}

function required_fields_hint() 
{
    $html = '<p class="hint">* Doldurulması zorunlu alan</p>';
    $html .= splitter(1);
    return $html;
}

function splitter($size = 2)
{
    return '<div class="hrsplit-'.$size.'"></div>';
}

function format_price($price)
{
    use_helper('Number');
    return format_currency($price, 'EUR');
}

function secure_url_for($internal_uri)
{
    $secureHost = sfConfig::get('app_forceSsl_secureHost');
    if (isset($secureHost))
    {
        $url = url_for($internal_uri, false);
        $url = 'https://' . $secureHost . '/' . ltrim($url, '/');
    }
    else
    {
//        $url = str_replace('http://', 'https://' , url_for($internal_uri, true));
          $url = url_for($internal_uri, true);
    }
  
    return $url;
}

function set_sidebar_items($items='', $inherit=false)
{
    if ($inherit)
    {
        $sidebar_items = sfConfig::get('app_sidebarItems_default'); 
    }
    else
    {
        $sidebar_items = array();
    }
    if (!empty($items))
    {
        $sidebar_items = array_merge($sidebar_items, explode(',', $items));
    }
    sfContext::getInstance()->getRequest()->setAttribute('sidebar_items', $sidebar_items, 'emt/sidebar/items');
}

function get_sidebar_items()
{
    $items = sfContext::getInstance()->getRequest()->getAttribute('sidebar_items', array(), 'emt/sidebar/items');
    foreach ($items as $item)
    {
        include_partial(trim($item));
        echo splitter(1);
    }
}

/**
 * @author Olivier Mansour
 */
 
/**
 * return an url for a given symfony application and an internal url
 * work with symfony 1.1
 * freely inspired from sfWebControlleur code
 *
 * @author Olivier Mansour
 * 
 * @param string $appname
 * @param string $url
 * @param boolean $absolute
 * @param string $env
 * @param boolean $debug
 * @return string
 */
function cross_app_url_for($appname, $url, $absolute = 'false', $env = null, $debug = 'false')
{
 
  if (sfConfig::get('sf_no_script_name'))
  {
  // wont work
  throw new sfException(__FUNCTION__.' : the cross app link helper will not work with sf_no_script_name to true');
  }
 
  // get the environment
  if (is_null($env))
  {
    $env = sfContext::getInstance()->getConfiguration()->getEnvironment();
  }
 
  // context creation
  if (!sfContext::hasInstance($appname))
  {
    $c = ProjectConfiguration::getApplicationConfiguration($appname, $env, $debug);
    sfContext::createInstance($c, $appname);
  }
 
  list($route_name, $parameters) = sfContext::getInstance($appname)->getController()->convertUrlStringToParameters($url);
  $request = sfContext::getInstance($appname)->getRequest();
 
  $url_root = $request->getRelativeUrlRoot();
  if ($absolute)
  {
    $url_root = 'http'.($request->isSecure() ? 's' : '').'://'.$request->getHost().$url_root;
  }
 
  //scriptname
  $scriptname = '';
  if (($env != 'prod') and ($env))
  {
    $env_suf = '_'.$env;
  } 
  else
  {
   $env_suf = '';
  }
  if (!file_exists(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$appname.$env_suf.'.php'))
  {
    //test with index ?
    if (file_exists(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'index'.$env_suf.'.php'))
      $scriptname = 'index'.$env_suf.'.php';
    else
      throw new sfException(__FUNCTION__.' : can\'t find a script name for appname : '.$appname.' and env : '.$env);     
  }
  else
  {
    $scriptname = $appname.$env_suf.'.php';
  }
 
 
  $fragment = '';
  // strip fragment
  if (false !== ($pos = strpos($url, '#')))
  {
    $fragment = substr($url, $pos + 1);
    $url = substr($url, 0, $pos);
  }
 
  // generate url
  list($route_name, $parameters) = sfContext::getInstance($appname)->getController()->convertUrlStringToParameters($url);
 
  if (sfConfig::get('sf_url_format') == 'PATH')
  {
    // use PATH format
    $divider = '/';
    $equals  = '/';
    $querydiv = '/';
  }
  else
  {
    // use GET format
    $divider = ini_get('arg_separator.output');
    $equals  = '=';
    $querydiv = '?';
  }
  $web_url = $url_root.$querydiv.$scriptname.sfContext::getInstance($appname)->getRouting()->generate($route_name, $parameters, $querydiv, $divider, $equals);
 
  if ($fragment)
  {
    $web_url .= '#'.$fragment;
  }
 
  return $web_url;
}

/**
 * Cross app url generation
 *
 * @todo Add in prefix for different apps/envs to support subdomains
 * 
 * @param string $url Url/route name
 * @param string $app The app we want a link from
 * @param string $env The 
 * 
 * @return string
 */
function cross_app_gen_url($url, $app, $env=null) {
    // this holds copies of the other contexts so we don't have to keep loading them
    static $otherContexts = array();
    
    if ($env === null) {
        $env = sfConfig::get('sf_environment');
    }
    $debug = sfConfig::get('sf_debug');
    
    // get current config+context so we can switch back after
    $currentConfig = sfContext::getInstance()->getConfiguration();
    $currentContext = sfContext::getInstance();
    $currentApp = sfConfig::get('sf_app');
    
    if (!isset($otherContexts[$app][$env])) {
        // get config/context for our other app.  This will switch the current
        // context and change the contents of sfConfig, so we will need to change back after
        $otherConfiguration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);
        $otherContexts[$app][$env] = sfContext::createInstance($otherConfiguration, $app . $env);
    } else {
        // we already initialised the other context, switch to it now
        sfContext::switchTo($app . $env);
    }
    // make the url
    $generatedUrl = $otherContexts[$app][$env]->getController()->genUrl($url);
    $generatedUrl = sfContext::createInstance(ProjectConfiguration::getApplicationConfiguration($app, $env, $debug), $app)->getRouting()->generate($url);
    
    // switch back to old config 
    // todo: check that the context name always the current app?
    sfContext::switchTo($currentApp);
    $currentConfig->activate();
    $generatedUrl = sfConfig::get('app_routeApps_' . $app) . $generatedUrl;
    return $generatedUrl;
}

function tipbox($field, $message)
{
    return '<div id="hint_'.$field.'" class="tipbox"><span><span><span>'.image_tag('/images/layout/icon/info-s.jpg', 'style=margin-right: 10px; float: left;').$message.'</span></span></span></div>';
     
}

function checkActivePage($target_url, $active_url=null, $include_class_tag=true, $selected_class = '_on')
{
    $out = $include_class_tag ? " class=\"$selected_class\"":" $selected_class";
    if (strpos($target_url, '/') !== false)
    {
        return (sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName() == $target_url) ?  $out : '';
    }
    elseif (strpos($target_url, '@') === 0)
    {
        return strpos(sfContext::getInstance()->getRouting()->getCurrentInternalUri(true), $target_url) === 0 ?  $out : '';
    }
    elseif (count($params = explode('=', $target_url)) == 2)
    {
        if ($params[0] == 'action')
        {
            return sfContext::getInstance()->getActionName() === $params[1] ?  $out : '';
        }
        elseif ($params[0] == 'module')
        {
            return sfContext::getInstance()->getModuleName() === $params[1] ?  $out : '';
        }
    }
    else
    {
        return (sfContext::getInstance()->getActionName() == $target_url) ?  $out : '';
    }
}

function generateSubMenu($items)
{
    $html = "";
    $i = 0;
    foreach ($items as $text => $link)
    {
        $i++;
        if (is_array($link))
        {
            $html .= "<li>".link_to(__($text), 'fdfd/er');
            $html .= "<ul>".generateSubMenu($link)."</ul>"."</li>";
        }
        else
        {
            $html .= (($i == count($items))?"<li class=\"last".checkActivePage($link, null, false)."\"":
                                           "<li".checkActivePage($link)).">".link_to(__($text), $link)."</li>";
        }
        
    }
    return $html;
}

function generateMenu($items)
{
    $html = "    
<div class=\"column span-39 append-1\">
    <div class=\"col-collateral\">
        <div class=\"bottom\" style=\"padding: 2px 0px;\" >
<ul class=\"coll-list alone\" style=\"padding: 0px; margin: 0px;\">";

    $html .= generateSubMenu($items);
    
    $html .="
</ul>
        </div>
        <div class=\"corner-left\">
            <div class=\"corner-right\"></div>
        </div> 
    </div>
</div>";
    return $html;
}

function injectCurrentUrl()
{
    return sfContext::getInstance()->getRequest()->getParameterHolder()->serialize();
}

function emt_remote_form($divId, $url, $params=Array(), $htmloptions = null)
{
    $usr = sfContext::getInstance()->getUser()->getUser();
    ErrorLogPeer::Log($usr->getId(), 1, "Someone called emt_remote_form.\n\nPage:".sfContext::getInstance()->getRequest()->getUri());
    
    return "INVALID";
    
    $params['credit'] = ($usr ? $usr->getLogin()->getGuid() : '');
        
    return form_remote_tag(array(
            'update' => array('success' => $divId),
            'failure' => update_element_function($divId.'error', array('content' => '<div>'.__('Error Occured!').'</div>')).visual_effect('highlight', $divId.'error'),
            'before' => update_element_function($divId.'error', array('action' => 'empty')),
            'url' => $url . (strpos($url,'?')?'&':'?') . http_build_query($params),
            'method' => 'POST',
            'script' => true,
            ), $htmloptions);
}

function emt_remote_function($update, $url, $options)
{
    $usr = sfContext::getInstance()->getUser()->getUser();
    ErrorLogPeer::Log($usr->getId(), 1, "Someone called emt_remote_function.\n\nPage:".sfContext::getInstance()->getRequest()->getUri());
    
    return "INVALID";

    $options['url'] = $url . (strpos($url,'?')?'&':'?').'credit=' . (($usr = sfContext::getInstance()->getUser()->getUser())?$usr->getLogin()->getGuid():'');
    $options['update'] = $update;
    $options['script'] = true;
    return remote_function($options);
}

function emt_remote_link($text, $divId, $url, $params=Array(), $method=null, $htmloptions = null)
{
    $usr = sfContext::getInstance()->getUser()->getUser();
    ErrorLogPeer::Log($usr->getId(), 1, "Someone called emt_remote_link.\n\nPage:".sfContext::getInstance()->getRequest()->getUri());
    
    return "INVALID";

    $params['credit'] = (($usr = sfContext::getInstance()->getUser()->getUser())?$usr->getLogin()->getGuid():'');
    return link_to_remote($text, array(
            'update' => array('success' => $divId),
            'failure' => update_element_function($divId.'error', array('content' => '<div>'.__('Error Occured!').'</div>')).visual_effect('highlight', $divId.'error'),
            'before' => update_element_function($divId.'error', array('action' => 'empty')),
            'url' => $url . (strpos($url,'?')?'&':'?') . http_build_query($params),
            'method' => $method?$method:'POST',
            'script' => true,
            ), $htmloptions);
}

function localized_current_url($sf_culture = null)
{
    if (!$sf_culture)
    {
        $sf_culture = sfContext::getInstance()->getUser()->getCulture();
    }
    
    $routing    = sfContext::getInstance()->getRouting();
    $request    = sfContext::getInstance()->getRequest();
    $controller = sfContext::getInstance()->getController();
    
    // depending on your routing configuration, you can set $route_name = $routing->getCurrentRouteName()
    $route_name = '';
    
    $parameters = $controller->convertUrlStringToParameters($routing->getCurrentInternalUri());
    $parameters[1]['sf_culture'] = $sf_culture;
    
    return $routing->generate($route_name, array_merge($request->getGetParameters(), $parameters[1]));
}

function get_ad_for_ns($ns, $include_caption = true, $params = null)
{
    //$view_id = myTools::alphaID(rand(0, time()));
    
    $ad = PlatformAdPeer::grabAdForNs($ns);

    if (!$ad) return null;
    $view_id = $ad->issueEvent(PlatformAdEventPeer::PAD_EV_TYP_VIEW);

    $caption = $view_id ? '<div style="text-align: right; border-style: solid; border-color: #EEEEEE; border-width: 0px 1px 1px 1px; padding: 0px 3px;">'.link_to(__('Advertisement'), '@ads.post-ad', 'class=ad-caption').'</div>' : '';
    
    if ($ad)
    {
        switch ($ad->getTypeId())
        {
            case PlatformAdPeer::PAD_TYP_IMAGE :
                return link_to(image_tag(url_for($ad->getInternalFileUri() . "&view_id=$view_id")), $ad->getInternalLinkUrl(), array('target' => 'blank', 'query_string' => "view_id=$view_id", 'rel' => 'nofollow')) . $caption; 
                break;
            case PlatformAdPeer::PAD_TYP_FLASH :
                return place_flash($ad->getInternalFileUri() . "&view_id=$view_id", $ad->getPlatformAdNamespace()->getDimensions()) . $caption;
                break;
        }
    }
}

function place_flash($swf, $options = null)
{
    $info = getimagesize($swf);
    list($width, $height) = $info;
    if (isset($options))
    {
        $width = $options['width'];
        $height = $options['height'];
    }
    $html = 
    "<object width=\"$width\" height=\"$height\">
        <param name=\"movie\" value=\"$swf\">
        <embed src=\"$swf\" width=\"$width\" height=\"$height\">
        </embed>
    </object>";
    
}

function sepdot($return = true)
{
    if ($return) return image_tag('layout/icon/sep.dot.png', 'style=margin:0px 5px;'); 
    else echo image_tag('layout/icon/sep.dot.png', 'style=margin:0px 5px;');
}

function pager_links($pager, $options = array())
{
    $ipp = isset($options['ipp']) ? $options['ipp'] : 20;
    $pagescount = isset($options['pages']) ? $options['pages'] : 5;
    $pname = isset($options['pname']) ? $options['pname'] : 'pg';
    $firstlast = (isset($options['firstlast']) && $options['firstlast'] == true);
    $baseurl = myTools::remove_querystring_var(isset($options['baseurl']) ? $options['baseurl'] : sfContext::getInstance()->getRequest()->getUri(), $pname);
    $baseurl .= (strpos($baseurl, '?') === false) ? '?' : '&';
    
    $html = '';
    if ($pager->haveToPaginate())
    {
        $html .= '<ul class="pagerlinks">';
        if ($pager->getPage()>1)
        {
            $html .= $firstlast ? '<li class="first">'.link_to('<span>&nbsp;<span>', "$baseurl$pname=".$pager->getFirstPage()).'</li>' : '';
            $html .= '<li class="prev">'.link_to('<span>&nbsp;</span>', "$baseurl$pname=".($pager->getPage()-1)).'</li>';
        }
        $links = $pager->getLinks($pagescount);
        
        foreach ($links as $page)
        {
            $html .= '<li>'.($page == $pager->getPage() ? "<span>$page</span>" : link_to("<span>$page</span>", "$baseurl$pname=$page")) . '</li>';
        }
        if ($pager->getNbResults()>$pager->getLastIndice())
        {
            $html .= '<li class="next">'.link_to('<span>&nbsp;</span>', "$baseurl$pname=".($pager->getPage()+1)).'</li>';
            $html .= $firstlast ? '<li class="last">'.link_to('<span>&nbsp;</span>', "$baseurl$pname=".$pager->getLastPage()).'</li>' : '';
        }
        $html .= "</ul>";
    }

    return $html;
}

function old_like_button($item)
{
    $user = sfContext::getInstance()->getUser()->getUser();
    return $user->likes($item) ? link_to(__('Dislike'), (sfContext::getInstance()->getConfiguration()->getApplication() == "myemt" ? '@.' : '@myemt.') . "profile-action?action=like&item={$item->getPlug()}&r=true", 'class=like-button')
                               : link_to(__('Like'), (sfContext::getInstance()->getConfiguration()->getApplication() == "myemt" ? '@.' : '@myemt.') . "profile-action?action=like&item={$item->getPlug()}", 'class=dislike-button');
}

function like_button($item, $ref_url = null)
{
    $user = sfContext::getInstance()->getUser()->getUser();
    $likes = $user->likes($item);
    $html = '
    <table class="like-tag"><tr><td class="label">'.__('Like:').'</td><td>'. link_to('<em>'.__('Toggle Like').'</em>&nbsp;', (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? '@' : '@myemt.').'profile-action?action=like&item='.$item->getPlug().($likes ? '&r=true' : '').($ref_url ? '&_ref='.$ref_url : ''), array('class' => 'click'.($likes ? ' pushed' : ''), 'title' => __($likes ? 'Click to dislike %1define' : 'Click to like %1define', array('%1define' => $item->getDefineText())))).'</td><td><div class="arrow"></div></td><td><div class="counts">'.LikeItPeer::countLikes($item).'</div></td></tr></table>
    ';
    return $html;
}

function likes_tag($item)
{
    return '<span class="like-tag">'.__('%1 likes', array('%1' => '<strong>'.LikeItPeer::countLikes($item).'</strong>')).'</span>';
}

function photo_box(MediaItem $photo = null, $size = MediaItemPeer::LOGO_TYP_SMALL, $item_type = null, $photo_options = null)
{
    $dims = MediaItemPeer::getDimensionsFor($photo ? $photo->getItemTypeId() : $item_type, $size);
    if ($photo)
    {
        return image_tag($photo->getUri($size), $photo_options);
    }
    else
    {
        return "<div class=\"photobox bordered\" style=\"width: {$dims['width']}px;height: {$dims['height']}px;\"></div>";
    }

}

/*
*   get_youtube_embed returns embed code for a youtube video given its id.
*/
function get_youtube_embed($youtube_video_id, $autoplay=false)
{
    $embed_code = "";
 
    if($autoplay)
        $embed_code = '<embed src="http://www.youtube.com/v/'.$youtube_video_id.'&rel=1&autoplay=1" pluginspage="http://adobe.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="480" height="395" bgcolor="#ffffff" loop="false"></embed>';
    else
        $embed_code = '<embed src="http://www.youtube.com/v/'.$youtube_video_id.'&rel=1" pluginspage="http://adobe.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="450" height="376" bgcolor="#ffffff" loop="false"></embed>';
    return $embed_code;
}

function help_link($handle, $label = 'Help!')
{
    return link_to($label, "@lobby.help-page?handle=$handle", 'class=help-link target=blank');
}

function emt_select_country_tag($name, $selected = null, $options = array())
{
  $c = sfCultureInfo::getInstance(sfContext::getInstance()->getUser()->getCulture());
  $countries = $c->getCountries();

  if ($country_option = _get_option($options, 'countries'))
  {
    $countries = array_intersect_key($countries, array_flip($country_option)); 
  }

  $c->sortArray($countries);
  
  $keys = array_values($countries);
  $countries = array_combine($keys, $countries);

  $option_tags = options_for_select($countries, $selected, $options);
  unset($options['include_blank'], $options['include_custom']);

  return select_tag($name, $option_tags, $options);
}

function emt_include_object_metas()
{
    $context = sfContext::getInstance();
    $i18n = sfConfig::get('sf_i18n') ? $context->getI18N() : null;

    foreach ($context->getResponse()->getObjectMetas() as $key => $content)
    {
        $options = unserialize($key);
        $tag = array('content' => is_null($i18n) ? $content : $i18n->__($content));
        $options = array_merge($tag, $options); 
        
        echo tag('meta', $options)."\n";
    }
}

function emt_include_link_metas()
{
    $context = sfContext::getInstance();

    foreach ($context->getResponse()->getLinkMetas() as $key => $content)
    {
        $options = unserialize($key);
        $tag = array('content' => $content);
        $options = array_merge($tag, $options); 

        echo tag('link', $options)."\n";
    }
}

function emt_include_itemtype()
{
    $itemtype = sfContext::getInstance()->getResponse()->getItemType();
    
    echo $itemtype ? ' itemscope itemtype="'.$itemtype.'"' : '';
}