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
$group_id = $modx->getOption('group_id',$scriptProperties,'');
$group_id_old = $modx->getOption('slideshow_album_id',$scriptProperties,'');

/* build query */
$c = $modx->newQuery('MessageSermons');

if (!empty($query)) {
    $c->where(array(
        'title:LIKE' => '%'.$query.'%'
    ));
}
if (!empty($group_id)) {
    $c->where(array(
        'group_id' => $group_id
    ));
} elseif (!empty($group_id_old)) {
    $c->where(array(
        'group_id' => $group_id_old
    ));
}


$count = $modx->getCount('MessageSermons',$c);
$c->sortby($sort,$dir);
if ($isLimit) {
    $c->limit($limit,$start);
}
$sermons = $modx->getIterator('MessageSermons', $c);


/* iterate */
$list = array();
foreach ($sermons as $sermon ) {
    $sermon_array = $sermon->toArray();
    // make the date readable
    $sermon_array['sermon_date'] = date('n/j/y',strtotime($sermon_array['sermon_date']));
    $list[] = $sermon_array; 
}
return $this->outputArray($list,$count);