<?php
/**
 * Resolves setup-options settings by setting email options.
 *
 * @package churchevents
 * @subpackage build
 */
$success= false;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $setting = $object->xpdo->getObject('modSystemSetting',array('key' => 'churchevents.allowRequests'));
        if ($setting != null) {
			if ( $options['allowRequests'] != 1 ) {
				$options['allowRequests'] = 0;
			}
            $setting->set('value',$options['allowRequests']);
            $setting->save();
        } else {
            $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[ChurchEvents] allowRequests setting could not be found, so the setting could not be changed.');
        }

        $success= true;
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $success= true;
        break;
}
return $success;
