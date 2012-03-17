<?php use_helper('Date') ?>
<?php 
switch ($column)
{
    case 'id': echo link_to($row->getId(), 'admin/emailTransaction', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getData().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'email': echo link_to($row->getEmail(), 'admin/emailTransaction', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getData().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'namespace': echo link_to($row->getEmailTransactionNamespace()->getName(), 'admin/emailTransaction', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getData().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'recipient': echo ($row->getUser()||$row->getCompany())?$row->getUser()?link_to($row->getUser(), 'admin/user', array('query_string' => 'id='.$row->getUser()->getId())):link_to($row->getCompany(), 'admin/company', array('query_string' => 'id='.$row->getCompany()->getId())):'NA'; break;
    case 'updatedat': echo link_to($row->getUpdatedAt('d/m/Y H:i:s'), 'admin/emailTransaction', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getData().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    case 'status': echo link_to(EmailTransactionPeer::$statusNames[$row->getStatus()], 'admin/emailTransaction', array('query_string' => 'id='.$row->getId()."&do=".md5($row->getData().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword'))); break;
    default: break;
}
?>