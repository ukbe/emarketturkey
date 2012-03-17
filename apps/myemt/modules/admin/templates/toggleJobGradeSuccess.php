<span id="toggleActivateLink<?php echo $jobGrade->getId() ?>">
<?php echo emt_remote_link(
                image_tag('layout/icon/'.($jobGrade->getActive()?'active-n':'active-grey-n').'.png', array('title' => $jobGrade->getActive()?__('De-Activate'):__('Activate'))), 
                'toggleActivateLink'.$jobGrade->getId(), 
                'admin/jobGrade', 
                array('id' => $jobGrade->getId(), 'act' => 'tog', 'do' => md5($jobGrade->getName().$jobGrade->getId().session_id())
           )) ?></span>
