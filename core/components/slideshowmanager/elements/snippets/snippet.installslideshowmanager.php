<?php
/**
 * install the db tables 
 */

// add package
$s_path = $modx->getOption('core_path').'components/slideshowmanager/model/';
$modx->addPackage('slideshowmanager', $s_path);
 
$m = $modx->getManager();
// the class table object name
$m->createObjectContainer('jgSlideshowAlbum');
$m->createObjectContainer('jgSlideshowSlide');

return 'Tables created.';