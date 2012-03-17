<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class refreshAction extends EmtUserAction
{
    public function execute($request)
    {
        $type = (int)$this->getRequestParameter('type'); // true=clicked more, false=retrive new
        $from = $this->getRequestParameter('from');
        $latest = $this->getRequestParameter('latest');
        $activities = $this->sesuser->getNetworkActivity(1, $type !== 1 ? date('Y-m-d H:i:s', $latest) : null, $type === 1 ? date('Y-m-d H:i:s', $from) : null);
        $this->getContext()->getConfiguration()->loadHelpers('Partial');
        return $this->renderText(get_partial('network/network_activity', array('activities' => $activities, 'refreshing' => true)));
    }
}