<span id="toggleActivateLink<?php echo $sector->getId() ?>">
<?php echo emt_remote_link(
                image_tag('layout/icon/'.($sector->getActive()?'active-n':'active-grey-n').'.png', array('title' => $sector->getActive()?__('De-Activate'):__('Activate'))), 
                'toggleActivateLink'.$sector->getId(), 
                'admin/businessSector', 
                array('id' => $sector->getId(), 'act' => 'tog', 'do' => md5($sector->getName().$sector->getId().session_id())
           )) ?></span>
