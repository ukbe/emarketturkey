<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'admin/platformAd', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getTitle().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'title': echo link_to($row->getTitle(), 'admin/platformAd', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getTitle().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'company': echo link_to($row->getCompany() ? $row->getCompany() : 'NA', 'admin/application', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getTitle().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>