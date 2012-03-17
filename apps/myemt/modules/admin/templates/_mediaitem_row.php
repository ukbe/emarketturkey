<?php
use_helper('Date'); 
$icons = sfConfig::get('app_file_extension');
$icons = $icons['icons'];

switch ($column)
{
    case 'id': echo link_to($row->getId(), 'admin/mediaItem', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getFilename().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'filename': echo link_to((array_key_exists(strtolower($row->getFileExtention()), $icons)?image_tag($icons[strtolower($row->getFileExtention())]).' ':'').$row->getFilename(), 'admin/mediaItem', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getFilename().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'owner': echo link_to($row->getOwner()?$row->getOwner():__('!MISSING!'), 'admin/mediaItem', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getFilename().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'filesize': echo link_to($row->getFileSize(), 'admin/mediaItem', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getFilename().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'uploadedat': echo link_to(format_datetime($row->getCreatedAt('U')), 'admin/mediaItem', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getFilename().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'status': echo file_exists($row->getPath())?'L':'';
                   echo file_exists($row->getMediumPath())?'M':'';
                   echo file_exists($row->getThumbnailPath())?'S':'';
                   break;
    default: break;
}
?>