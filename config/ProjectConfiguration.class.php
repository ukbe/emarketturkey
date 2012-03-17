<?php

# FROZEN_SF_LIB_DIR: /var/www/production/sfweb/www/cache/symfony-for-release/1.2.8/lib

require_once dirname(__FILE__).'/../lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin'));
    
    // newline
    if (!defined('NL'))
    {
       define('NL', "\n");
    }

    sfConfig::add(array('sf_image_dir_name'  => $sf_upload_dir_name = 'uploads',
                        'sf_upload_dir_name'  => $sf_upload_dir_name = 'uploads',
                        'sf_upload_dir'       => sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.$sf_upload_dir_name,      
));
  }
}
