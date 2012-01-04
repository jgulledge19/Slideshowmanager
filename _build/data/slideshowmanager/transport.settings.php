<?php
/** Array of system settings for Mycomponent package
 * @package mycomponent
 * @subpackage build
 */


/* This section is ONLY for new System Settings to be added to
 * The System Settings grid. If you include existing settings,
 * they will be removed on uninstall. Existing setting can be
 * set in a script resolver (see install.script.php).
 */
$settings = array();

/* The first three are new settings * /
$settings['churchevents.allowRequests']= $modx->newObject('modSystemSetting');
$settings['churchevents.allowRequests']->fromArray(array (
    'key' => 'churchevents.allowRequests',
    'value' => '1',
    'xtype' => 'combo-boolean',
    'namespace' => 'churchevents',
    'area' => 'ChurchEvents',
), '', true, true);
*/

return $settings;