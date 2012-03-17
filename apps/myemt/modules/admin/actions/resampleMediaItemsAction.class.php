<?php

class resampleMediaItemsAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $c = new Criteria();
        if ($this->getRequestParameter('guid') != '')
            $c->add(MediaItemPeer::GUID, $this->getRequestParameter('guid'));
        if (preg_match('/^\d+$/', $this->getRequestParameter('id')))
            $c->add(MediaItemPeer::ID, $this->getRequestParameter('id'));
            
        if ($this->getRequestParameter('type_id'))
            $c->add(MediaItemPeer::ITEM_TYPE_ID, $this->getRequestParameter('type_id'));
            
        $items = MediaItemPeer::doSelect($c);
        ini_set('memory_limit', '300M');
        ini_set('max_execution_time', '1000');
        $i = 0;
        $j = 0;
        $start = preg_match('/^\d+$/', $this->getRequestParameter('st')) ? $this->getRequestParameter('st') : null;
        $end = preg_match('/^\d+$/', $this->getRequestParameter('end')) ? $this->getRequestParameter('end') : null;

        foreach ($items as $item)
        {
            $i++;
            if (!is_null($start) &&  $i<$start) continue;
            if (file_exists($item->getOriginalFilePath()))// && !file_exists($item->getUncroppedThumbPath()))
            {
                $j++;
                $item->store($item->getOriginalFilePath());
            }
  //          else if (file_exists($item->getOriginalFilePath()))
            {
    //            $j++;
      //          $item->updateThumbnail();
            }
            if (!is_null($end) && $i > $end) break;
        }
        echo 'cnt=' . count($items) . " i=$i j=$j start=$start end=$end";
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
        return !$this->getRequest()->hasErrors();
    }
}
