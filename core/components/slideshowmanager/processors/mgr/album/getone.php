<?php
/**
 * Get a list
 * 
 * @package cmp
 * @subpackage processors
 * This file needs to be customized
 */
/* setup default properties */
$id = $modx->getOption('id',$scriptProperties,1);

/* build query */
$c = $modx->newQuery('jgSlideshowAlbum');

$c->where(array(
    'id' => $id
));

$count = $modx->getCount('jgSlideshowAlbum',$c);
$album = $modx->getObject('jgSlideshowAlbum', $c);

$list = array();
if ( is_object($album) ) {
    $list = $album->toArray();
}

return $this->outputArray($list,$count);