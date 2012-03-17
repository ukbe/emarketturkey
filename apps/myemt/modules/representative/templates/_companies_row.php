<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'representative/company', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'name': echo link_to($row->getName(), 'representative/company', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'sector': echo link_to($row->getBusinessSector(), 'representative/company', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'type': echo link_to($row->getBusinessType(), 'representative/company', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>