<span id="<?php echo $tabname ?>_toggle_<?php echo $item->getId() ?>">
<?php echo emt_remote_link(
                image_tag('layout/icon/'.($item->getActive()?'active-n':'active-grey-n').'.png', array('title' => $item->getActive()?__('De-Activate'):__('Activate'))), 
                "{$tabname}_toggle_{$item->getId()}", 
                $url, 
                array('id' => $item->getId(), 'act' => 'tog')
            ) ?></span>