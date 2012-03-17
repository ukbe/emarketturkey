<span id="toggleActivateLink<?php echo $jobPosition->getId() ?>">
<?php echo emt_remote_link(
                image_tag('layout/icon/'.($jobPosition->getActive()?'active-n':'active-grey-n').'.png', array('title' => $jobPosition->getActive()?__('De-Activate'):__('Activate'))), 
                'toggleActivateLink'.$jobPosition->getId(), 
                'admin/jobPosition', 
                array('id' => $jobPosition->getId(), 'act' => 'tog', 'do' => md5($jobPosition->getName().$jobPosition->getId().session_id())
           )) ?></span>
