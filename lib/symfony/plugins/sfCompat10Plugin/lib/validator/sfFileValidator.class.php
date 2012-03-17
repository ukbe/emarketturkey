<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfFileValidator allows you to apply constraints to file upload.
 *
 * <b>Optional parameters:</b>
 *
 * # <b>max_size</b>         - [none]               - Maximum file size length.
 * # <b>max_size_error</b>   - [File is too large]  - An error message to use when
 *                                                file is too large.
 * # <b>mime_types</b>       - [none]               - An array of mime types the file
 *                                                is allowed to match.
 * # <b>mime_types_error</b> - [Invalid mime type]  - An error message to use when
 *                                                file mime type does not match a value
 *                                                listed in the mime types array.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfFileValidator.class.php 7902 2008-03-15 13:17:33Z fabien $
 */
class sfFileValidator extends sfValidator
{
  /**
   * Executes this validator.
   *
   * @param mixed A file or parameter value/array
   * @param error An error message reference
   *
   * @return bool true, if this validator executes successfully, otherwise false
   */
  public function execute(&$value, &$error)
  {
    $request = $this->context->getRequest();

    // file too large?
    $max_size = $this->getParameter('max_size');
    if ($max_size !== null && $max_size < $value['size'])
    {
      $error = $this->getParameter('max_size_error');

      return false;
    }

    if ($finfo = finfo_open(FILEINFO_MIME_TYPE))
    {
        $value['type'] = finfo_file($finfo, $value['tmp_name']);
        finfo_close($finfo);
    }
    // supported mime types formats
    $mime_types = $this->getParameter('mime_types');

    if ($mime_types !== null && !in_array($value['type'], $mime_types))
    {
      $error = $this->getParameter('mime_types_error');

      return false;
    }

    return true;
  }

  /**
   * Initializes this validator.
   *
   * @param sfContext The current application context
   * @param array   An associative array of initialization parameters
   *
   * @return bool true, if initialization completes successfully, otherwise false
   */
  public function initialize($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context);

    // set defaults
    $this->getParameterHolder()->set('max_size',         null);
    $this->getParameterHolder()->set('max_size_error',   'File is too large');
    $this->getParameterHolder()->set('mime_types',        null);
    $this->getParameterHolder()->set('mime_types_error', 'Invalid mime type');

    $this->getParameterHolder()->add($parameters);

    // pre-defined categories
    $categories = array(
      '@web_images' => array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
        'image/gif',
      ),
      '@ms-docs' => array(
        'application/excel',
        'application/msword',
        'application/vnd.ms-excel',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-works',
        'application/vnd.openxmlformats-opendocument.wordprocessingml.document',
        'application/vnd.openxmlformats-opendocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-opendocument.presentationml.presentation',
        'application/x-msword',
        'application/x-msexcel',
        'application/vnd.ms-office',
        ),
      '@open-docs' => array(
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.presentation',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.oasis.opendocument.chart',
        ),
      '@other-docs' => array(
        'application/pdf',
        'application/x-pdf',
        'application/rtf',
        'application/vnd.visio',
        'application/vnd.wordperfect',
        ),
      '@archives' => array(
        'application/x-gzip',
        'application/x-bzip2',
        'application/x-rar-compressed',
        'application/x-zip',
        'application/x-zip-compressed',
        'application/zip',
        ),
    );

    $types = array();
    
    $mime_types = is_array($this->getParameter('mime_types')) ? $this->getParameter('mime_types') : array($this->getParameter('mime_types'));
    

    foreach ($mime_types as $type)
    {
        if (strpos($type, '@') !== false)
        {
            if (isset($categories[$type]))
            {
                $types = array_merge($types, $categories[$type]);
            }
        }
        else
        {
            array_push($types, $type);
        }
    }

    $this->setParameter('mime_types', $types);

    return true;
  }
}
