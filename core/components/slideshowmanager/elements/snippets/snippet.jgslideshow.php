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
$html_caption = $modx->getOption('htmlCaptionTpl', $scriptProperties, $skin.'_htmlCaptionTpl' );
//$head = $modx->getOption('headTpl', $scriptProperties, $skin.'' );

// add package
$s_path = $modx->getOption('core_path').'components/slideshowmanager/model/';
$modx->addPackage('slideshowmanager', $s_path);
$slide_dir = MODX_ASSETS_URL.'components/slideshowmanager/uploads/';

$output = '';

// get the slides for the album
$query = $modx->newQuery('jgSlideshowSlide');
$today = date("Y-m-d");
$query->where(array(
    'slideshow_album_id' => $album_id, 
    'slide_status' => 'live',
    'start_date:<=' => $today,
    'end_date:>=' => $today)
    );
$query->sortby('sequence','ASC');

//$oldTarget = $modx->setLogTarget('HTML');
// your code here
//$c->limit(5);
$slides = $modx->getCollection('jgSlideshowSlide',$query);
//$output .= $query->toSQL();

// restore the default logging (to file)
//$modx->setLogTarget($oldTarget);

$slide_output = '';
$html_cap_output = '';
$count = 0;
foreach( $slides as $slide ){
    ++$count;
    //$output .= '<br>Slide: '.$count;
    // go thourgh each image
    $slide_data = $slide->toArray();
    $url = $slide->get('url');
    $slide_data['src'] = $slide_dir.$slide_data['file_path']; 
    if ( empty($url) ) {
        $slide_output .= '
            '.$modx->getChunk($slide_pane, $slide_data);
    } else {
        $slide_output .= '
            '.$modx->getChunk($slide_pane_link, $slide_data);
    }
    // create html caption
    if ( !empty($slide_data['html']) ){
        $html_cap_output .= $modx->getChunk($html_caption, $slide_data);
    }
    
}
// get the Album data and merge with slides and caption
$slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $album_id));
$album_data = array();
if ( is_object($slideAlbum) ) {
    $album_data = $slideAlbum->toArray();
    // load the CSS file
    $album_data['slide_div_id'] = $slide_div_id;
    $album_data['slide_count'] = $count;
    $modx->regClientStartupHTMLBlock($modx->getChunk($head, $album_data));
    
    $album_data['slide_panes'] = $slide_output;
    $album_data['html_caption'] = $html_cap_output;
}
$output .= $modx->getChunk($slide_holder, $album_data);

return $output;