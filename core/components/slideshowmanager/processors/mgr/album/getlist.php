<?php
/**
 * Get a list
 * 
 * @package cmp
 * @subpackage processors
 * This file needs to be customized
 */
/* setup default properties */
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

/* build query */
$c = $modx->newQuery('jgSlideshowAlbum');

if (!empty($query)) {
    $c->where(array(
        'title:LIKE' => '%'.$query.'%'
    ));
}

$count = $modx->getCount('jgSlideshowAlbum',$c);
$c->sortby($sort,$dir);
if ($isLimit) {
    $c->limit($limit,$start);
}
$albums = $modx->getIterator('jgSlideshowAlbum', $c);


/* iterate */
$list = array();
foreach ($albums as $album) {
    $album_array = $album->toArray();
    // make the date readable
    //$feed_array['post_date'] = date('n/j/y g:ia',$feed_array['post_date']);
    $list[] = $album_array; 
}
return $this->outputArray($list,$count);