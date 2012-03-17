<?php
// auto-generated by sfRoutingConfigHandler
// date: 2012/03/08 00:05:53
return array(
'myemployers' => new sfRoute('/:sf_culture/mycareer/employers', array (
  'module' => 'mycareer',
  'action' => 'employers',
  'group' => NULL,
), array (
), array (
)),
'myemployers-banned' => new sfRoute('/:sf_culture/mycareer/employers/banned', array (
  'module' => 'mycareer',
  'action' => 'employers',
  'group' => 'banned',
), array (
), array (
)),
'myemployers-bookmarked' => new sfRoute('/:sf_culture/mycareer/employers/bookmarked', array (
  'module' => 'mycareer',
  'action' => 'employers',
  'group' => 'bookmarked',
), array (
), array (
)),
'myjobs' => new sfRoute('/:sf_culture/mycareer/jobs', array (
  'module' => 'mycareer',
  'action' => 'jobs',
  'group' => NULL,
), array (
), array (
)),
'myjobs-applied-view' => new sfRoute('/:sf_culture/mycareer/jobs/applied/:guid', array (
  'module' => 'mycareer',
  'action' => 'jobs',
  'group' => 'applied',
), array (
), array (
)),
'myjobs-applied' => new sfRoute('/:sf_culture/mycareer/jobs/applied', array (
  'module' => 'mycareer',
  'action' => 'jobs',
  'group' => 'applied',
), array (
), array (
)),
'myjobs-bookmarked' => new sfRoute('/:sf_culture/mycareer/jobs/bookmarked', array (
  'module' => 'mycareer',
  'action' => 'jobs',
  'group' => 'bookmarked',
), array (
), array (
)),
'myjobs-viewed' => new sfRoute('/:sf_culture/mycareer/jobs/viewed', array (
  'module' => 'mycareer',
  'action' => 'jobs',
  'group' => 'viewed',
), array (
), array (
)),
'mycv-action' => new sfRoute('/:sf_culture/mycareer/cv/:action', array (
  'module' => 'mycv',
), array (
  'sf_culture' => '(?:en|de|tr)',
  'action' => '(review|edit|status|basic|contact|education|work|courses|languages|skills|publications|awards|references|organisations|materials|custom|preview|export)',
), array (
)),
'jobsearch' => new sfRoute('/:sf_culture/jobs/search', array (
  'module' => 'jobs',
  'action' => 'search',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'company-jobs' => new sfRoute('/:sf_culture/company/:hash/jobs', array (
  'module' => 'jobs',
  'action' => 'company',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'group-jobs' => new sfRoute('/:sf_culture/group/:hash/jobs', array (
  'module' => 'jobs',
  'action' => 'group',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'similar-jobs' => new sfRoute('/:sf_culture/jobs/:guid/similar', array (
  'module' => 'jobs',
  'action' => 'index',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'job' => new sfRoute('/:sf_culture/jobs/:guid/view', array (
  'module' => 'jobs',
  'action' => 'view',
), array (
  'id' => '[A-F0-9]+',
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'jobs' => new sfRoute('/:sf_culture/jobs', array (
  'module' => 'jobs',
  'action' => 'list',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'mycareer' => new sfRoute('/:sf_culture/mycareer', array (
  'module' => 'mycareer',
  'action' => 'overview',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'mycareer-action' => new sfRoute('/:sf_culture/mycareer/:action', array (
  'module' => 'mycareer',
), array (
  'sf_culture' => '(?:en|de|tr)',
  'action' => '(bookmarks)',
), array (
)),
'cv-create' => new sfRoute('/:sf_culture/mycareer/cv/create', array (
  'module' => 'hr_cv',
  'action' => 'create',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'homepage' => new sfRoute('/:sf_culture', array (
  'module' => 'default',
  'action' => 'index',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'homepage1' => new sfRoute('/', array (
  'module' => 'default',
  'action' => 'index',
), array (
), array (
)),
'default_index' => new sfRoute('/:sf_culture/:module', array (
  'action' => 'index',
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
'default' => new sfRoute('/:sf_culture/:module/:action/*', array (
), array (
  'sf_culture' => '(?:en|de|tr)',
), array (
)),
);
