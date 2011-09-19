<?php

/**
 * Loads the add album.
 *
 * @package slideshowmanager
 */
if ( !isset($edit_me) ) {
    $edit_me = false;
}
// load slideshowmanager lexicon settings:
require_once $this->cmpController->config['modelPath'].'datatosmarty.class.php';
require_once $this->cmpController->config['modelPath'].'formvalidate.class.php';

$slide_lexicon = new dataToSmarty();
$my_lexicon = $slide_lexicon->smartyLexicon($modx->lexicon->fetch('slideshowmanager'));
$modx->smarty->assign('_lang', $my_lexicon );

$modx->regClientStartupScript('/assets/components/slideshowmanager/slideshowmanager.js');

$modx->regClientCSS(MODX_ASSETS_URL.'components/slideshowmanager/css/layout.css');
$modx->regClientCSS(MODX_ASSETS_URL.'components/slideshowmanager/css/form.css');

// get the a - modxAction id
if ( !isset($a) ) {
    if ( isset($_REQUEST['a']) ) {
        $a = $_REQUEST['a'];
    }
}
// if form has been submitted then process it
$viewOutput = '';
if ( isset($_POST) ) {
    $folder = isset($_REQUEST['pfolder']) ? str_replace(array('/','\\','..'),'',$_REQUEST['pfolder']) : '';
    $f = $this->cmpController->config['corePath'].'processors/mgr/'.$folder.'/'.$this->action.'.php';
    if (file_exists($f)) {
        //$viewHeader .= 'Process me';
        $viewOutput .= include $f;
        if ( !empty($viewOutput)){
            $viewOutput = '<div id="jgMessage">
                    '.$viewOutput.'
                    <p><a href="?a='.$a.'&amp;album_id='.$album_id.'">Return to Album</a></p>
                </div>';
        }
    }
} 

/*
 * should there be any default values?
 */

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
        //'slide_edit' => '?a='.$a.'&amp;action=editslide&amp;album_id='.$album_id 
        );
$modx->smarty->assign('_url',$url_array);
$modx->smarty->assign('a',$a);
$modx->smarty->assign('edit_me',$edit_me);
// the config options
$modx->smarty->assign('_myconfig', $this->cmpController->config);

return $viewOutput.$modx->smarty->fetch( MODX_CORE_PATH.'components/slideshowmanager/templates/manageslides.tpl' ); 