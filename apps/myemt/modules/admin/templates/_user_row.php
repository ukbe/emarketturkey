<?php use_helper('Date') ?>
<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'admin/user', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'name': echo link_to($row->getName(), 'admin/user', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'lastname': echo link_to($row->getLastname(), 'admin/user', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'joinedat': echo link_to(format_datetime($row->getCreatedAt('U')), 'admin/user', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>