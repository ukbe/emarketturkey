<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'admin/service', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'servicename': echo link_to($row->getName(), 'admin/service', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'application': echo link_to($row->getApplication()->getAppCode(), 'admin/service', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'appliesto': echo link_to($row->getPrivacyNodeType()->getName(), 'admin/service', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>