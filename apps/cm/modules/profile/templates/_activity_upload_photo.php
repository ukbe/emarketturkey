<?php echo link_to(image_tag($item->getThumbnailUri()), $item->getOwner()->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$item->getId())) ?>