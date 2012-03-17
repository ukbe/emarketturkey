<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'author/author', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'name': echo link_to($row, 'author/author', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>