<?php

/**
 * Loads the add album.
 *
 * @package slideshowmanager
 */

/*
 * 
 */
// load all of the lexicon values for translation
//$modx->smarty->assign( '_lang', $tmp_data = $this->modx->lexicon->fetch() );

// load slideshowmanager lexicon settings:
$slide_lexicon = new dataToSmarty();
$my_lexicon = $slide_lexicon->smartyLexicon($modx->lexicon->fetch('slideshowmanager'));
$modx->smarty->assign('_lang', $my_lexicon );

// slideshow_album_id
// load the album data
if ( isset($_REQUEST['album_id']) && is_numeric($_REQUEST['album_id']) ) {
    $album_id = $_REQUEST['album_id'];
} else {
    // need an error message here!
}
$slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $album_id));
$album_data = array();
if ( is_object($slideAlbum) ) {
    $album_data = $slideAlbum->toArray();
    // replace the | with a comma
    $album_data['file_allowed'] = str_replace('|',', ',$album_data['file_allowed']);
    
    $smartyData = new dataToSmarty();
    $smartyData->loadData($album_data);
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty('_album', true));
    $modx->smarty->assign(array('a' => $a ) );
}

// urls 
$url_array = array( 
        'home' => '?a='.$a,
        'slide_add' => '?a='.$a.'&amp;action=addslide&amp;album_id='.$album_id,
        'slide_edit' => '?a='.$a.'&amp;action=editslide&amp;album_id='.$album_id );
$modx->smarty->assign('_url',$url_array);
$modx->smarty->assign('a',$a);
if ( isset($_REQUEST['sort_type']) ) {
    $sort_type = $_REQUEST['sort_type'];
} else {
    $sort_type = 'current';
}
$smartyData = new dataToSmarty();
$smartyData->loadData(array('sort_type' => $sort_type));
// assign the form data to the template
$modx->smarty->assign($smartyData->buildSmarty('_frmSort', true));

$query = $modx->newQuery('jgSlideshowSlide');
//$c->innerJoin('BoxOwner','Owner'); // arguments are: className, alias
/* $start_where = date("Y-m-d", (strtotime($y.'-'.$m.'-01')-6*3600*24) );
$end_where = date("Y-m-d", (strtotime($y.'-'.$m.'-31')+6*3600*24) );
$query->where(array(
    'slideshow_album_id:=' => $start_where,
    'start_date:<=' => $end_where
));*/
$conditions = array('slideshow_album_id' => $album_id );
switch ($sort_type) {
    case 'tbd':
        $conditions['slide_status'] = 'tbd';
        $query->where($conditions);
        $query->sortby('edit_time','DESC');
        break;
    case 'archive':
        $conditions['slide_status'] = 'archive';
        $query->where($conditions);
        $query->sortby('end_date','DESC');
        break;
    case 'future':
        $today = date("Y-m-d");
        /* @link http://rtfm.modx.com/display/xPDO20/xPDOQuery */
        $conditions = 
        array(
            'slideshow_album_id' => $album_id ,
            array(
                // array('AND:slide_status:IN' => array('future', 'replace' )),
                array( 'AND:slide_status:=' => 'future', 
                    'OR:slide_status:=' => 'replace' ),
                array(
                    'OR:slide_status:=' => 'live',
                    'AND:start_date:>' => $today
                ),
                array(
                    'OR:slide_status:=' => 'live',
                    'AND:end_date:<' => $today
                )
            )
        );
        $query->where($conditions, xPDOQuery::SQL_AND);
        $query->sortby('start_date','ASC');
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
        $query->sortby('sequence','ASC');
        break;
}
/* OLD
$query->where(array('slideshow_album_id' => $album_id ), xPDOQuery::SQL_AND );
switch ($sort_type) {
    case 'tbd':
        $query->where(array(
            'slide_status' => 'tbd' )
            );
        $query->sortby('edit_time','DESC');
        break;
    case 'archive':
        $query->where(array(
            'slide_status' => 'archive' )
            );
        $query->sortby('end_date','DESC');
        break;
    case 'future':
        $today = date("Y-m-d");
        // @link http://rtfm.modx.com/display/xPDO20/xPDOQuery 
        $query->andCondition(array(
            array('AND:slide_status:IN' => array('future', 'replace' ) ),
            array(
                'OR:slide_status:=' => 'live',
                'AND:start_date:>' => $today
                ),
            array(
                'OR:slide_status:=' => 'live',
                'AND:end_date:<' => $today
                )
            ));
        $query->sortby('start_date','ASC');
        break;
    case 'current':
    default:
        $today = date("Y-m-d");
        $query->where(array(
            'slide_status' => 'live',
            'start_date:<=' => $today,
            'end_date:>=' => $today)
            );
        $query->sortby('sequence','ASC');
        break;
} */
//$c->limit(5);
$slides = $modx->getCollection('jgSlideshowSlide',$query);
// echo 'MY SQL:<br>'.$query->toSQL();

$slide_str = NULL;
foreach ($slides as $slide_id => $slide ) {
    // echo ' '.$album->get('title');
    
    $slide_str .= '
    <li>
        <h3><a href="?a='.$a.'&amp;album_id='.$album_data['id'].'&amp;slide_id='.$slide->get('id').
            '&amp;action=editslide">'.$slide->get('title').' ('.$slide_id.')</a></h3>
        <p>'.$my_lexicon['slideshowmanager']['slide_sequence'].' '.$slide->get('sequence').'<p>
        <p>'.$slide->get('description').'</p>
        <img src="'.$this->jgSlideshow->config['uploadUrl'].$slide->get('file_path').'" alt="'.$slide->get('title').'" height="100" >
    </li>';
}
//print_r($my_lexicon);
if ( empty($slide_str) ){
    $slide_str = '<h3>There are no slides for this album.';
}
$settings = array();
$settings['slide_loop'] = $slide_str;

// now load params into the template
$modx->smarty->assign('_params',$settings);
// load the template

return $modx->smarty->fetch( MODX_CORE_PATH.'components/slideshowmanager/templates/slides.tpl' ); 
 




