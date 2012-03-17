<?php $select_ids = array('D5KL23FB04'  => 'profile_hometown_state',
                          'OG53NK62J6'  => 'profile_home_state',
                          'PW4GMK64L5'  => 'profile_work_state',
                          'WP54MJ64L3'  => 'comp_state',
                          'PLW53G89DL'  => 'rsmc_home_state',
                          'HY3DEO63PK'  => 'rsmc_work_state',
                          'EG43J4O4T4'  => 'work_state',
                          'KE35LF402K'  => 'location_id',
                          'PR3K6N332K'  => 'group_state'
                        ) ?>
<?php if (array_key_exists($sf_params->get('ID'), $select_ids)): ?>
<?php echo select_tag($select_ids[$sf_params->get('ID')], options_for_select($cities, null, array('include_custom' => __('select state/province')))) ?>
<?php else: ?>
<?php echo __('UNAVAILABLE') ?>
<?php endif ?>