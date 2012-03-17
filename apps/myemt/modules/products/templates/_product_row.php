<?php use_helper('Date') ?>
<?php 
switch ($column)
{
    case 'thumbnail': echo link_to(image_tag($row->getThumbUri(), 'width=50'), "@edit-product?hash={$row->getCompany()->getHash()}&id={$row->getId()}", array('query_string' => "do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword').'&cat='.$sf_params->get('cat'))); break;
    case 'model': echo link_to($row->getModelNo() ? $row->getModelNo() : '##', "@edit-product?hash={$row->getCompany()->getHash()}&id={$row->getId()}", array('query_string' => "do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword').'&cat='.$sf_params->get('cat'))); break;
    case 'name': echo link_to($row->getName(), "@edit-product?hash={$row->getCompany()->getHash()}&id={$row->getId()}", array('query_string' => "do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword').'&cat='.$sf_params->get('cat'))); break;
    case 'category': echo link_to($row->getProductCategory()->getName(), "@edit-product?hash={$row->getCompany()->getHash()}&id={$row->getId()}", array('query_string' => "do=".md5($row->getName().$row->getId().session_id()).'&filter_keyword='.$sf_params->get('filter_keyword').'&cat='.$sf_params->get('cat'))); break;
    default: break;
}
?>