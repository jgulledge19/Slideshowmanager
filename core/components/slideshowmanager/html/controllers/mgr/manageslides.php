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
$slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $_GET['album_id']));
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
$url_array = array( 'home' => '?a='.$a);
$modx->smarty->assign('_url',$url_array);
$modx->smarty->assign('a',$a);

// ?
$column_fields = array('slideshow_album_id' => '', 
        'web_user_id' => 1,
        'start_date' => '',
        'end_date' => '',
        'edit_time' => '',
        'sequence' => '',
        'slide_status' => 'live',//'live','archive','deleted','restore_point','TBD'" phptype="string" null="true" default="TBD" />
        'version' => 1,
        'options' => '',// text
        'url' => '',// dbtype="varchar" precision="255" phptype="string" null="false" default="" />
        'title' => '',//dbtype="varchar" precision="100" phptype="string" null="false" default="" index="index" />
        'description' => '',//dbtype="text" phptype="string" null="false" default="" />
        'notes' => '', //dbtype="text" phptype="string" null="false" default="" />
        'html' => '', //dbtype="text" phptype="string" null="false" default="" />
        'upload_time' => '',// dbtype="datetime" phptype="datetime" null="false" />
        'file_path' => '',//dbtype="varchar" precision="255" phptype="string" null="false" default="" />
        'file_size' => '',// dbtype="int" precision="11" attributes="unsigned" phptype="integer" null="false" default="" />
        'file_type' => ''// dbtype="varchar" precision="32" phptype="string" null="false" default="" />
        );
// redirect log output to echo'd HTML
$oldTarget = $modx->setLogTarget('HTML');
// your code here

$newSlide = $modx->newObject('jgSlideshowSlide', $column_fields );
$newSlide->save();


// restore the default logging (to file)
$modx->setLogTarget($oldTarget);

$query = $modx->newQuery('jgSlideshowSlide');
//$c->innerJoin('BoxOwner','Owner'); // arguments are: className, alias
/* $start_where = date("Y-m-d", (strtotime($y.'-'.$m.'-01')-6*3600*24) );
$end_where = date("Y-m-d", (strtotime($y.'-'.$m.'-31')+6*3600*24) );
$query->where(array(
    'slideshow_album_id:=' => $start_where,
    'start_date:<=' => $end_where
));*/

$query->sortby('sequence','ASC');
//$c->limit(5);
$slides = $modx->getCollection('jgSlideshowSlide',$query);
echo 'SQL:<br>'.$query->toSQL();
$album_str = NULL;
foreach ($slides as $slide_id => $slide ) {
    // echo ' '.$album->get('title');
    
    $slide_str .= '
    <li>
        <h3><a href="?a='.$a.'&amp;album_id='.$album_data['id'].'&amp;slide_id'.$slide->get('id').
            '&amp;action=editslide">'.$slide->get('title').' ('.$slide_id.')</a></h3>
        <p>'.$slide->get('description').'</p>
        <img src="'.$this->jgSlideshow->config['uploadUrl'].$slide->get('file_path').'" alt="'.$slide->get('title').'" height="100" >
    </li>';
}
$settings = array();
$settings['slide_loop'] = $slide_str;

// now load params into the template
$modx->smarty->assign('_params',$settings);
// load the template

return $modx->smarty->fetch( MODX_CORE_PATH.'components/slideshowmanager/templates/manageslides.tpl' ); 
 




