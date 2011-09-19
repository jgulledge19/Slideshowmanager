<?php

/**
 * Loads the home page.
 *
 * @package batcher
 * @subpackage controllers
 */
/*
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/modext/util/datetime.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'widgets/template.grid.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'widgets/resource.grid.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'widgets/home.panel.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'sections/home.js');
$output = '<div id="batcher-panel-home-div"></div>';
*/
/*
 * 
 */
// load all of the lexicon values for translation
//$modx->smarty->assign( '_lang', $tmp_data = $this->modx->lexicon->fetch() );

// load slideshowmanager lexicon settings:
$slide_lexicon = new dataToSmarty();

//print_r($tmp_sl);
//print_r($slide_lexicon); 
$my_lexicon = $slide_lexicon->smartyLexicon($modx->lexicon->fetch('slideshowmanager'));
$modx->smarty->assign('_lang', $my_lexicon );

// urls:
$url_array = array( 'album_add' => '?a='.$a.'&amp;action=addalbum');
$modx->smarty->assign('_url',$url_array);

$settings = array();
// now build the loop data for all albums
// put in index.php:// Load the DB classes:


// Query the DB for all slide show albums:
/*
    Help: http://rtfm.modx.com/display/xPDO20/xPDOQuery 
*/
//$event = $modx->newObject('chEvents');

$query = $modx->newQuery('jgSlideshowAlbum');
//$c->innerJoin('BoxOwner','Owner'); // arguments are: className, alias
/* $start_where = date("Y-m-d", (strtotime($y.'-'.$m.'-01')-6*3600*24) );
$end_where = date("Y-m-d", (strtotime($y.'-'.$m.'-31')+6*3600*24) );
$query->where(array(
    'start_date:>=' => $start_where,
    'start_date:<=' => $end_where
));*/

$query->sortby('title','ASC');
//$c->limit(5);
$albums = $modx->getCollection('jgSlideshowAlbum',$query);
//echo 'SQL:<br>'.$query->toSQL();
$album_str = NULL;
foreach ($albums as $album_id => $album ) {
    // echo ' '.$album->get('title');
    
    $album_str .= '
    <li>
        <h3><a href="?a='.$a.'&amp;album_id='.$album->get('id').'&amp;action=editalbum">'.$album->get('title').' ('.$album_id.')</a></h3>
        <p><a href="?a='.$a.'&amp;album_id='.$album->get('id').'&amp;action=slides">'.$my_lexicon['slideshowmanager']['manage'].'</a></p>
        <p>'.$album->get('description').'</p>
    </li>';
}
$album_str .= '<li class="emptyList"></li>';

/*******************************
 * 
 * 
 *******************************/
// album_loop
$settings['album_loop'] = $album_str;

// now load all db/form params
$modx->smarty->assign('_params',$settings);

return $modx->smarty->fetch( MODX_CORE_PATH.'components/slideshowmanager/templates/album.tpl' );


