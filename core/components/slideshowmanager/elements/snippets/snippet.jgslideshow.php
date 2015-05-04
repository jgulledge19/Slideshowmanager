<?php
/**
 * Slideshow
 * 
 * A slideshow snippet for MODX Revolution
 * 
 * @package slideshowmanager
 */
// require_once $modx->getOption('formit.core_path',null,$modx->getOption('core_path').'components/formit/').'model/formit/formit.class.php';
// get the user input (inputName, the input array, default value)
$album_id = $modx->getOption('album_id', $scriptProperties, 1);
$slide_div_id = $modx->getOption('slide_div_id', $scriptProperties, 'slider');

$skin = $modx->getOption('skin', $scriptProperties, 'nivo');
$head = $modx->getOption('headTpl', $scriptProperties, $skin.'_headTpl' );
$slide_holder = $modx->getOption('slideHolderTpl', $scriptProperties, $skin.'_slideHolderTpl' );
$slide_pane = $modx->getOption('slidePaneTpl', $scriptProperties, $skin.'_slidePaneTpl' );
$slide_pane_link = $modx->getOption('slideLinkTpl', $scriptProperties, $skin.'_slideLinkTpl' );
$slide_pane_link = $modx->getOption('slidePaneLinkTpl', $scriptProperties, $slide_pane_link );

$html_caption = $modx->getOption('htmlCaptionTpl', $scriptProperties, $skin.'_htmlCaptionTpl' );

$use_head = $modx->getOption('use_headTpl', $scriptProperties, true );
$use_slide_holder = $modx->getOption('use_slideHolderTpl', $scriptProperties, true );
//$use_slide_pane = $modx->getOption('use_slidePaneTpl', $scriptProperties, true );
//$use_slide_pane_link = $modx->getOption('use_slideLinkTpl', $scriptProperties, true );
$use_html_caption = $modx->getOption('use_htmlCaptionTpl', $scriptProperties, true );


$ignore_time = (boolean) $modx->getOption('ignoreTime', $scriptProperties, false );
$ignore_endtime = (boolean) $modx->getOption('ignoreEndTime', $scriptProperties, false );
//$head = $modx->getOption('headTpl', $scriptProperties, $skin.'' );

$loadJQuery = $modx->getOption('loadJQuery', $scriptProperties, 'true');

// add package
$s_path = $modx->getOption('core_path').'components/slideshowmanager/model/';
$modx->addPackage('slideshowmanager', $s_path);
$slide_dir = MODX_ASSETS_URL.'components/slideshowmanager/uploads/';

$output = '';

// get the slides for the album
$query = $modx->newQuery('jgSlideshowSlide');
$today = date("Y-m-d");
$c = array(
    'slideshow_album_id' => $album_id, 
    'slide_status' => 'live'
    );
if ( !$ignore_time ) {
    $c['start_date:<='] = $today;
    if ( !$ignore_endtime ) {
        $c['end_date:>='] = $today;
    }
}

$query->where($c);
$query->sortby('sequence','ASC');

//$oldTarget = $modx->setLogTarget('HTML');
// your code here
//$c->limit(5);
//$slides = $modx->getCollection('jgSlideshowSlide',$query);
//$output .= $query->toSQL();

// restore the default logging (to file)
//$modx->setLogTarget($oldTarget);

$slide_output = '';
$html_cap_output = '';
$count = 0;
//foreach( $slides as $slide ){

$query->prepare();
$sql = $query->toSQL();
$sql = str_replace('`jgSlideshowSlide_', '`', $sql);// not sure why the prefix gets there: `jgSlideshowSlide_
//error_log($sql);
$stmt = $modx->query($sql);
while ( $slide_data = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    ++$count;
    //$output .= '<br>Slide: '.$count;
    // go thourgh each image
    //$slide_data = $slide->toArray();
    $url = $slide_data['url'];//->get('url');
    $slide_data['src'] = $slide_dir.$slide_data['file_path']; 
    if ( empty($url) ) {
        $slide_output .= '
            '.$modx->getChunk($slide_pane, $slide_data);
    } else {
        $slide_output .= '
            '.$modx->getChunk($slide_pane_link, $slide_data);
    }
    // create html caption
    //if ( !empty($slide_data['html']) || !empty($slide_data['description']) ){
    if ( $use_html_caption ) {
        $html_cap_output .= $modx->getChunk($html_caption, $slide_data);
    }
    //}
    
}
// get the Album data and merge with slides and caption
$slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $album_id));
$album_data = array();
if ( is_object($slideAlbum) ) {
    $album_data = $slideAlbum->toArray();
    // load the CSS file
    $album_data['slide_div_id'] = $slide_div_id;
    $album_data['slide_count'] = $count;
    $album_data['loadJQuery'] = $loadJQuery;
    if ( $use_head ) {
        $modx->regClientStartupHTMLBlock($modx->getChunk($head, $album_data));
    }
    
    $album_data['slide_panes'] = $slide_output;
    $album_data['html_caption'] = $html_cap_output;
}
if ( $use_slide_holder ){
    $output .= $modx->getChunk($slide_holder, $album_data);
} else {
    $output = $slide_output;
}
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, '' );
if ( !empty($toPlaceholder) ) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}
return $output;