<?php
/**
 * Get a list
 * 
 * @package cmp
 * @subpackage processors
 * This file needs to be customized
 * 
 */
/* setup default properties */
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'sequence');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$album_id  = $modx->getOption('slideshow_album_id',$scriptProperties,'1');
$sort_type  = $modx->getOption('sort_type',$scriptProperties,'current');

$query = $modx->getOption('query',$scriptProperties,'');

/* build query */

/*if (!empty($query)) {
    $c->where(array(
        'title:LIKE' => '%'.$query.'%'
    ));
}*/
// urls
/* 
$url_array = array( 
        //'home' => '?a='.$a,
        'slide_add' => '?a='.$a.'&amp;action=addslide&amp;album_id='.$album_id,
        'slide_edit' => '?a='.$a.'&amp;action=editslide&amp;album_id='.$album_id );
*/
$query = $modx->newQuery('jgSlideshowSlide');
$conditions = array('slideshow_album_id' => $album_id );
$today = date("Y-m-d");
switch ($sort_type) {
    case 'tbd':
        $conditions['slide_status'] = 'tbd';
        $query->where($conditions);
        //$query->sortby('edit_time','DESC');
        break;
    case 'archive':
        $conditions['slide_status'] = 'archive';
        $conditions = 
        array(
            'slideshow_album_id' => $album_id ,
            //array('slide_status:IN' => array('live', 'archive', 'replace' )),
            array(
                // 
                array('AND:slide_status:IN' => array('archive' )),
                array(
                    'OR:slide_status:=' => 'live',
                    'AND:end_date:<' => $today
                )
            )
        );
        $query->where($conditions);
        $query->where($conditions, xPDOQuery::SQL_AND);
        //$query->sortby('end_date','DESC');
        break;
    case 'future':
        /* @link http://rtfm.modx.com/display/xPDO20/xPDOQuery */
        $conditions = 
        array(
            'slideshow_album_id' => $album_id ,
            array(
                array('AND:slide_status:IN' => array('future', 'replace' )),
                /*array( 'AND:slide_status:=' => 'future', 
                    'OR:slide_status:=' => 'replace' ), */
                array(
                    'OR:slide_status:=' => 'live',
                    'AND:start_date:>' => $today
                )
            )
        );
        $query->where($conditions, xPDOQuery::SQL_AND);
        //$query->sortby('start_date','ASC');
        // test http://modxcms.com/forums/index.php/topic,62807.msg356210/topicseen.html#msg356210
        //$table_name = $modx->getTableName('table');
        //$result = $modx->query("UPDATE {$table_name} SET {$modx->escape('value')} = 'n' WHERE {$modx->escape('k')} = 'n'" );
        break;
    case 'current':
    default:
        $today = date("Y-m-d");
        $conditions[] = array(
            'slide_status' => 'live',
            'start_date:<=' => $today,
            'end_date:>=' => $today
        );
        $query->where($conditions);
        //$query->sortby('sequence','ASC');
        break;
}
$count = $modx->getCount('jgSlideshowSlide',$query);
$query->sortby($sort,$dir);
if ($isLimit) {
    $query->limit($limit,$start);
}

//$c->limit(5);
$slides = $modx->getIterator('jgSlideshowSlide',$query);
// echo 'MY SQL:<br>'.$query->toSQL();

$c = $modx->newQuery('jgSlideshowAlbum');
$conditions = array('id' => $album_id );
$c->where($conditions);

$album = $modx->getObject('jgSlideshowAlbum', $c);
$album_description = $album->get('description');
$album_file_width = $album->get('file_width');
$album_file_height = $album->get('file_height');

$slide_str = NULL;
$list = array();
foreach ($slides as $slide ) {
	$array = $slide->toArray();
	
	$array['album_description'] = $album_description;
    $array['album_file_width'] = $album_file_width;
	$array['album_file_height'] = $album_file_height;
	
    $array['start_date'] = trim(str_replace('00:00:00', '', $array['start_date']));
    $array['end_date'] = trim(str_replace('00:00:00', '', $array['end_date']));
    $array['image_path'] = $slide->get('file_path');//$this->cmpController->config['uploadUrl']
    //$array['image'] = '<img src="/assets/components/slideshowmanager/uploads/'.$this->cmpController->config['uploadUrl'].$slide->get('file_path').'" alt="--Title--" height="100" >';
    $list[] = $array;
    
}
return $this->outputArray($list,$count);