<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'author/news', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'name': echo link_to($row->getName(), 'author/news', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'source': echo link_to($row->getPublicationSource(), 'author/news', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'category': echo link_to($row->getPublicationCategory()->getName(), 'author/news', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>