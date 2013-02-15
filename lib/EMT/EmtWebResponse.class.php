<?php

/**
 * EmtWebResponse class.
 *
 * This class is an overrider of sfWebResponse created to allow EMT specific functionalities to sfWebResponse class 
 *
 * @package    EMT
 * @author     Ukbe Akdogan
 */

class EmtWebResponse extends sfWebResponse
{

  protected
    $object_metas       = array(),
    $link_metas         = array(),
    $item_type          = null;


  /**
   * Initializes this EmtWebResponse.
   *
   * Available options:
   *
   *  * charset:           The charset to use (utf-8 by default)
   *  * content_type:      The content type (text/html by default)
   *  * send_http_headers: Whether to send HTTP headers or not (true by default)
   *  * http_protocol:     The HTTP protocol to use for the response (HTTP/1.0 by default)
   *
   * @param  sfEventDispatcher $dispatcher  An sfEventDispatcher instance
   * @param  array             $options     An array of options
   *
   * @return bool true, if initialization completes successfully, otherwise false
   *
   * @throws <b>sfInitializationException</b> If an error occurs while initializing this sfResponse
   *
   * @see sfWebResponse
   */
  public function initialize(sfEventDispatcher $dispatcher, $options = array())
  {
    parent::initialize($dispatcher, $options);

  }

  /**
   * Sets microdata itemtype url
   * 
   * This function adds an empty itemscope attribute and a itemtype attribute which is set to $schemaUrl to html tag.
   *
   * @param string  $schemaUrl      Url for itemtype schema
   */
  public function setItemType($schemaUrl)
  {
    $this->item_type = $schemaUrl;
  }

  public function getItemType()
  {
    return $this->item_type;
  }

  /**
   * Retrieves all meta headers.
   *
   * @return array List of meta headers
   */
  public function getObjectMetas()
  {
    return $this->object_metas;
  }

  /**
   * Adds a meta header.
   *
   * @param string  $key      Name of the header
   * @param string  $value    Meta header value (if null, remove the meta)
   * @param bool    $replace  true if it's replaceable
   * @param bool    $escape   true for escaping the header
   */
  public function addMeta($key, $value, $replace = true, $escape = true)
  {
    $key = strtolower($key);

    foreach ($this->object_metas as $option => $content)
    {
        $options = unserialize($option);
        if (in_array($key, $options))
        {
            unset($this->metas[$key]);
            return;
        }
    }

    if (is_null($value))
    {
      unset($this->metas[$key]);

      return;
    }

    // FIXME: If you use the i18n layer and escape the data here, it won't work
    // see include_metas() in AssetHelper
    if ($escape)
    {
      $value = htmlspecialchars($value, ENT_QUOTES, $this->options['charset']);
    }

    $current = isset($this->metas[$key]) ? $this->metas[$key] : null;
    if ($replace || !$current)
    {
      $this->metas[$key] = $value;
    }
  }

  /**
   * Adds an object meta header.
   *
   * @param string  $options  Header attribute list
   * @param string  $content  Meta header value (if null, remove the meta)
   */
  public function addObjectMeta($options, $content)
  {
    $key = serialize($options);

    if (is_null($content))
    {
      unset($this->object_metas[$key]);

      return;
    }
    
    if (isset($options['name']))
    {
        unset($this->metas[$options['name']]);
    }

    $this->object_metas[$key] = $content;
  }

  /**
   * Retrieves all LINK meta headers.
   *
   * @return array List of LINK meta headers
   */
  public function getLinkMetas()
  {
    return $this->link_metas;
  }

  /**
   * Adds an object LINK meta header.
   *
   * @param string  $options  Header attribute list
   * @param string  $content  Meta header value (if null, remove the meta)
   */
  public function addLinkMeta($options, $content)
  {
    $key = serialize($options);

    if (is_null($content))
    {
      unset($this->link_metas[$key]);

      return;
    }
    
    $this->link_metas[$key] = $content;
  }

  /**
   * Copies all properties from a given EmtWebResponse object to the current one.
   *
   * @param EmtWebResponse $response  An EmtWebResponse instance
   */
  public function copyProperties(sfWebResponse $response)
  {
    parent::copyProperties($response);

    $this->object_metas = $response->getObjectMetas();
  }

  /**
   * @see sfWebResponse
   */
  public function serialize()
  {
    return serialize(array($this->content, $this->statusCode, $this->statusText, $this->options, $this->cookies, $this->headerOnly, $this->headers, $this->metas, $this->httpMetas, $this->stylesheets, $this->javascripts, $this->slots,  $this->object_metas));
  }

  /**
   * @see sfWebResponse
   */
  public function unserialize($serialized)
  {
    list($this->content, $this->statusCode, $this->statusText, $this->options, $this->cookies, $this->headerOnly, $this->headers, $this->metas, $this->httpMetas, $this->stylesheets, $this->javascripts, $this->slots, $this->object_metas) = unserialize($serialized);
  }

}
